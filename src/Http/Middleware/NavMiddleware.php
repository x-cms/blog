<?php

namespace Xcms\Blog\Http\Middleware;

use Closure;
use Xcms\Blog\Models\Category;
use Xcms\Blog\Models\Tag;

class NavMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        nav()->registerLinkType('post', function ($id) {
            $post = Post::find($id);
            if (!$post) {
                return null;
            }
            return [
                'model_title' => $post->title,
                'url' => $post->slug,
            ];
        });

        nav()->registerLinkType('category', function ($id) {
            $category = Category::find($id);
            if (!$category) {
                return null;
            }
            return [
                'model_title' => $category->name,
                'url' => $category->slug,
            ];
        });

        nav()->registerLinkType('tag', function ($id) {
            $tag = Tag::find($id);
            if (!$tag) {
                return null;
            }
            return [
                'model_title' => $tag->name,
                'url' => $tag->slug,
            ];
        });

        return $next($request);
    }
}
