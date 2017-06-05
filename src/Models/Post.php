<?php

namespace Xcms\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getPostsByCategory($categoryId, array $params = [])
    {
        $params = array_merge([
            'condition' => [
                'category_id' => $categoryId,
                'status' => 1
            ],
            'order_by' => [
                'posts.order' => 'ASC',
                'posts.created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => [
                'posts.id', 'posts.title', 'posts.slug', 'posts.published_at', 'posts.created_at', 'posts.updated_at',
                'posts.content_markdown', 'posts.content_html', 'posts.description', 'posts.order', 'posts.thumbnail',
            ],
            'group_by' => [
                'posts.id', 'posts.title', 'posts.slug', 'posts.published_at', 'posts.created_at', 'posts.updated_at',
                'posts.content_markdown', 'posts.content_html', 'posts.description', 'posts.order', 'posts.thumbnail'
            ],
            'with' => [

            ],
        ], $params);

        $model = $this
            ->select($params['select'])
            ->where($params['condition'])
            ->distinct()
            ->groupBy($params['group_by']);

        foreach ($params['with'] as $with) {
            $model = $model->with($with);
        }

        foreach ($params['order_by'] as $column => $direction) {
            $model = $model->orderBy($column, $direction);
        }

        if ($params['take'] == 1) {
            return $model->first();
        }

        if ($params['take']) {
            return $model->take($params['take'])->get();
        }

        if ($params['paginate']['per_page']) {
            return $model->paginate($params['paginate']['per_page'], ['*'], 'page', $params['paginate']['current_paged']);
        }

        return $model->get();
    }
}
