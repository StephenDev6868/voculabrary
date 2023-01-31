<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        canPermission(AllPermission::xemBanner());
        if ($request->ajax()) {
            $sliders = Slider::query();

            $data = $this->dataTableFormat($sliders, $request);

            return response()->json($data);
        }
        return view('backend::sliders.index');
    }

    public function customFormat($data)
    {
        $formatData = [];
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                $formatData[$key]['id'] = $key + 1;
                $formatData[$key]['src'] = '<img src="' .getUrlFile($item->src) . '" width="200px" class="product-image-thumb">';
                $formatData[$key]['description'] = !empty($item->description) ? $item->description : null;
                $formatData[$key]['link'] = !empty($item->link) ? $item->link : null;
                $formatData[$key]['created_at'] = date('d/m/Y H:i:s', strtotime($item->created_at));
                $formatData[$key]['type'] = $item->getType();
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
        canPermission(AllPermission::themBanner());
        return view('backend::sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $slider = new Slider();
        $slider->description = $request->get('description');
        $slider->link = $request->get('link');
        $slider->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $slider->type = !empty($request->get('type')) ? $request->get('type') : 1;
        $slider->user_id = auth::user()->id;
        if (!empty($request->file('src'))) {
            $inputFile = $request->file('src');
            $folderUploads = '/public/sliders';
            $slider->src =  uploadFile($inputFile, $folderUploads);
        }

        $slider->save();

        return redirect()->route('slider.index')->with('success', 'Thêm mới slider thành công!');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('backend::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        canPermission(AllPermission::suaBanner());
        $slider = Slider::find($id);

        return view('backend::sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $slider->description = $request->get('description');
        $slider->link = $request->get('link');
        $slider->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $slider->type = !empty($request->get('type')) ? $request->get('type') : 1;
        $slider->user_id = auth::user()->id;

        if (!empty($request->file('src'))) {
            $inputFile = $request->file('src');
            $folderUploads = '/public/sliders';
            $slider->src =  uploadFile($inputFile, $folderUploads, $slider->src);
        }

        $slider->save();

        return redirect()->route('slider.index')->with('success', 'Cập nhật slider thành công!');
    }

    public function updateStatus($id, Request $request)
    {
        canPermissionAjax(AllPermission::suaBanner());
        $slider = Slider::find($id);
        $status = $request->get('status');

        if ($status == 2) {
            $setStatus = 1;
        } else {
            $setStatus = 2;
        }

        if ($slider) {
            $slider->status = $setStatus;
            $slider->save();

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
                'status_code' => $slider->status
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
        canPermissionAjax(AllPermission::xoaBanner());
        $slider = Slider::find($id);
        if ($slider->src) {
            Storage::delete($slider->src);
        }
        $slider->delete();

        return response()->json([
            'status' => 200,
            'message' =>  'Đã xoá thành công!'
        ]);

    }
}
