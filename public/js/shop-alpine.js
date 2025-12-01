// public/js/shop-alpine.js

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
        },
        loadFromStorage() {
            const storedCart = localStorage.getItem('myShopCart');
            const storedWishlist = localStorage.getItem('myShopWishlist');
            if (storedCart) {
                const parsedCart = JSON.parse(storedCart);
                this.cart = parsedCart.map(item => {
                    const fresh = this.products.find(p => p.id === item.id);
                    return fresh ? { ...fresh, qty: item.qty } : null;
                }).filter(i => i);
            }
            if (storedWishlist) {
                const parsed = JSON.parse(storedWishlist);
                this.wishlist = parsed.map(item => {
                    const fresh = this.products.find(p => p.id === item.id);
                    return fresh ? fresh : null;
                }).filter(i => i);
            }
        },
        setupWatchers() {
            this.$watch('cart', v => localStorage.setItem('myShopCart', JSON.stringify(v)));
            this.$watch('wishlist', v => localStorage.setItem('myShopWishlist', JSON.stringify(v)));
        },
        get cartTotalItems() { return this.cart.reduce((s, i) => s + i.qty, 0); },
        get cartSubtotal() { return this.cart.reduce((s, i) => s + (i.price * i.qty), 0); },
        get offerProducts() { return this.products.filter(p => p.isOffer); },
        formatCurrency(v) { return v.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); },
        addToCart(product) {
            console.log('Adding to cart:', product);
            const ex = this.cart.find(i => i.id === product.id);
            if (ex) {
                ex.qty++;
                this.showAlert(`Mais um item de "${this.truncate(product.name, 20)}" adicionado!`, 'success');
            } else {
                const item = { ...product, qty: 1 };
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
        },
        showAlert(msg, type = 'info') { const id = this.alertId++; this.alerts.push({ id, msg, type }); setTimeout(() => this.removeAlert(id), 3000); },
        removeAlert(id) { this.alerts = this.alerts.filter(a => a.id !== id); },
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
        loadSearchHistory() { const s = localStorage.getItem('recentSearches'); if (s) this.recentSearches = JSON.parse(s); }
    };
}
