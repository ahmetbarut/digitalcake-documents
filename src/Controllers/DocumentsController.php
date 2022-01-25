<?php

namespace Digitalcake\Documents\Controllers;

use Digitalcake\Documents\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentsController
{
    private $model;

    public function __construct()
    {
        $this->model = config('documents.model');
    }

    public function index()
    {
        return view(config('documents.admin.views.index'))->with([
            'documents' => $this->model::all()
        ]);
    }
    
    public function show($documents)
    {
        return view(config('documents.admin.views.show'))->with([
            'document' => $this->model::findOrFail($documents)
        ]);
    }

    public function create()
    {
        return view(config('documents.admin.views.create'))->with([
            'store_route' => route(config('documents.routes.admin.name'). 'store'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable',
            'documents' => 'required',
        ]);

        $model = new $this->model;

        $file = $request->file('documents');

        $name = $request->name ? Str::slug($request->name) . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName();

        $model->path = $file->move(config('documents.path'), $file->getClientOriginalName());
        $model->name = $name;
        $model->slug = Str::uuid();
        $model->public = $request->is_public ? true : false;
        $model->save();

        return redirect()->route(config('documents.routes.admin.name') . 'index')->with('success', 'Document uploaded successfully');
    }

    public function edit($document)
    {
        $document = $this->model::findOrFail($document);

        return view('Documents.Views.edit')->with([
            'document' => $document,
            'store_route' => route(config('documents.routes.admin.name') . 'update', $document->id),
        ]);
    }

    public function update(Request $request, $document)
    {
        $document = $this->model::find($document);
        
        if(!$document) {
            return response()->json([
                'message' => 'Document not found',
                'status' => 'error',
            ]);
        }
        
        $request->validate([
            'name' => 'nullable',
        ]);

        $file = $request->file('documents');

        $name = $request->name ? Str::slug($request->name) . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName();

        if($file) {
            $document->path = $file->move(config('documents.path'), $name);
        }
        
        $document->name = $name;
        $document->public = $request->is_public ? true : false;
        $document->save();

        return back()->with([
            'message' => 'Document updated successfully',
        ]);
        
    }
}
