<?php

namespace App\Extensions\Documents\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocumentsMailController
{
    private $document;
    private $mailModel;

    public function __construct()
    {
        $this->document = config('documents.model');
        $this->mailModel = config('documents.mail_model');
    }

    public function create($document)
    {
        $document = $this->document::findOrFail($document);

        return view('Documents.Views.add_email')->with([
            'store_route' => route(config('documents.routes.web.name') .  'store', $document->id),
            'document' => $document
        ]);
    }

    public function store(Request $request, $document)
    {
        $document = $this->document::findOrFail($document);
        $mailModel = new $this->mailModel;

        $fileds = $request->only(config('documents.email_store_fields'));


        $mailModel->create(array_merge($fileds, [
            'document_id' => $document->id
        ]));

        Mail::to($fileds['email'])->send(new \Digitalcake\Documents\Mail\DocumentSendMail($document));
    }

    public function download($document)
    {
        $document = $this->document::where('slug', $document)->firstOrFail();

        return response()->download($document->path);
    }
}
