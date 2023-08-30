<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Mumara SMS</title>
  <link rel="shortcut icon" href="/public/assets/images/favicon.ico" />
  <link rel="stylesheet" href="/public/assets/font/font.css" />
  <script>
        var token = "{{ csrf_token() }}";
 </script>
  @include('partials.styles')
  @yield('style')
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height: 55px;--kt-toolbar-height-tablet-and-mobile: 55px;">
    
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            @include('partials.sidebar')
          <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            
            @include('partials.header')

            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
              <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container">
          
                  @include('partials.breadcrumb')
                  @yield('content')
                
                </div> 
              </div>
            </div>
            @include('partials.scrollTop')

            @include('partials.footer')
          </div>
        </div>
      </div>

    @include('partials.scripts')
    @yield('script')
      
</body>
</html>