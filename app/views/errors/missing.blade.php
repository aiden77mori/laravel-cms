{{ HTML::style('bootstrap/css/backend_bootstrap.css') }}
{{ HTML::style('bootstrap/css/theme.css') }}
<div class="container">
  <div class="row">
    <div class="span12">
      <div class="hero-unit center">
          <h1>Page Not Found <small><font face="Tahoma" color="red">Error 404</font></small></h1>
          <br />
          <p>The page you requested could not be found, either contact your webmaster or try again. Use your browsers <b>Back</b> button to navigate to the page you have prevously come from</p>
          <p><b>Or you could just press this neat little button:</b></p>

          @if (Request::is('admin/*'))
          <a href="{{ url('/admin') }}" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take Me Home</a>
          @else
          <a href="{{ url('/') }}" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Take Me Home</a>
          @endif
        </div>
    </div>
  </div>
</div>