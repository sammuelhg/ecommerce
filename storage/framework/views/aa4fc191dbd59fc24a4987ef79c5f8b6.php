<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
        <!-- Logo & Info -->
        <div class="row mb-4">
            <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
                <img src="<?php echo e(asset('logo.svg')); ?>" alt="LosFit" style="height: 90px; width: auto;" class="mb-3">
                <div class="text-light opacity-75 small">
                    <p class="mb-1">Rua da Moda Fitness, 123 - Centro</p>
                    <p class="mb-1">São Paulo - SP, CEP 01000-000</p>
                    <p class="mb-0">CNPJ: 12.345.678/0001-90</p>
                </div>
            </div>
            <div class="col-12 col-md-6 text-center text-md-end d-flex flex-column justify-content-center">
                <div class="mb-3">
                    <h6 class="text-secondary text-uppercase small fw-bold mb-2">Formas de Pagamento</h6>
                    <div class="d-flex gap-2 justify-content-center justify-content-md-end fs-4 text-light">
                        <i class="bi bi-credit-card-2-front" title="Cartão de Crédito"></i>
                        <i class="bi bi-credit-card" title="Mastercard"></i>
                        <i class="bi bi-bank" title="Boleto"></i>
                        <i class="bi bi-qr-code" title="Pix"></i>
                    </div>
                </div>
                <div>
                    <h6 class="text-secondary text-uppercase small fw-bold mb-2">Segurança</h6>
                    <div class="d-flex gap-2 justify-content-center justify-content-md-end fs-4 text-light">
                        <i class="bi bi-shield-lock-fill text-success" title="Site Seguro"></i>
                        <i class="bi bi-file-lock2" title="Dados Criptografados"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row border-top border-bottom border-secondary py-4 mb-4">
            <div class="col-6 col-md-3 mb-3">
                <h5 class="text-secondary mb-3">A Loja</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Sobre Nós</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Trabalhe Conosco</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Blog</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <h5 class="text-secondary mb-3">Suporte</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Contato</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Trocas e Devoluções</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">FAQ</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <h5 class="text-secondary mb-3">Conta</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Entrar / Registrar</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Meus Pedidos</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Lista de Desejos</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h5 class="text-secondary mb-3">Newsletter</h5>
                <p class="text-light mb-3">Inscreva-se e ganhe 10% de desconto na primeira compra.</p>
                <form class="d-flex">
                    <input type="email" class="form-control rounded-start" placeholder="Seu e-mail">
                    <button class="btn btn-secondary rounded-end fw-semibold" type="submit">Enviar</button>
                </form>
            </div>
        </div>
        <div class="text-center text-light small">
            <span>© <?php echo e(date('Y')); ?> LosFit. Todos os direitos reservados.</span>
        </div>
    </div>
</footer>
<?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/shop/partials/footer.blade.php ENDPATH**/ ?>