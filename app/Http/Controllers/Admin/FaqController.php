<?php namespace Fully\Http\Controllers\Admin;

use Fully\Http\Controllers\Controller;
use Fully\Repositories\Faq\FaqInterface;
use Redirect;
use View;
use Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Notification;
use Fully\Repositories\Faq\FaqRepository as Faq;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class FaqController
 * @package App\Controllers\Admin
 * @author Sefa Karagöz
 */
class FaqController extends Controller {

    protected $faq;

    public function __construct(FaqInterface $faq) {

        $this->faq = $faq;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        //$faqs = $this->faq->paginate();

        $page = Input::get('page', 1);
        $perPage = 10;
        $pagiData = $this->faq->paginate($page, $perPage, true);
        $faqs = new LengthAwarePaginator($pagiData->items, $pagiData->totalItems, $perPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        $faqs->setPath("");

        return view('backend.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        return view('backend.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {

        try {
            $this->faq->create(Input::all());
            Notification::success('Faq was successfully added');
            return langRedirectRoute('admin.faq.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.faq.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id) {

        $faq = $this->faq->find($id);
        return view('backend.faq.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id) {

        $faq = $this->faq->find($id);
        return view('backend.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id) {

        try {
            $this->faq->update($id, Input::all());
            Notification::success('Faq was successfully updated');
            return langRedirectRoute('admin.faq.index');
        } catch (ValidationException $e) {

            return langRedirectRoute('admin.faq.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id) {

        $this->faq->delete($id);
        Notification::success('Faq was successfully deleted');
        return langRedirectRoute('admin.faq.index');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function confirmDestroy($id) {

        $faq = $this->faq->find($id);
        return view('backend.faq.confirm-destroy', compact('faq'));
    }
}
