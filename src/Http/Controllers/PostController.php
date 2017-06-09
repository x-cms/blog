<?php

namespace Xcms\Blog\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Xcms\Base\Http\Controllers\SystemController;
use Xcms\Blog\Models\Category;
use Xcms\Blog\Models\Post;
use Xcms\Blog\Models\Tag;
use Xcms\Media\Models\File;

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
        $post->description = $request->description;
        $post->content = $request->input('editormd-markdown-doc');
        $post->content_html = $request->input('editormd-html-code');
        $post->order = $request->order;
        $post->status = $request->status;
        $post->published_at = $request->published_at ? $request->published_at : Carbon::now();
        $post->save();

        if ($request->hasFile('image')) {
            $file = new File();
            $file->data = $request->file('image');
            $file->is_public = true;
            $file->field = 'thumbnail';
            $file->beforeSave();
            $post->files()->save($file);
        }

        if ($request->tags != null) {
            foreach ($request->tags as $item) {
                $tag = Tag::where('name', $item)->first();
                if ($tag === null) {
                    $tag = new Tag();
                    $tag->name = $item;
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

        return view('blog::posts.edit', compact('post', 'categories'));
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
        $post = Post::find($id);
        $post->category_id = $request->category_id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->content = $request->input('editormd-markdown-doc');
        $post->content_html = $request->input('editormd-html-code');
        $post->order = $request->order;
        $post->status = $request->status;
        $post->published_at = $request->published_at ? $request->published_at : Carbon::now();

        $post->save();
        dd($request->all());
        foreach ($post->files as $item) {
            $file = new File();
            $file->destroy($item->id);
            $file->id = $item->id;
            $file->disk_name = $item->disk_name;
            $file->afterDelete();
        }

        if ($request->hasFile('image')) {
            $file = new File();
            $file->data = $request->file('image');
            $file->is_public = true;
            $file->field = 'thumbnail';
            $file->beforeSave();
            $post->files()->save($file);
        }

        if ($request->tags != null) {
            $post->tags()->detach();
            foreach ($request->tags as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if ($tag === null) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->save();
                }
                $post->tags()->attach($tag->id);
            }
        }

        return redirect()->route('posts.index')->with('success_msg', '编辑文章成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(['code' => 200, 'message' => '删除文章成功']);
    }
}
