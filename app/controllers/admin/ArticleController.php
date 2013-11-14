<?php

namespace App\Controllers\Admin;

use BaseController, Redirect, View, Input, Validator, Article, Response;

class ArticleController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $articles = Article::orderBy('created_at', 'DESC')
            ->paginate(15);
        return View::make('backend.article.index', compact('articles'))->with('active', 'article');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        return View::make('backend.article.create')->with('active', 'article');
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
            'is_published' => Input::get('is_published')
        );

        $rules = array(
            'title'   => 'required',
            'content' => 'required'
        );

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return Redirect::action('App\Controllers\Admin\ArticleController@create')->withErrors($validation)->withInput();
        }

        $article = new Article();
        $article->title = $formData['title'];
        $article->content = $formData['content'];
        $article->is_published = ($formData['is_published']) ? true : false;
        $article->save();

        return Redirect::action('App\Controllers\Admin\ArticleController@index')->with('message', 'Article was successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {

        $article = Article::findOrFail($id);
        return View::make('backend.article.show', compact('article'))->with('active', 'article');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {

        $article = Article::findOrFail($id);
        return View::make('backend.article.edit', compact('article'))->with('active', 'article');
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
            'is_published' => Input::get('is_published')
        );

        $article = Article::findOrFail($id);
        $article->title = $formData['title'];
        $article->content = $formData['content'];
        $article->is_published = ($formData['is_published']) ? true : false;

        $article->save();
        return Redirect::action('App\Controllers\Admin\ArticleController@index')->with('message', 'Article was successfully updated');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {

        $article = Article::findOrFail($id);
        $article->delete();

        return Redirect::action('App\Controllers\Admin\ArticleController@index')->with('message', 'Article was successfully deleted');;
    }

    public function confirmDestroy($id) {

        $article = Article::findOrFail($id);
        return View::make('backend.article.confirm-destroy', compact('article'))->with('active', 'article');
    }

    public function togglePublish($id) {

        $page = Article::findOrFail($id);

        $page->is_published = ($page->is_published) ? false : true;
        $page->save();

        return Response::json(array('result' => 'success', 'changed' => ($page->is_published) ? 1 : 0));
    }
}
