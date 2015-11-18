<section class="pagebar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <header class="pagebar-header">
                    {!! $breadcrumbs !!}
                    <h3 class="page-title">{{ $pageTitle or 'Page title' }}</h3>
                </header>
            </div>
            @if (isset($trashLink))
                <div class="col-md-6 pagebar-right">
                    <a href="{{ url($trashLink) }}" class="btn btn-lighter"><i class="fa fa-fw fa-trash" style="vertical-align:text-bottom"></i> ({{ $totalTrash or '0' }})</a>
                </div>
            @endif
            @yield('pagebar-buttons')
        </div>
    </div>
</section>