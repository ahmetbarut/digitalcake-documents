<?php

namespace Digitalcake\Documents\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsTranslation extends Model
{
    use HasFactory;

    protected $table = 'document_translations';
}
