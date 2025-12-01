function shopApp() {
    return {
        products: [],
        cart: [],
        wishlist: [],
        alerts: [],
        alertId: 0,
        showConfigPanel: false,

        // Configurações dos componentes (pode ser salvo no localStorage)
        config: {
            enableCart: true,
            enableWishlist: true,
            enableSearch: true,
            enableToasts: true
        },

        // Busca
        searchQuery: '',
        recentSearches: [],

        init() {
            this.products = window.DB_PRODUCTS || [];
            this.loadFromStorage();
            this.setupWatchers();
            this.loadConfig();
            this.loadSearchHistory();
        },

        loadConfig() {
            const saved = localStorage.getItem('shopConfig');
            if (saved) {
                this.config = JSON.parse(saved);
            }
        },

        resetConfig() {
            this.config = {
                enableCart: true,
                enableWishlist: true,
                enableSearch: true,
                enableToasts: true
            };
            localStorage.removeItem('shopConfig');
            this.showAlert('Configurações resetadas!', 'info');
        },

        loadFromStorage() {
            const storedCart = localStorage.getItem('myShopCart');
            const storedWishlist = localStorage.getItem('myShopWishlist');

            if (storedCart) {
                const parsedCart = JSON.parse(storedCart);
                this.cart = parsedCart.map(item => {
                    const freshProduct = this.products.find(p => p.id === item.id);
                    return freshProduct ? { ...freshProduct, qty: item.qty } : null;
                }).filter(item => item !== null);
            }

            if (storedWishlist) {
                const parsedWishlist = JSON.parse(storedWishlist);
                this.wishlist = parsedWishlist.map(item => {
                    const freshProduct = this.products.find(p => p.id === item.id);
                    return freshProduct || null;
                }).filter(item => item !== null);
            }
        },

        setupWatchers() {
            this.$watch('cart', val => localStorage.setItem('myShopCart', JSON.stringify(val)));
            this.$watch('wishlist', val => localStorage.setItem('myShopWishlist', JSON.stringify(val)));
            this.$watch('config', val => localStorage.setItem('shopConfig', JSON.stringify(val)));
        },

        get cartTotalItems() {
            return this.cart.reduce((sum, item) => sum + item.qty, 0);
        },

        get cartSubtotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },

        get offerProducts() {
            return this.products.filter(p => p.isOffer);
        },

        formatCurrency(value) {
            return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        },

        addToCart(product) {
            if (!this.config.enableCart) return;

            const existing = this.cart.find(item => item.id === product.id);
            if (existing) {
                existing.qty++;
                this.showAlert(`Mais um item de "${this.truncate(product.name, 20)}" adicionado!`, 'success');
            } else {
                this.cart.push({ ...product, qty: 1 });
                this.showAlert(`"${this.truncate(product.name, 20)}" adicionado ao carrinho!`, 'success');
            }
        },

        removeFromCart(id) {
            this.cart = this.cart.filter(item => item.id !== id);
            this.showAlert('Produto removido do carrinho.', 'danger');
        },

        updateQty(item) {
            if (item.qty < 1) item.qty = 1;
        },

        isInWishlist(id) {
            return this.wishlist.some(item => item.id === id);
        },

        isInCart(id) {
            return this.cart.some(item => item.id === id);
        },

        getCartQty(id) {
            const item = this.cart.find(item => item.id === id);
            return item ? item.qty : 0;
        },

        toggleWishlist(product) {
            if (!this.config.enableWishlist) return;

            if (this.isInWishlist(product.id)) {
                this.wishlist = this.wishlist.filter(item => item.id !== product.id);
                this.showAlert(`"${this.truncate(product.name, 20)}" removido da lista.`, 'danger');
            } else {
                this.wishlist.push(product);
                this.showAlert(`"${this.truncate(product.name, 20)}" salvo na lista de desejos!`, 'success');
            }
        },

        showAlert(message, type = 'info') {
            if (!this.config.enableToasts) return;

            const id = this.alertId++;
            this.alerts.push({ id, message, type });
            setTimeout(() => this.removeAlert(id), 3000);
        },

        removeAlert(id) {
            this.alerts = this.alerts.filter(a => a.id !== id);
        },

        performSearch() {
            if (!this.searchQuery.trim()) return;

            // Adiciona ao histórico
            if (!this.recentSearches.includes(this.searchQuery)) {
                this.recentSearches.unshift(this.searchQuery);
                if (this.recentSearches.length > 10) this.recentSearches.pop();
                localStorage.setItem('recentSearches', JSON.stringify(this.recentSearches));
            }

            // Aqui você pode redirecionar ou filtrar produtos
            this.showAlert(`Buscando por: "${this.searchQuery}"`, 'info');
            console.log('Busca:', this.searchQuery);
        },

        loadSearchHistory() {
            const saved = localStorage.getItem('recentSearches');
            if (saved) {
                this.recentSearches = JSON.parse(saved);
            }
        },

        truncate(text, length) {
            return text.length > length ? text.substring(0, length) + '...' : text;
        },

        // Renderiza componentes dinamicamente
        renderComponent(name) {
            const components = {
                header: this.headerComponent(),
                footer: this.footerComponent(),
                'cart-offcanvas': this.config.enableCart ? this.cartOffcanvasComponent() : '',
                'wishlist-offcanvas': this.config.enableWishlist ? this.wishlistOffcanvasComponent() : ''
            };
            return components[name] || '';
        },

        headerComponent() {
            return `
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top navbar-taller">
                    <div class="container-fluid">
                        <a class="navbar-brand text-primary fw-bold fs-3 me-2" href="#">
                            <span class="text-secondary">Loja</span>Bagisto
                        </a>
                        
                        <div class="d-flex order-lg-3 me-2">
                            ${this.config.enableSearch ? `
                            <a class="nav-link p-2 text-dark d-lg-none" href="#" title="Buscar">
                                <i class="bi bi-search fs-5"></i>
                            </a>` : ''}
                            
                            <a class="nav-link p-2 text-dark" href="#" title="Minha Conta">
                                <i class="bi bi-person-circle fs-5"></i>
                            </a>
                            
                            ${this.config.enableCart ? `
                            <a class="nav-link p-2 text-dark position-relative" href="#" 
                               data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                                <i class="bi bi-cart4 fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary text-primary"
                                      x-show="cartTotalItems > 0" x-text="cartTotalItems"></span>
                            </a>` : ''}
                            
                            ${this.config.enableWishlist ? `
                            <a class="nav-link p-2 text-dark position-relative" href="#"
                               data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist">
                                <i class="bi fs-5" :class="wishlist.length > 0 ? 'bi-heart-fill' : 'bi-heart'"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                      x-show="wishlist.length > 0" x-text="wishlist.length"></span>
                            </a>` : ''}
                        </div>
                        
                        ${this.config.enableSearch ? `
                        <div class="collapse navbar-collapse order-lg-2">
                            <form class="d-flex flex-grow-1 me-lg-4 my-2 my-lg-0 d-none d-lg-flex">
                                <input class="form-control me-2 rounded-pill" type="search" placeholder="Buscar produtos...">
                                <button class="btn btn-outline-primary rounded-circle" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                            <ul class="navbar-nav mb-2 mb-lg-0">
                                <li class="nav-item"><a class="nav-link active" href="#">Destaques</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Lançamentos</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                            </ul>
                        </div>` : ''}
                    </div>
                </nav>
            </header>
            `;
        },

        footerComponent() {
            return `
            <footer class="bg-dark text-white pt-5 pb-3 mt-5">
                <div class="container">
                    <div class="row border-bottom border-secondary pb-4 mb-4">
                        <div class="col-6 col-md-3 mb-3">
                            <h5 class="text-secondary mb-3">A Loja</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Sobre Nós</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Trabalhe Conosco</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h5 class="text-secondary mb-3">Newsletter</h5>
                            <form class="d-flex">
                                <input type="email" class="form-control rounded-start" placeholder="Seu e-mail">
                                <button class="btn btn-secondary rounded-end" type="submit">Enviar</button>
                            </form>
                        </div>
                    </div>
                    <div class="text-center text-light small">© 2025 LojaBagisto. Todos os direitos reservados.</div>
                </div>
            </footer>
            `;
        },

        cartOffcanvasComponent() {
            return `
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
                <div class="offcanvas-header bg-primary text-white border-bottom">
                    <h5 class="offcanvas-title fw-bold">
                        <i class="bi bi-cart4 me-2"></i> Seu Carrinho (<span x-text="cartTotalItems"></span>)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column">
                    <div x-show="cart.length === 0" class="p-5 text-center text-muted flex-grow-1">
                        <i class="bi bi-cart-x fs-1 mb-3"></i>
                        <p class="mb-0 fw-bold">Seu carrinho está vazio.</p>
                    </div>

                    <div class="list-group list-group-flush flex-grow-1 overflow-y-auto" x-show="cart.length > 0">
                        <template x-for="item in cart" :key="item.id">
                            <div class="list-group-item d-flex p-3 align-items-start">
                                <img :src="\`https://placehold.co/80x80/2c3e50/ffffff?text=\${item.imageText}\`" 
                                     class="rounded me-3 flex-shrink-0" style="width: 80px; height: 80px;">
                                
                                <div class="flex-grow-1 overflow-hidden me-2">
                                    <p class="mb-1 fw-bold text-dark line-clamp-2" x-text="item.name"></p>
                                    <small class="text-muted d-block">Preço: <span x-text="formatCurrency(item.price)"></span></small>
                                    <small class="text-primary fw-semibold">Total: <span x-text="formatCurrency(item.price * item.qty)"></span></small>
                                </div>
                                
                                <div class="ms-auto d-flex flex-column align-items-end">
                                    <input type="number" class="form-control form-control-sm text-center mb-2" 
                                           x-model.number="item.qty" @change="updateQty(item)" min="1" style="width: 60px;">
                                    <button class="btn btn-sm btn-outline-danger" @click="removeFromCart(item.id)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <div class="mt-auto pt-3 border-top" x-show="cart.length > 0">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="fw-bold" x-text="formatCurrency(cartSubtotal)"></span>
                        </div>
                        <div class="d-flex justify-content-between fs-5 fw-bold text-primary border-top pt-2">
                            <span>Total:</span>
                            <span x-text="formatCurrency(cartSubtotal)"></span>
                        </div>
                    </div>
                </div>
                <div class="offcanvas-footer border-top p-3" x-show="cart.length > 0">
                    <a href="#" class="btn btn-primary w-100 fw-semibold">Finalizar Compra</a>
                </div>
            </div>
            `;
        },

        wishlistOffcanvasComponent() {
            return `
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasWishlist">
                <div class="offcanvas-header bg-primary text-white border-bottom">
                    <h5 class="offcanvas-title fw-bold">
                        <i class="bi bi-heart-fill me-2"></i> Sua Lista de Desejos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div x-show="wishlist.length === 0">
                        <div class="p-5 text-center text-muted">
                            <i class="bi bi-heart-break fs-1 mb-3"></i>
                            <p class="mb-0 fw-bold">Sua lista está vazia.</p>
                        </div>
                    </div>

                    <div class="list-group list-group-flush" x-show="wishlist.length > 0">
                        <template x-for="item in wishlist" :key="item.id">
                            <div class="list-group-item d-flex align-items-center p-3">
                                <img :src="\`https://placehold.co/80x80/CCCCCC/333333?text=\${item.imageText}\`" 
                                     class="rounded me-3 flex-shrink-0" style="width: 80px; height: 80px;">
                                
                                <div class="flex-grow-1 me-2 overflow-hidden"> 
                                    <p class="mb-1 fw-bold text-dark line-clamp-2" x-text="item.name"></p>
                                    <p class="mb-0 text-primary fw-semibold" x-text="formatCurrency(item.price)"></p>
                                </div>
                                
                                <div class="ms-auto d-flex flex-column align-items-end">
                                    <button class="btn btn-sm btn-outline-danger mb-1" @click="toggleWishlist(item)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary" @click="addToCart(item)">
                                        <i class="bi bi-bag-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            `;
        }
    }
}
