<?php

namespace Digitalcake\Documents\Controllers;

use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DocumentController
{
    /**
     * config/documents.php dosyasından tanımlanan modeli alır. 
     */
    private $model;

    public function __construct()
    {
        $this->model = config('documents.model');
    }

    /**
     * administrator/documents/index sayfasının yönlendirilmesi
     * @return \Illuminate\Support\Facades\View
     */
    public function index()
    {
        return view(config('documents.admin.views.index'))->with([
            'documents' => $this->model::all()
        ]);
    }

    /**
     * administrator/documents/show/{document} sayfasının yönlendirilmesi
     * @param $documents
     * @return \Illuminate\Support\Facades\View
     */
    public function show($documents)
    {
        return view(config('documents.admin.views.show'))->with([
            'document' => $this->model::findOrFail($documents)
        ]);
    }

    /**
     * administrator/documents/create sayfasının yönlendirilmesi
     * @return \Illuminate\Support\Facades\View
     */
    public function create()
    {
        return view(config('documents.admin.views.create'))->with([
            'store_route' => route(config('documents.routes.admin.name') . 'store'),
        ]);
    }

    /**
     * administrator/documents/store isteğinin yönlendirilmesi
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'description' => 'required|max:255',
                'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_public' => 'required|boolean',
                'documents' => 'required'
            ]
        );

        $model = new $this->model;
        $image = Str::random(32) . '.' . $request->file('image')->getClientOriginalExtension();

        Image::make($request->file('image')->getRealPath())->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->save(config('documents.img_path') . '/' . $image, 95);

        $file = $request->file('documents');

        $name = $request->name ? Str::slug($request->name) . '.' . $file->getClientOriginalExtension() : Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

        $model->path = $file->move(config('documents.path'), $name);
        $model->name = $name;
        $model->image = $image;
        $model->slug = Str::uuid();
        $model->description = $request->description;
        $model->public = $request->is_public == 1 ? true : false;
        $model->save();

        return redirect()->route(config('documents.routes.admin.name') . 'index')->with('success', trans('documents::admin.store_success'));
    }

    /**
     * administrator/documents/edit/{document} sayfasının yönlendirilmesi
     * @param $document
     * @return \Illuminate\Support\Facades\View
     */
    public function edit($document)
    {
        $document = $this->model::findOrFail($document);

        return view(config('documents.admin.views.edit'))->with([
            'document' => $document,
            'update_route' => route(config('documents.routes.admin.name') . 'update', $document->id),
        ]);
    }

    /**
     * administrator/documents/update/{document} isteğinin yönlendirilmesi
     * @param Request $request
     * @param $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $document)
    {
        $document = $this->model::findOrFail($document);

        $file = $request->file('documents');

        $name = $document->name;

        if ($request->name) {
            $name = Str::slug($request->name);
        }

        if ($file) {
            try {
                unlink(public_path(config('documents.path') . '/' . $document->name));
                unlink(public_path(config('documents.img_path') . '/' . $document->image));
            } catch (ErrorException $e) {
                Log::alert($e->getMessage());
            }
            $name = $request->name ? $name : Str::of($file->getClientOriginalName())->replace('.' . $file->getClientOriginalExtension(), '');
            $document->path = $file->move(config('documents.path'), $name . '.' . $file->getClientOriginalExtension());
        }

        if ($request->has('image')) {
            $image = Str::random(32) . '.' . $request->file('image')->getClientOriginalExtension();

            Image::make($request->file('image')->getRealPath())->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(config('documents.img_path') . '/' . $image, 95);
        }

        $document->image = $request->has('image') ? $image : $document->image;
        $document->description = $request->description;
        $document->name = $name;
        $document->public = $request->is_public == 1 ? true : false;
        $document->save();

        return back()->with([
            'message' => trans('documents::admin.upload_success'),
        ]);
    }

    /**
     * administrator/documents/destroy/{document} isteğinin yönlendirilmesi
     * @param $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($document)
    {
        $document = $this->model::findOrFail($document);
        try {
            unlink(public_path(config('documents.path') . '/' . $document->name));
            unlink(public_path(config('documents.img_path') . '/' . $document->image));
        } catch (ErrorException $e) {
            Log::alert($e->getMessage());
        }
        $document->delete();

        return back()->with([
            'message' => trans('documents::admin.delete_success'),
        ]);
    }
}
