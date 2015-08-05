<section class="pagebar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @yield('breadcrumbs')
                <h3 class="page-title">{{ $pageTitle or 'Page title' }}</h3>
            </div>
            @if (isset($trashLink))
                <div class="col-md-6 text-right">
                    <a href="{{ url($trashLink) }}" class="btn btn-dark"><i class="fa fa-fw fa-trash"></i> Trash ({{ $totalTrash or '0' }})</a>
                </div>
            @endif
        </div>
    </div>
</section>