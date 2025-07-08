<!doctype html>
<html class="no-js" lang="">
   <head>
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <title>@if(!empty($meta_title)){{ $meta_title }} @else Samling @endif</title>
      @if(!empty($meta_description))<meta name="description" content="{{ $meta_description }}">@endif
    
      @if(!empty($meta_keywords))<meta name="keywords" content="{{ $meta_keywords }}">@endif
      <link rel="icon" type="image/png" href="{{ asset('front/images/fav-icon.png') }}">
      <!-- Stylesheets -->
      <link href="{{ url('front/css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/flipclock.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/style.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/stylesheet.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/owl.carousel.min.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/owl.theme.default.min.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/jquery.fancybox.min.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/intlTelInput.min.css') }}" rel="stylesheet">
      <!-- Responsive -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
      <link href="{{ url('front/css/bootstrap-margin-padding.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/responsive.css') }}" rel="stylesheet">
      <link href="{{ url('front/css/custom.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
      <style>
         .VIpgJd-ZVi9od-ORHb-OEVmcd{
            display: none !important;
         }
      </style>
      <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=657983cd64d64c00127f1389&product=sop' async='async'></script>
      <!-- Google tag (gtag.js) -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-JKVN5M7SPW"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-JKVN5M7SPW');
      </script>
      <!-- Event snippet for Avtale bestilt conversion page -->
      <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-16615067647/8drACOOe9-gaEP-f1_I9',
            'value': 1.0,
            'currency': 'NOK'
        });
      </script>
   </head>
   <body>
      <div class="PleaseWaitDiv" style="display:none;">
         <!-- <img src="{{asset('images/logo.png')}}" /> -->
         <b><p style="color: #000;">Please wait...</p></b>
      </div>
      <!-- <div class="loader">
         <img src="{{ asset('front/images/loaders/loader.gif') }}" alt="loading..." />
      </div> -->
      <!-- Preloader -->
      <div class="preloader"></div>
        @include('front.layout.header')
        @yield('content')
        @include('front.layout.footer')
        @include('front.layout.modals')
        @include('front.layout.scripts')
    </body>
</html>
