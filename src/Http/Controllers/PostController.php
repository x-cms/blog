<?php

namespace Xcms\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Base\Http\Controllers\SystemController;
use Xcms\Blog\Models\Category;
use Xcms\Blog\Models\Post;
use Xcms\Blog\Models\Tag;

class PostController extends SystemController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function (Request $request, $next) {

            menu()->setActiveItem('posts');

            $this->breadcrumbs
                ->addLink('内容管理')
                ->addLink('文章列表', route('posts.index'));

            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|string
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            return Post::all()->toJson();
        }

        $this->setPageTitle('文章列表');

        return view('blog::posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('添加文章');
        $categories = Category::attr(['name' => 'category_id', 'id' => 'category_id', 'class' => 'form-control select2'])
            ->placeholder(0, '请选择文章分类')
            ->renderAsDropdown();

        return view('blog::posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->content_markdown = $request->input('editormd-markdown-doc');
        $post->content_html = $request->input('editormd-html-code');

        $post->save();

        if ($request->tags != null && $request->tags != '') {
            $tagInputs = explode(',', $request->tags);
            foreach ($tagInputs as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if ($tag === null) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->save();
                }
                $post->tags()->attach($tag->id);
            }
        }

        return redirect()->route('posts.index')->with('success_msg', '添加文章成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::with('tags')->find($id);

        $categories = Category::attr(['name' => 'category_id', 'id' => 'category_id', 'class' => 'form-control select2'])
            ->placeholder(0, '请选择文章分类')
            ->selected($post->category_id)
            ->renderAsDropdown();

        $tags = '';
        foreach ($post->tags as $tag) {
            $tags .= $tag->name . ',';
        }

        return view('blog::posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
