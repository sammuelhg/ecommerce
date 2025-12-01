<button class="nav-link p-2 text-white position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
    <i class="bi bi-cart4 fs-5"></i>
    @if($count > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">
            {{ $count }}
        </span>
    @endif
</button>
