<?php

namespace Digitalcake\Documents\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'document_id',
    ];

    public function document()
    {
        return $this->belongsTo(Documents::class);
    }
}
