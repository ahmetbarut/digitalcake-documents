<?php

namespace Digitalcake\Documents\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocumentMailController
{
    /**
     * @var \Digitalcake\Documents\Models\Documents
     */
    private $document;
    
    /**
     * @var \Digitalcake\Documents\Models\DocumentsMail
     */
    private $mailModel;

    public function __construct()
    {
        $this->document = config('documents.model');
        $this->mailModel = config('documents.mail_model');
    }

    /**
     * Dokümanların listelendiği sayfayı döndürür.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(config('documents.web.views.index'))->with([
            'documents' => $this->document::all()
        ]);
    }
    
    /**
     * Kullanıcı bir dosya indirmek veya e-posta adresini girmek için görünen sayfa.
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($document)
    {
        $document = $this->document::findOrFail($document);

        return view(config('documents.web.views.create'))->with([
            'store_route' => route(config('documents.routes.web.name') .  'store', $document->id),
            'document' => $document
        ]);
    }

    /**
     * Kullanıcı bir dosya indirmek veya e-posta adresini girmek için görünen sayfa.
     * @param Request $request
     * @param int $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $document)
    {
        $document = $this->document::findOrFail($document);
        $mailModel = new $this->mailModel;

        $fileds = $request->only(config('documents.email_store_fields'));


        $mailModel->create(array_merge($fileds, [
            'document_id' => $document->id
        ]));

        Mail::to($fileds['email'])->send(new \Digitalcake\Documents\Mail\DocumentSendMail($document));

        return redirect()->route(config('documents.routes.web.name') . 'index')->with('success', 'Email enviado com sucesso');
    }

    public function download($document)
    {
        $document = $this->document::where('slug', $document)->firstOrFail();

        return response()->download($document->path);
    }
}
