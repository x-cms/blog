<?php

namespace Xcms\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class Category extends Model
{
    use NestableTrait;

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
