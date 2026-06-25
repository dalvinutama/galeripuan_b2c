<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;

class SearchDictionary extends Model
{
    protected $table = 'search_dictionaries';

    protected $fillable = [
        'word',
    ];
}
