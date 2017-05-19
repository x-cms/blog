<?php

namespace Xcms\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Base\Http\Controllers\SystemController;
use Xcms\Blog\Models\Category;

class CategoryController extends SystemController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function (Request $request, $next) {

            menu()->setActiveItem('categories');

            $this->breadcrumbs
                ->addLink('内容管理')
                ->addLink('分类列表', route('categories.index'));

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
            return Category::renderAsJson();
        }

        $this->setPageTitle('分类列表');

        return view('blog::categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = collect(Category::renderAsArray());
        return view('blog::categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Category::create($request->all());
        if($result){
            return redirect()->route('categories.index')->with('success_msg', '添加分类成功');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::all();
        return view('blog::categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $result = $category->update($request->all());
        if($result){
            return redirect()->route('categories.index')->with('success_msg', '编辑分类成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return response()->json(['code' => 200, 'message' => '删除标签成功']);
    }
}
