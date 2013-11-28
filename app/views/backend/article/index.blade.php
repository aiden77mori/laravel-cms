@extends('backend/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {

        $('#message').show().delay(4000).fadeOut(700);

        // publish settings
        $(".publish").bind("click", function (e) {
            var id = $(this).attr('id');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ url('/admin/article/" + id + "/toggle-publish/') }}",
                success: function (response) {
                    if (response['result'] == 'success') {
                        var imagePath = (response['changed'] == 1) ? "{{url('/')}}/images/publish.png" : "{{url('/')}}/images/not_publish.png";
                        $("#publish-image-" + id).attr('src', imagePath);
                    }
                },
                error: function () {
                    alert("error");
                }
            })
        });
    });
</script>
<div class="container">
    @if(Session::has('message'))
    <div class="alert alert-success" id="message">
        {{ Session::get('message') }}
    </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Articles</h3>
        </div>
        <div class="panel-body">
            <div class="pull-left">
                <div class="btn-toolbar">
                    <a href="{{ URL::route('admin.article.create') }}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;New Article
                    </a>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th>Action</th>
                        <th>Settings</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $articles as $article )
                    <tr>
                        <td> {{ link_to_route( 'admin.article.show', $article->title, $article->id, array( 'class' => 'btn btn-link btn-xs' )) }}
                        <td>{{{ $article->title }}}</td>
                        <td>{{{ $article->created_at }}}</td>
                        <td>{{{ $article->updated_at }}}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    Action
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ URL::route('admin.article.show', array($article->id)) }}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Show Article
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::route('admin.article.edit', array($article->id)) }}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;Edit Article
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ URL::route('admin.article.delete', array($article->id)) }}">
                                            <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Delete Article
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                        <a href="#" id="{{ $article->id }}" class="publish">
                            <img id="publish-image-{{ $article->id }}" src="{{url('/')}}/assets/images/{{ ($article->is_published) ? 'publish.png' : 'not_publish.png'  }}"/>
                        </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="pull-left">
        <ul class="pagination">
            {{ $articles->links() }}
        </ul>
    </div>
</div>
@stop