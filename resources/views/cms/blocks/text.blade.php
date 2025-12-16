<section class="py-5">
    <div class="container">
        <div class="row {{ ($data['alignment'] ?? 'left') === 'center' ? 'justify-content-center' : '' }}">
            <div class="col-lg-8">
                @if(!empty($data['title']))
                    <h2 class="mb-4">{{ $data['title'] }}</h2>
                @endif
                <div class="cms-content">
                    {!! $data['content'] !!}
                </div>
            </div>
        </div>
    </div>
</section>
