@extends('backend/layout')
@section('content')
{{ HTML::script('ckeditor/ckeditor.js') }}
<div class="container">
    <div class="page-header">
        <h3>
            Blog Post Update
            <div class="pull-right">
                <button class="btn btn-primary" type="submit">Back</button>
            </div>
        </h3>
    </div>
    {{ Form::open(array('action' => array('App\Controllers\Admin\PageController@update', $page->id), 'method' => 'PATCH')) }}
    <!-- Title -->
    <div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
        <label class="control-label" for="title">Title</label>

        <div class="controls">
            {{ Form::text('title', $page->title, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Title', 'value'=>Input::old('title'))) }}
            @if ($errors->first('title'))
            <span class="help-block">{{ $errors->first('title') }}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Content -->
    <div class="control-group {{ $errors->has('content') ? 'has-error' : '' }}">
        <label class="control-label" for="title">Content</label>

        <div class="controls">
            {{ Form::textarea('content', $page->content, array('class'=>'form-control', 'id' => 'content', 'placeholder'=>'Content', 'value'=>Input::old('content'))) }}
            @if ($errors->first('content'))
            <span class="help-block">{{ $errors->first('content') }}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Menu -->
    <div class="control-group {{ $errors->has('is_menu') ? 'has-error' : '' }}">

        <div class="controls">
            <label class="checkbox">{{ Form::checkbox('is_menu', 'is_menu', $page->is_menu) }} Is Menu</label>
            @if ($errors->first('is_menu'))
            <span class="help-block">{{ $errors->first('is_menu') }}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Form actions -->
    {{ Form::submit('Update', array('class' => 'btn btn-success')) }}
    {{ Form::close() }}
    <script>
        window.onload = function () {
            CKEDITOR.replace('content', {
                "filebrowserBrowseUrl": "{{ url('filemanager/show') }}"
            });
        };
    </script>
</div>
@stop