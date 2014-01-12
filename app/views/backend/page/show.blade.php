@extends('backend/_layout/layout')
@section('content')
{{ HTML::style('ckeditor/contents.css') }}
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $page->title }}</h3>
        </div>
        <div class="panel-body">
            <div class="pull-left">
                <div class="btn-toolbar">
                    <a href="{{ url('admin/page') }}"
                       class="btn btn-primary">
                        <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back
                    </a>
                </div>
            </div>
            <br>
            <br>
            <br>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td><strong>Title</strong></td>
                    <td>{{ $page->title }}</td>
                </tr>
                <tr>
                    <td><strong>Published</strong></td>
                    <td>{{ $page->is_published }}</td>
                </tr>
                <tr>
                    <td><strong>Show on the menu</strong></td>
                    <td>{{ $page->is_in_menu }}</td>
                </tr>
                <tr>
                    <td><strong>Content</strong></td>
                    <td>{{ $page->content }}</td>
                </tr>
                    <td><strong>Date Created</strong></td>
                    <td>{{ $page->created_at }}</td>
                </tr>
                <tr>
                    <td><strong>Date Updated</strong></td>
                    <td>{{ $page->updated_at }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop