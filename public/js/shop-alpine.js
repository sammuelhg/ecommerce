function shopApp() {
    return {
        products: [],
        cart: [],
        wishlist: [],
        alerts: [],
        alertId: 0,
        // Busca
        searchQuery: '',
        recentSearches: [],
        showMobileSearch: false,
        init() {
            this.products = window.DB_PRODUCTS || [];
            this.loadFromStorage();
            this.setupWatchers();
            this.loadSearchHistory();

            // Background sync for guests if localStorage has items but server doesn't
            if (window.IS_GUEST && this.cart.length > 0 && (!window.SERVER_CART || window.SERVER_CART.length === 0)) {
                this.syncWithServer(true); // silent sync
            }
        },
        loadFromStorage() {
            // Prioritize Server Cart if available and not empty (Source of Truth for logged users)
            // For guests, if server is empty but local has items, use local
            const storedCart = localStorage.getItem('myShopCart');
            const hasStoredItems = storedCart && JSON.parse(storedCart).length > 0;

            if (window.SERVER_CART && window.SERVER_CART.length > 0) {
                this.cart = window.SERVER_CART.map(item => {
                    // Ensure imageText is set if missing (compatibility)
                    if (!item.imageText && item.image) item.imageText = item.image;
                    return item;
                });
                // Sync localStorage with Server Cart
                localStorage.setItem('myShopCart', JSON.stringify(this.cart));
            } else if (window.IS_GUEST && hasStoredItems) {
                // Fallback to localStorage if guest and server is empty
                const parsedCart = JSON.parse(storedCart);
                this.cart = parsedCart.map(item => {
                    const fresh = this.products.find(p => p.id === item.id);
                    return fresh ? { ...fresh, qty: item.qty } : item;
                });
            } else {
                this.cart = [];
            }

            const storedWishlist = localStorage.getItem('myShopWishlist');
            if (storedWishlist) {
                const parsed = JSON.parse(storedWishlist);
                this.wishlist = parsed.map(item => {
                    const fresh = this.products.find(p => p.id === item.id);
                    return fresh ? fresh : item;
                });
            }
        },
        setupWatchers() {
            this.$watch('cart', v => {
                localStorage.setItem('myShopCart', JSON.stringify(v));
                // If it's a guest, we might want to sync with session periodically or on change?
                // For now, let's keep it in sync for checkout button
            });
            this.$watch('wishlist', v => localStorage.setItem('myShopWishlist', JSON.stringify(v)));
        },
        async syncWithServer(silent = false) {
            if (this.cart.length === 0) return;

            try {
                await fetch('/loja/carrinho/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cart: this.cart, background: silent })
                });

                // If not silent, we might want to refresh Livewire components
                if (!silent) {
                    window.Livewire.dispatch('cartUpdated');
                }
            } catch (error) {
                console.error('Error syncing cart:', error);
            }
        },
        get cartTotalItems() { return this.cart.reduce((s, i) => s + i.qty, 0); },
        get cartSubtotal() { return this.cart.reduce((s, i) => s + (i.price * i.qty), 0); },
        get offerProducts() { return this.products.filter(p => p.isOffer); },
        formatCurrency(v) { return v.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); },
        addToCart(product, quantity = 1) {
            console.log('Adding to cart:', product, quantity);
            const ex = this.cart.find(i => i.id === product.id);
            if (ex) {
                ex.qty += quantity;
                this.showAlert(`Mais ${quantity} item(s) de "${this.truncate(product.name, 20)}" adicionado!`, 'success');
            } else {
                const item = { ...product, qty: quantity };
                if (!item.imageText && item.image) item.imageText = item.image;
                this.cart.push(item);
                this.showAlert(`"${this.truncate(product.name, 20)}" adicionado ao carrinho!`, 'success');
            }
            console.log('Cart updated:', this.cart);
        },
        removeFromCart(id) { this.cart = this.cart.filter(i => i.id !== id); this.showAlert('Produto removido do carrinho.', 'danger'); },
        updateQty(item) { if (item.qty < 1) item.qty = 1; },
        isInWishlist(id) {
            if (!Array.isArray(this.wishlist)) return false;
            return this.wishlist.some(i => i.id === id);
        },
        toggleWishlist(product) {
            if (this.isInWishlist(product.id)) {
                this.wishlist = this.wishlist.filter(i => i.id !== product.id);
                this.showAlert(`"${this.truncate(product.name, 20)}" removido da lista.`, 'danger');
            } else {
                this.wishlist.push(product);
                this.showAlert(`"${this.truncate(product.name, 20)}" salvo na lista de desejos!`, 'success');
            }
            // Notify other components (like product cards) to re-check their state
            setTimeout(() => { window.dispatchEvent(new CustomEvent('wishlist-updated')); }, 50);
        },
        showAlert(msg, type = 'info') {
            // Map 'danger' to 'error' for compatibility with toasts.blade.php
            if (type === 'danger') type = 'error';
            window.dispatchEvent(new CustomEvent('toast-' + type, { detail: msg }));
        },
        truncate(text, len) { return text.length > len ? text.substring(0, len) + '...' : text; },
        performSearch() {
            if (!this.searchQuery.trim()) return;
            // Salva no histórico
            if (!this.recentSearches.includes(this.searchQuery)) {
                this.recentSearches.unshift(this.searchQuery);
                if (this.recentSearches.length > 10) this.recentSearches.pop();
                localStorage.setItem('recentSearches', JSON.stringify(this.recentSearches));
            }
            // Redireciona para a página de busca
            window.location.href = `/loja/busca?q=${encodeURIComponent(this.searchQuery)}`;
        },
        async finalizePurchase() {
            if (this.cart.length === 0) return;

            // Show loading state if needed, or just redirect
            this.showAlert('Processando...', 'info');

            try {
                const response = await fetch('/loja/carrinho/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cart: this.cart })
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                } else {
                    console.error('Failed to sync cart');
                    this.showAlert('Erro ao finalizar compra. Tente novamente.', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showAlert('Erro ao conectar com o servidor.', 'danger');
            }
        },

        loadSearchHistory() { const s = localStorage.getItem('recentSearches'); if (s) this.recentSearches = JSON.parse(s); }
    };
}
