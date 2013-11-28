@extends('backend/layout')
@section('content')
{{ HTML::script('ckeditor/ckeditor.js') }}
{{ HTML::style('dropzone/css/basic.css') }}
{{ HTML::style('dropzone/css/dropzone.css') }}
{{ HTML::script('dropzone/dropzone.js') }}
<div class="container">
    <div class="page-header">
        <h3>
            Photo Gallery Update
            <div class="pull-right">
                {{ HTML::link('/admin/photo_gallery','Back', array('class'=>'btn btn-primary')) }}
            </div>
        </h3>
    </div>
    <!-- Dropzone -->
    <label class="control-label" for="title">Images</label>

    <div style="width: 700px; min-height: 300px; height: auto; border:1px solid slategray;" id="dropzone">
        {{ Form::open(array('url' => 'admin/upload/' . $photo_gallery->id, 'class'=>'dropzone', 'id'=>'my-dropzone')) }}
        <!-- Single file upload
        <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
        -->
        <!-- Multiple file upload-->
        <div class="fallback">
            <input name="file" type="file" multiple/>
        </div>
        <br>
        <br>
        {{ Form::close() }}
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            // myDropzone is the configuration for the element that has an id attribute
            // with the value my-dropzone (or myDropzone)
            Dropzone.options.myDropzone = {
                init: function () {
                    this.on("addedfile", function (file) {

                        var removeButton = Dropzone.createElement('<a class="dz-remove">Remove file</a>');
                        var _this = this;

                        removeButton.addEventListener("click", function (e) {
                            e.preventDefault();
                            e.stopPropagation();

                            var fileInfo = new Array();
                            fileInfo['name'] = file.name;

                            $.ajax({
                                type: "POST",
                                url: "{{ url('admin/delete-image') }}",
                                data: {file: file.name},
                                success: function (response) {

                                    if (response == 'success') {

                                        //alert('deleted');
                                    }
                                },
                                error: function () {
                                    alert("error");
                                }
                            });

                            _this.removeFile(file);

                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                }
            };

            var myDropzone = new Dropzone("#dropzone .dropzone");
            Dropzone.options.myDropzone = false;
            @foreach($photos
            as
            $photo
            )

            // Create the mock file:
            var mockFile = { name: "{{ $photo->file_name }}", size: "{{ $photo->file_size }}" };

            // Call the default addedfile event handler
            myDropzone.emit("addedfile", mockFile);

            // And optionally show the thumbnail of the file:
            myDropzone.emit("thumbnail", mockFile, "{{ url($photo->path) }}");

            @endforeach
        });
    </script>
    <br>
    {{ Form::open(array('action' => array('App\Controllers\Admin\PhotoGalleryController@update', $photo_gallery->id), 'method' => 'PATCH')) }}
    <!-- Title -->
    <div class="control-group {{ $errors->has('title') ? 'has-error' : '' }}">
        <label class="control-label" for="title">Title</label>

        <div class="controls">
            {{ Form::text('title', $photo_gallery->title, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Title', 'value'=>Input::old('title'))) }}
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
            {{ Form::textarea('content', $photo_gallery->content, array('class'=>'form-control', 'id' => 'content', 'placeholder'=>'Content', 'value'=>Input::old('content'))) }}
            @if ($errors->first('content'))
            <span class="help-block">{{ $errors->first('content') }}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Published -->
    <div class="control-group {{ $errors->has('is_published') ? 'has-error' : '' }}">

        <div class="controls">
            <label class="checkbox">{{ Form::checkbox('is_published', 'is_published',$photo_gallery->is_published) }} Publish ?</label>
            @if ($errors->first('is_published'))
            <span class="help-block">{{ $errors->first('is_published') }}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Menu -->
    <div class="control-group {{ $errors->has('is_in_menu') ? 'has-error' : '' }}">

        <div class="controls">
            <label class="checkbox">{{ Form::checkbox('is_in_menu', 'is_in_menu', $photo_gallery->is_in_menu) }} Show on the menu ?</label>
            @if ($errors->first('is_in_menu'))
            <span class="help-block">{{ $errors->first('is_in_menu') }}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Form actions -->
    {{ Form::submit('Update', array('class' => 'btn btn-success')) }}
    {{ Form::close() }}
    <script type="text/javascript">
        window.onload = function () {
            CKEDITOR.replace('content', {
                "filebrowserBrowseUrl": "{{ url('filemanager/show') }}"
            });
        };
    </script>
</div>
@stop