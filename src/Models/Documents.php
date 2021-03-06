<?php

namespace Digitalcake\Documents\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory, Translatable;

    protected $translatedAttributes = ['description', 'name'];
}
