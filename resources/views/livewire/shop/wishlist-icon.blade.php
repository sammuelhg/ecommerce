<button class="nav-link p-2 text-white position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist">
    <i class="bi bi-heart{{ $count > 0 ? '-fill' : '' }} fs-5" style="{{ $count > 0 ? 'color: #ffc107;' : '' }}"></i>
    @if($count > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $count }}
        </span>
    @endif
</button>
