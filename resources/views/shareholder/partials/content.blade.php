<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <div>
                        <h4 class="header-title">@yield('page-title')</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-0">
                    @yield('page-content')
                </div>
            </div>
        </div>
        @include('shareholder.partials.footer')
    </div>
</div>
