<?php

namespace Xcms\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Base\Http\Controllers\SystemController;
use Xcms\Blog\Models\Tag;

class TagController extends SystemController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function (Request $request, $next) {

            menu()->setActiveItem('tags');

            $this->breadcrumbs
                ->addLink('内容管理')
                ->addLink('标签列表', route('tags.index'));

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
            return Tag::all()->toJson();
        }

        $this->setPageTitle('标签列表');

        return view('blog::tags.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('新增标签');
        return view('blog::tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = Tag::create($request->all());
        if ($request) {
            return redirect()->route('tags.index')->with('success_msg', '添加标签成功');
        }
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
        $this->setPageTitle('编辑标签');
        $tag = Tag::find($id);
        return view('blog::tags.edit', compact('tag'));
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
        $tag = Tag::find($id);
        $request = $tag->update($request->all());
        if ($request) {
            return redirect()->route('tags.index')->with('success_msg', '编辑标签成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return array
     */
    public function destroy($id)
    {
        Tag::destroy($id);
        return response()->json(['code' => 200, 'success_msg' => '删除标签成功']);
    }

    public function json()
    {
        return Tag::all()->pluck('title');
    }
}
