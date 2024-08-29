
    @if ($message = Session::get('primary'))
        <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-information me-2"></i> </strong>{{ $message }}
        </div>
    @endif
    @if ($message = Session::get('secondary'))
        <div class="alert alert-secondary alert-dismissible bg-secondary text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-information me-2"></i> </strong>{{ $message }}
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-checkmark me-2"></i> </strong>{{ $message }}
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-wrong me-2"></i> </strong>{{ $message }}
        </div>
    @endif
    @if ($message = Session::get('warning'))
        <div class="alert bg-warning text-dark border-0 alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-warning me-2"></i> </strong>{{ $message }}
        </div>
    @endif
    @if ($message = Session::get('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-information me-2"></i> </strong>{{ $message }}
        </div>
    @endif
    @if ($message = Session::get('light'))
        <div class="alert alert-light alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-information me-2"></i> </strong>{{ $message }}
        </div>
    @endif
    @if ($message = Session::get('dark'))
        <div class="alert alert-dark alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="dripicons-information"></i> </strong>{{ $message }}
        </div>
    @endif

