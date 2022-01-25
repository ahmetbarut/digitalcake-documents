<?php

namespace Digitalcake\Documents\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $url;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->url = route(config('documents.routes.web.name') . 'download' , $data->slug);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(config('documents.mail.template'));
    }
}
