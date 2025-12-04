<!-- Logo & Newsletter Section -->
<div class="py-5" style="background-color: <?php echo e($storeSettings['color_category_bar'] ?? '#f0f8ff'); ?>; color: #212529;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                <img src="<?php echo e(asset('logo.svg')); ?>" alt="LosFit" style="height: 90px; width: auto;" class="mb-3">
                <p class="text-dark opacity-75 mb-0 fw-semibold">A Elegância veste o estilo com conforto e saúde!</p>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center justify-content-md-end">
                <div class="w-100" style="max-width: 400px;">
                    <h5 class="text-dark mb-3 fw-bold">📧 Newsletter</h5>
                    <p class="text-dark small mb-3">Receba ofertas exclusivas e ganhe <strong class="text-danger">15% OFF</strong> na primeira compra!</p>
                    <form class="d-flex">
                        <input type="email" class="form-control bg-white border border-secondary" placeholder="seu@email.com" required>
                        <button class="btn btn-danger text-white fw-bold px-4 ms-2" type="submit">
                            Inscrever
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google Maps Section -->
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($storeSettings['google_maps_embed_url']) && !empty($storeSettings['google_maps_embed_url'])): ?>
<div class="pb-5" style="background-color: <?php echo e($storeSettings['color_category_bar'] ?? '#f0f8ff'); ?>;">
    <div class="container">
        <div class="rounded-4 overflow-hidden shadow-lg border border-white">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(str_contains($storeSettings['google_maps_embed_url'], '<iframe')): ?>
                <div class="ratio ratio-21x9" style="max-height: 400px;">
                    <?php echo $storeSettings['google_maps_embed_url']; ?>

                </div>
            <?php else: ?>
                <iframe src="<?php echo e($storeSettings['google_maps_embed_url']); ?>" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<!-- Main Footer Section -->
<footer class="text-white pt-5 pb-3 mt-0" style="background-color: #000000;">
    <div class="container">
        <!-- Main Content Section -->
        <div class="row mb-4">
            <!-- Column 1: Contact Info -->
            <div class="col-md-3 mb-4">
                <h6 class="text-warning text-uppercase fw-bold mb-3">📍 Contato</h6>
                <div class="text-light opacity-75 small lh-lg">
                    <p class="mb-2">
                        <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                        <?php echo nl2br(e($storeSettings['store_address'] ?? 'Endereço não configurado')); ?>

                    </p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($storeSettings['store_phone'])): ?>
                        <p class="mb-2">
                            <i class="bi bi-whatsapp text-warning me-2"></i>
                            <a href="tel:<?php echo e($storeSettings['store_phone']); ?>" class="text-light text-decoration-none">
                                <?php echo e($storeSettings['store_phone']); ?>

                            </a>
                        </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <p class="mb-0">
                        <i class="bi bi-building text-warning me-2"></i>
                        CNPJ: <?php echo e($storeSettings['store_cnpj'] ?? 'N/A'); ?>

                    </p>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="col-md-3 mb-4">
                <h6 class="text-warning text-uppercase fw-bold mb-3">🔗 Links Rápidos</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none d-flex align-items-center" onclick="openModal('about'); return false;">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Sobre Nós
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none d-flex align-items-center" onclick="openModal('careers'); return false;">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Trabalhe Conosco
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none d-flex align-items-center">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Blog
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none d-flex align-items-center" onclick="openModal('contact'); return false;">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Fale Conosco
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Support -->
            <div class="col-md-3 mb-4">
                <h6 class="text-warning text-uppercase fw-bold mb-3">❓ Ajuda</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none d-flex align-items-center" onclick="openModal('returns'); return false;">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Trocas e Devoluções
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none d-flex align-items-center" onclick="openModal('faq'); return false;">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Perguntas Frequentes
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?php echo e(route('user.orders')); ?>" class="text-light text-decoration-none d-flex align-items-center">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Rastrear Pedido
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light text-decoration-none d-flex align-items-center" onclick="openModal('privacy'); return false;">
                            <i class="bi bi-chevron-right text-warning me-2 small"></i>Política de Privacidade
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: My Account -->
            <div class="col-md-3 mb-4">
                <h6 class="text-warning text-uppercase fw-bold mb-3">👤 Minha Conta</h6>
                <div class="d-grid gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Fazer Login
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-warning text-dark btn-sm fw-bold">
                            <i class="bi bi-person-plus me-2"></i>Criar Conta
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('customer.account.profile.edit')); ?>" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-person me-2"></i>Meu Perfil
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <a href="<?php echo e(route('user.orders')); ?>" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-box-seam me-2"></i>Meus Pedidos
                    </a>
                    <a href="#" class="btn btn-outline-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist">
                        <i class="bi bi-heart me-2"></i>Favoritos
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment & Security Section -->
        <div class="row py-4 border-top border-secondary border-opacity-25">
            <div class="col-md-6 mb-3 mb-md-0 text-center text-md-start">
                <h6 class="text-secondary text-uppercase small fw-bold mb-3">💳 Formas de Pagamento</h6>
                <div class="d-flex gap-3 justify-content-center justify-content-md-start flex-wrap fs-3 text-light opacity-75">
                    <i class="bi bi-credit-card-2-front" title="Cartão de Crédito"></i>
                    <i class="bi bi-credit-card" title="Débito"></i>
                    <i class="bi bi-bank" title="Boleto"></i>
                    <i class="bi bi-qr-code" title="PIX"></i>
                    <span class="badge bg-success px-3 py-2 fs-6 align-middle">PIX -5%</span>
                </div>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <h6 class="text-secondary text-uppercase small fw-bold mb-3">🔒 Compra Segura</h6>
                <div class="d-flex gap-3 justify-content-center justify-content-md-end align-items-center">
                    <i class="bi bi-shield-lock-fill text-success fs-3" title="Site Seguro"></i>
                    <i class="bi bi-file-lock2 text-success fs-3" title="SSL"></i>
                    <span class="badge bg-success px-3 py-2">
                        <i class="bi bi-truck me-2"></i>FRETE GRÁTIS*
                    </span>
                </div>
            </div>
        </div>

        <!-- Bottom: Copyright -->
        <div class="py-3 text-center border-top border-secondary border-opacity-25">
            <p class="text-light opacity-50 small mb-0">
                © <?php echo e(date('Y')); ?> <strong>LosFit</strong> - Todos os direitos reservados | Desenvolvido com ❤️
            </p>
        </div>
    </div>
