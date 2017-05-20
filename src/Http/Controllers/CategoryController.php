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
        $this->setPageTitle('添加分类');
        $categories = collect(Category::renderAsArray());
        return view('blog::categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Category::create($request->all());
        if ($result) {
            return redirect()->route('categories.index')->with('success_msg', '添加分类成功');
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
        $this->setPageTitle('编辑分类');
        $category = Category::find($id);
        $categories = Category::all();

        return view('blog::categories.edit', compact('categories', 'category'));
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
        $category = Category::find($id);
        $result = $category->update($request->all());
        if ($result) {
            return redirect()->route('categories.index')->with('success_msg', '编辑分类成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return response()->json(['code' => 200, 'message' => '删除标签成功']);
    }

    /**
     * order categories
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reorder(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = json_decode($request->nestable,true);

            $this->getChildren($data);

            return response()->json(['code' => 200, 'message' => '更新分类成功']);
        }

        $this->setPageTitle('分类排序');
        $this->breadcrumbs->addLink('排序');
        $categories = collect(Category::renderAsArray());
        return view('blog::categories.reorder', compact('categories'));
    }

    protected function getChildren($items, $parent_id = 0){
        foreach ($items as $k => $v) {
            $category = Category::find($v['id']);
            $category->order = $k;
            $category->parent_id = $parent_id;
            $category->save();

            if (isset($v['children']) && !empty($v['children'])) {
                $this->getChildren($v['children'], $v['id']);
            }
        }
    }
}
