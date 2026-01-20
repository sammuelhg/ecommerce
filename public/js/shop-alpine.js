function shopApp() {
    return {
        products: [],
        cart: [],
        wishlist: [],
        alerts: [],
        alertId: 0,

        // Search & Filter
        searchQuery: '',
        category: 'Todos',
        focused: false,
        recentSearches: [],
        showMobileSearch: false,
        isLoading: false,
        filteredProducts: [],

        get isQueryEmpty() { return this.searchQuery.trim() === ''; },
        get defaultSuggestions() {
            // Return 5 random items as suggestions
            return this.products.sort(() => 0.5 - Math.random()).slice(0, 5);
        },
        get cartTotalItems() { return this.cart.reduce((s, i) => s + i.qty, 0); },
        get cartSubtotal() { return this.cart.reduce((s, i) => s + (i.price * i.qty), 0); },
        get offerProducts() { return this.products.filter(p => p.isOffer); },

        init() {
            this.products = window.DB_PRODUCTS || [];
            this.loadFromStorage();
            this.setupWatchers();
            this.loadSearchHistory();
            this.filterProducts(); // Initial filter pass

            // Background sync for guests if localStorage has items but server doesn't
            if (window.IS_GUEST && this.cart.length > 0 && (!window.SERVER_CART || window.SERVER_CART.length === 0)) {
                this.syncWithServer(true); // silent sync
            }

            // Watch for search query
            this.$watch('searchQuery', () => this.filterProducts());
        },

        onCategoryChange() {
            this.focused = true; // Keep list open
            this.filterProducts();
        },

        filterProducts() {
            this.isLoading = true;
            setTimeout(() => {
                let results = this.products;

                // Simple text filter for now as discussed
                if (this.searchQuery.trim() !== '') {
                    const q = this.searchQuery.toLowerCase();
                    results = results.filter(p => p.name.toLowerCase().includes(q));
                }

                // Note: Category filtering is purely visual/placeholder for now 
                // until products have category property injected.
                // We rely on 'performSearch' redirect for real filtering.

                this.filteredProducts = results.slice(0, 10);
                this.isLoading = false;
            }, 100);
        },

        getCategoryName() {
            const map = {
                'Todos': 'Todos',
                'acessorios': 'Acessórios',
                'losfitnutri': 'LosfitNutri',
                'croche': 'Moda Crochê',
                'fit': 'Moda Fit',
                'praia': 'Moda Praia',
                'suplementos': 'Suplementos'
            };
            return map[this.category] || this.category;
        },

        selectItem(name) {
            this.searchQuery = name;
            this.performSearch();
        },

        goToProduct(product) {
            window.location.href = `/loja/produto/${product.id}`;
        },

        performSearch() {
            if (this.searchQuery.trim()) {
                if (!this.recentSearches.includes(this.searchQuery)) {
                    this.recentSearches.unshift(this.searchQuery);
                    if (this.recentSearches.length > 10) this.recentSearches.pop();
                    localStorage.setItem('recentSearches', JSON.stringify(this.recentSearches));
                }
            }

            let url = `/loja/busca?q=${encodeURIComponent(this.searchQuery)}`;
            if (this.category !== 'Todos') {
                url += `&categoria=${encodeURIComponent(this.category)}`;
            }
            window.location.href = url;
        },

        loadSearchHistory() { const s = localStorage.getItem('recentSearches'); if (s) this.recentSearches = JSON.parse(s); },

        loadFromStorage() {
            const storedCart = localStorage.getItem('myShopCart');
            const localItems = storedCart ? JSON.parse(storedCart) : [];
            const serverItems = window.SERVER_CART || [];

            // MERGE LOGIC
            const mergedMap = new Map();

            serverItems.forEach(item => {
                if (!item.imageText && item.image) item.imageText = item.image;
                mergedMap.set(item.id, { ...item });
            });

            localItems.forEach(localItem => {
                if (mergedMap.has(localItem.id)) {
                    const serverItem = mergedMap.get(localItem.id);
                    serverItem.qty = localItem.qty; // Trust local
                } else {
                    const fresh = this.products.find(p => p.id === localItem.id);
                    if (fresh) {
                        mergedMap.set(localItem.id, { ...fresh, qty: localItem.qty });
                    } else {
                        mergedMap.set(localItem.id, localItem);
                    }
                }
            });

            this.cart = Array.from(mergedMap.values());
            localStorage.setItem('myShopCart', JSON.stringify(this.cart));

            // Restore Wishlist
            const storedWishlist = localStorage.getItem('myShopWishlist');
            if (storedWishlist) {
                const parsed = JSON.parse(storedWishlist);
                this.wishlist = parsed.map(item => {
                    const fresh = this.products.find(p => p.id === item.id);
                    return fresh ? fresh : item;
                });
            }

            // FORCE SYNC if Logged In
            if (!window.IS_GUEST && this.cart.length > 0) {
                this.syncWithServer(true);
            }
        },

        syncTimer: null,
        setupWatchers() {
            this.$watch('cart', v => {
                localStorage.setItem('myShopCart', JSON.stringify(v));
                clearTimeout(this.syncTimer);
                this.syncTimer = setTimeout(() => {
                    this.syncWithServer(true);
                }, 500);
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
                    body: JSON.stringify({ cart: this.cart, background: silent }),
                    keepalive: true
                });

                if (!silent) {
                    window.Livewire.dispatch('cartUpdated');
                }
            } catch (error) {
                console.error('Error syncing cart:', error);
            }
        },

        async finalizePurchase() {
            if (this.cart.length === 0) return;
            await this.syncWithServer(false);
            window.location.href = '/loja/checkout';
        },

        addToCart(product, quantity = 1) {
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
        },

        removeFromCart(id) {
            this.cart = this.cart.filter(i => i.id !== id);
            this.showAlert('Produto removido do carrinho.', 'danger');
        },

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
            setTimeout(() => { window.dispatchEvent(new CustomEvent('wishlist-updated')); }, 50);
        },

        showAlert(msg, type = 'info') {
            if (type === 'danger') type = 'error';
            window.dispatchEvent(new CustomEvent('toast-' + type, { detail: msg }));
        },

        truncate(text, len) { return text.length > len ? text.substring(0, len) + '...' : text; },
        formatCurrency(v) { return v.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); }
    };
}

// Listen to beforeunload to flush pending changes
window.addEventListener('beforeunload', () => {
    // Keepalive handles the sync
});
