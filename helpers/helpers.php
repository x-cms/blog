<?php

if (!function_exists('get_posts_by_category')) {
    function get_posts_by_category($categoryIds, array $params = [])
    {
        $post = new \Xcms\Blog\Models\Post();

        return $post->getPostsByCategory($categoryIds, $params);
    }
}