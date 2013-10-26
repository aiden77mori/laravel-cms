<!DOCTYPE html>
<html>
<head>
    <title>sf CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS are placed here -->
    {{ HTML::style('bootstrap/theme.css') }}
    {{ HTML::style('bootstrap/css/backend_bootstrap.css') }}
    {{ HTML::style('bootstrap/css/bootstrap-theme.css') }}
    <style>
        @section('styles')
			body {
                 padding-top: 100px;
			}
        @show
    </style>
</head>
<body>
@include('backend/menu')
@yield('content')
@include('backend/footer')
<div class="modal" id="addWidgetModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Widget</h4>
            </div>
            <div class="modal-body">
                <p>Add a widget stuff here..</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn">Close</a>
                <a href="#" class="btn btn-primary">Save changes</a>
            </div>
        </div>
    </div>
</div>
{{ HTML::script('assets/js/jquery.js') }}
{{ HTML::script('bootstrap/js/bootstrap.min.js') }}
{{ HTML::script('bootstrap/js/holder.js') }}
</body>
</html>
