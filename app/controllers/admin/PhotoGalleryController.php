<?php

namespace App\Controllers\Admin;

use BaseController, Redirect, View, Input, Validator, PhotoGallery, Response, File, Image, Photo;

class PhotoGalleryController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $photo_galleries = PhotoGallery::orderBy('created_at', 'DESC')
            ->paginate(15);

        return View::make('backend.photo_gallery.index', compact('photo_galleries'))->with('active', 'photo_gallery');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $photo_gallery = new PhotoGallery();
        $photo_gallery->title = "Photo Gallery Title";
        $photo_gallery->content = "Photo Gallery Content";
        $photo_gallery->is_published = false;
        $photo_gallery->is_in_menu = false;
        $photo_gallery->save();
        $id = $photo_gallery->id;

        return Redirect::to("/admin/photo_gallery/" . $id . "/edit")->with('message', 'Photo galler was successfully added');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {

        $formData = array(
            'title'        => Input::get('title'),
            'content'      => Input::get('content'),
            'is_published' => Input::get('is_published'),
            'is_in_menu'   => Input::get('is_in_menu')
        );

        $rules = array(
            'title'   => 'required',
            'content' => 'required'
        );

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return Redirect::action('App\Controllers\Admin\PhotoGalleryController@create')->withErrors($validation)->withInput();
        }

        $photo_gallery = new PhotoGallery();
        $photo_gallery->title = $formData['title'];
        $photo_gallery->content = $formData['content'];
        $photo_gallery->is_published = ($formData['is_published']) ? true : false;
        $photo_gallery->is_in_menu = ($formData['is_in_menu']) ? true : false;
        $photo_gallery->save();

        return Redirect::action('App\Controllers\Admin\PhotoGalleryController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {

        $photo_gallery = PhotoGallery::findOrFail($id);
        return View::make('backend.photo_gallery.show', compact('photo_gallery'))->with('active', 'photo_gallery');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {

        $photo_gallery = PhotoGallery::findOrFail($id);
        $photos = Photo::where('photo_gallery_id', '=', $id)->get();
        return View::make('backend.photo_gallery.edit', compact('photo_gallery','photos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) {

        $formData = array(
            'title'        => Input::get('title'),
            'content'      => Input::get('content'),
            'is_published' => Input::get('is_published'),
            'is_in_menu'   => Input::get('is_in_menu')
        );

        $photo_gallery = PhotoGallery::findOrFail($id);
        $photo_gallery->title = $formData['title'];
        $photo_gallery->content = $formData['content'];
        $photo_gallery->is_published = ($formData['is_published']) ? true : false;
        $photo_gallery->is_in_menu = ($formData['is_in_menu']) ? true : false;

        $photo_gallery->save();
        return Redirect::action('App\Controllers\Admin\PhotoGalleryController@index')->with('message', 'Photo galler was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {

        $photo_gallery = PhotoGallery::findOrFail($id);
        $photo_gallery->delete();

        // delete images db

        $photos = Photo::where('photo_gallery_id', '=', $id)->get();

        foreach ($photos as $photo) {

            Photo::where('file_name', '=', $photo->file_name)->delete();
            $destinationPath = public_path() . "/uploads/";

            File::delete($destinationPath . $photo->file_name);
            File::delete($destinationPath . "150x150_" . $photo->file_name);
        }

        return Redirect::action('App\Controllers\Admin\PhotoGalleryController@index')->with('message', 'Photo galler was successfully deleted');
    }

    public function confirmDestroy($id) {

        $photo_gallery = PhotoGallery::findOrFail($id);
        return View::make('backend.photo_gallery.confirm-destroy', compact('photo_gallery'))->with('active', 'photo_gallery');
    }

    public function togglePublish($id) {

        $photo_gallery = PhotoGallery::findOrFail($id);

        $photo_gallery->is_published = ($photo_gallery->is_published) ? false : true;
        $photo_gallery->save();

        return Response::json(array('result' => 'success', 'changed' => ($photo_gallery->is_published) ? 1 : 0));
    }

    public function toggleMenu($id) {

        $photo_gallery = PhotoGallery::find($id);

        $photo_gallery->is_in_menu = ($photo_gallery->is_in_menu) ? false : true;
        $photo_gallery->save();

        return Response::json(array('result' => 'success', 'changed' => ($photo_gallery->is_in_menu) ? 1 : 0));
    }

    public function upload($id) {

        $file = Input::file('file');

        $destinationPath = public_path() . '/uploads/';
        $filename = $file->getClientOriginalName();

        $upload_success = Input::file('file')->move($destinationPath, $filename);

        if ($upload_success) {

            // resizing an uploaded file
            Image::make($destinationPath . $filename)->resize(150, 150)->save($destinationPath . "150x150_" . $filename);

            $photo_gallery = PhotoGallery::findOrFail($id);
            $image = new Photo;
            $image->file_name = $filename;
            $image->title = explode(".", $filename)[0];
            $image->path = '/uploads/' . $filename;
            $photo_gallery->photos()->save($image);

            return Response::json('success', 200);
        }
    }

    public function deleteImage() {

        $fileName = Input::get('file');

        Photo::where('file_name', '=', $fileName)->delete();

        $destinationPath = public_path() . "/uploads/";
        File::delete($destinationPath . $fileName);
        File::delete($destinationPath . "150x150_" . $fileName);
        return Response::json('success', 200);
    }
}
