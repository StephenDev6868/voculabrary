<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function index()
    {
        canPermission(AllPermission::xemDanhMuc());
        return view('backend::categories.index');
    }

    public function getListData(Request $request) {

        if ($request->ajax()) {

            $categories = Category::with('parent');

            $data = $this->dataTableFormat($categories, $request);

            return response()->json($data);

        }
    }

    protected function prepareDataColumns($columns)
    {

        return $columns;
    }

    public function customFormat($categories)
    {
        $formatData = [];
        if (count($categories) > 0) {
                foreach ($categories as $key => $item) {
                $formatData[$key]['id'] = $key + 1;
                $formatData[$key]['name'] = $item->name;
                $formatData[$key]['description'] = $item->description;
                $formatData[$key]['created_at'] = date('d/m/Y H:i:s', strtotime($item->created_at));
                $formatData[$key]['status'] = $item->getStatus();
                $formatData[$key]['action'] = $item->getAction();
            }
        }
        return $formatData;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        canPermission(AllPermission::themDanhMuc());
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->select('id', 'name', 'parent_id')->orderBy('id', 'DESC')->get();

        return view('backend::categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->get('name');
        $category->alias = strSlugName($request->get('name'));
        $category->description = $request->get('description');
        $category->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $category->user_id = auth::user()->id;

        if (!empty($request->file('icon'))) {
            $inputFile = $request->file('icon');
            $category->icon = Category::uploadImage($inputFile);
        }

        if (!empty($request->file('banner'))) {
            $inputFile = $request->file('banner');
            $category->banner = Category::uploadImage($inputFile);
        }
        $category->save();

        return redirect()->route('category.index')->with('success', 'Thêm mới danh mục thành công.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
//        return view('backend::category.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        canPermission(AllPermission::suaDanhMuc());
        $category = Category::findOrFail($id);
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->select('id', 'name', 'parent_id')->orderBy('id', 'DESC')->get();

        return view('backend::categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->alias = strSlugName($request->get('name'));
        $category->type = $request->get('type');
        $category->description = $request->get('description');
        $category->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $category->show_icon = !empty($request->get('show_icon')) ? $request->get('show_icon') : null;
        $category->show_banner = !empty($request->get('show_banner')) ? $request->get('show_banner') : null;
        $category->user_id = auth::user()->id;

        if (!empty($request->file('icon'))) {
            $inputFile = $request->file('icon');
            $category->icon = Category::uploadImage($inputFile, $category->icon);
        }

        if (!empty($request->file('banner'))) {
            $inputFile = $request->file('banner');
            $category->banner = Category::uploadImage($inputFile, $category->banner);
        }
        $category->save();

        return redirect()->back()->with('success', 'Cập nhật danh mục thành công.');
    }

    public function updateStatus($id, Request $request)
    {
        canPermissionAjax(AllPermission::suaDanhMuc());
        $category = Category::find($id);
        $status = $request->get('status');

        if ($status == 2) {
            $setStatus = 1;
        } else {
            $setStatus = 2;
        }

        if ($category) {
            $category->status = $setStatus;
            $category->save();

            return response()->json([
               'status' => 200,
               'message' => 'Cập nhật thành công!',
               'status_code' => $category->status
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Không tìm thấy dữ liệu vui lòng kiểm tra lại!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        canPermissionAjax(AllPermission::xoaDanhMuc());
        $checkParent = Category::where('parent_id', $id)->count();

        if ($checkParent == 0) {
            $category = Category::find($id);
            if ($category->icon) {
                Storage::delete($category->icon);
            }
            if ($category->banner) {
                Storage::delete($category->banner);
            }
            $category->delete();

            return response()->json([
               'status' => 200,
               'message' =>  'Đã xoá danh mục thành công!'
            ]);

        } else {

            return response()->json([
               'status' => 500,
               'message' => 'Không thể xoá danh mục này !'
            ]);
        }
    }
}
