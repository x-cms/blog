<?php

namespace Xcms\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $primaryKey = 'id';

    protected $guarded = [];
}
