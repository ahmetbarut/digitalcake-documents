<?php

namespace Digitalcake\Documents\Controllers;

use App\Models\Locale;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DocumentController
{
    /**
     * config/documents.php dosyasından tanımlanan modeli alır. 
     */
    protected $model;

    public function __construct()
    {
        $this->model = config('documents.model');
        View::share('locales', Locale::all());
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
        $locales = Locale::find($request->locales);
        if (!$locales) {
            return redirect()->back()->withErrors(['locales' => 'Lütfen dilleri seçiniz.']);
        }

        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_public' => 'required|boolean',
            'documents' => 'required'
        ]);

        foreach ($locales as $locale) {
            $rules['name-' . $locale->language] = ['max:255'];
            $rules['description-' . $locale->language] = ['required', 'max:255'];
        }

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $model = new $this->model;
        $image = Str::random(32) . '.' . $request->file('image')->getClientOriginalExtension();


        Image::make($request->file('image')->getRealPath())->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
        })->save(config('documents.img_path') . '/' . $image, 95);

        $file = $request->file('documents');

        $name = Str::of(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->title()->replace('_', ' ')->replace('-', ' ');
        $slug = Str::uuid() . '.' . $file->getClientOriginalExtension();

        foreach ($locales as $locale) {
            app()->setLocale($locale->language);
            if ($request->get('name-' . $locale->language) === null) {
                $model->name = $name;
            } else {
                $model->name = $request->get('name-' . $locale->language);
            }
            $model->description = $request->get('description-' . $locale->language);
        }

        $model->path = $file->move(config('documents.path'), $slug);
        $model->image = $image;
        $model->slug = $slug;
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


        $locales = Locale::find($request->locales);

        if (!$locales) {
            return redirect()->back()->withErrors(['locales' => 'Lütfen dilleri seçiniz.']);
        }

        $request->validate([
            'is_public' => 'required|boolean',
        ]);

        foreach ($locales as $locale) {
            $rules['name-' . $locale->language] = ['max:255'];
            $rules['description-' . $locale->language] = ['required', 'max:255'];
        }

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $file = $request->file('documents');

        $name = $document->name;

        if ($request->name) {
            $name = $request->name;
        }

        if ($file) {
            $slug = Str::uuid() . '.' . $file->getClientOriginalExtension();

            try {
                unlink(public_path($document->path));
            } catch (ErrorException $e) {
                Log::alert($e->getMessage());
            }
            $name = $request->name ? $name : Str::of($file->getClientOriginalName())->replace('.' . $file->getClientOriginalExtension(), '');
            $document->path = $file->move(config('documents.path'), $slug);
            $document->slug = $slug;
        }

        if ($request->has('image')) {
            try {
                unlink(public_path(config('documents.img_path') . '/' . $document->image));
            } catch (ErrorException $e) {
                Log::alert($e->getMessage());
            }
            $image = Str::random(32) . '.' . $request->file('image')->getClientOriginalExtension();
            Image::make($request->file('image')->getRealPath())->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save(config('documents.img_path') . '/' . $image, 95);
            $document->image = $image;
        }

        foreach ($locales as $locale) {
            app()->setLocale($locale->language);
            if ($request->get('name-' . $locale->language) === null) {
                $document->name = $name;
            } else {
                $document->name = $request->get('name-' . $locale->language);
            }
            $document->description = $request->get('description-' . $locale->language);
        }

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
            unlink(public_path($document->path));
            unlink(public_path(config('documents.img_path') . '/' . $document->image));
        } catch (ErrorException $e) {
            Log::alert($e->getMessage());
        }
        $document->deleteTranslations();
        $document->delete();

        return back()->with([
            'message' => trans('documents::admin.delete_success'),
        ]);
    }
}
