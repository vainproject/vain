<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title') @lang('vain::meta.title.app')</title>

    <meta name="keywords" content="@yield('keywords', trans('vain::meta.keywords'))">
    <meta name="description" content="@yield('description', trans('vain::meta.description'))">
    <meta name="robots" content="index,follow">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,700|Merriweather:400,400italic,700italic"
          rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('static/css/frontend.css') }}">
    @yield('styles')
</head>
<body>
{{-- Includes the site's main flyout menu --}}
@include('vain::layout.app.menu')

<div id="wrap">
    {{-- Includes the top navigation layer and site hero section --}}
    @include('vain::layout.app.header')

    @if(Breadcrumbs::exists())
        <section id="breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Breadcrumbs::render() !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Site main content --}}
    <div class="container content" data-pjax>

        @include('vain::partials.errors', [ 'message' => trans('vain::app.errors.input') ])

        @yield('content')
    </div>

    @include('vain::layout.app.footer')
</div>

<script type="text/javascript" src="{{ asset('static/js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
