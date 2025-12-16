<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Fale Conosco</h3>
                @if(!empty($data['email']))
                    <p class="lead">Envie um email para: <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
                @endif
                
                @if(!empty($data['show_form']) && $data['show_form'])
                    <div class="card shadow-sm text-start mt-4">
                        <div class="card-body p-4">
                            @livewire('shop.contact-form') 
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