</footer>

<!-- Modais Informativos -->
<div id="infoModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark fw-bold" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent" style="white-space: pre-wrap;">
                <!-- Content loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modalContents = {
        about: {
            title: 'Sobre Nós',
            content: `<?php echo addslashes($storeSettings['modal_about'] ?? 'Conteúdo não configurado. Configure em Admin > Configurações.'); ?>`
        },
        careers: {
            title: 'Trabalhe Conosco',
            content: `<?php echo addslashes($storeSettings['modal_careers'] ?? 'Conteúdo não configurado. Configure em Admin > Configurações.'); ?>`
        },
        contact: {
            title: 'Contato',
            content: `<?php echo addslashes($storeSettings['modal_contact'] ?? 'Conteúdo não configurado. Configure em Admin > Configurações.'); ?>`
        },
        returns: {
            title: 'Trocas e Devoluções',
            content: `<?php echo addslashes($storeSettings['modal_returns'] ?? 'Conteúdo não configurado. Configure em Admin > Configurações.'); ?>`
        },
        faq: {
            title: 'FAQ - Perguntas Frequentes',
            content: `<?php echo addslashes($storeSettings['modal_faq'] ?? 'Conteúdo não configurado. Configure em Admin > Configurações.'); ?>`
        },
        privacy: {
            title: 'Política de Privacidade',
            content: `<?php echo addslashes($storeSettings['modal_privacy'] ?? 'Conteúdo não configurado. Configure em Admin > Configurações.'); ?>`
        }
    };

    function openModal(type) {
        const modal = document.getElementById('infoModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalContent = document.getElementById('modalContent');
        
        if (modalContents[type]) {
            modalTitle.textContent = modalContents[type].title;
            modalContent.innerHTML = modalContents[type].content;
            
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    }
</script>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/shop/partials/footer.blade.php ENDPATH**/ ?>