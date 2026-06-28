@extends('layouts.app')

@section('content')
    @include('layouts.mobileheader')
    @include('layouts.sidebar')
    @include('layouts.mobilesidebar')

    <main class="dashboard-content flex-grow-1 ms-280 px-5 py-4">
        <div class="account-page">
            <header class="account-header mb-5">
                <h2>@yield('account-title')</h2>
                @hasSection('account-subtitle')
                    <p class="mt-4">@yield('account-subtitle')</p>
                @endif
            </header>

            @yield('account-content')
        </div>
    </main>

    @include('layouts.mobilenavbar')
@endsection
