<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Auth;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        canPermission(AllPermission::xemCauHinhThongTin());
        if ($request->ajax()) {
            $aboutUs = AboutUs::query()->select('id', 'title',
                'content', 'created_at', 'status', 'user_id', 'type');

            $data = $this->dataTableFormat($aboutUs, $request);

            return response()->json($data);
        }

        return view('backend::about-us.index');
    }

    public function customFormat($data)
    {
        $formatData = [];
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                $formatData[$key]['id'] = $key + 1;
                $formatData[$key]['title'] = !empty($item->title) ? $item->title : null;
                $formatData[$key]['content'] = $item->content;
                $formatData[$key]['type'] = $item->type == 1 ? 'Về chúng tôi' : 'Điều khoản chính sách';
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
        canPermission(AllPermission::themCauHinhThongTin());
        return view('backend::about-us.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $about = New AboutUs();
        $about->title = $request->title;
        $about->alias = strSlugName($request->get('title'));
        $about->content = $request->get('content');
        $about->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $about->type = $request->get('type');
        $about->user_id = auth::user()->id;
        if (!empty($request->file('logo'))) {
            $inputFile = $request->file('logo');
            $about->logo = AboutUs::uploadImage($inputFile);
        }
        $about->app_version = $request->get('app_version');
        $about->save();

        return redirect()->route('about-us.index')->with('success', 'Thêm mới thành công!');
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
        canPermission(AllPermission::suaCauHinh());
        $aboutUs = AboutUs::find($id);

        return view('backend::about-us.edit', compact('aboutUs'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $about = AboutUs::find($id);
        $about->title = $request->title;
        $about->alias = strSlugName($request->get('title'));
        $about->content = $request->get('content');
        $about->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $about->type = $request->get('type');
        $about->user_id = auth::user()->id;
        if (!empty($request->file('logo'))) {
            $inputFile = $request->file('logo');
            $about->logo = AboutUs::uploadImage($inputFile);
        }
        $about->app_version = $request->get('app_version');
        $about->save();

        return redirect()->route('about-us.index')->with('success', 'Thêm mới thành công!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        canPermissionAjax(AllPermission::xoaCauHinh());
        $data = AboutUs::find($id);
        $data->delete();

        return response()->json([
            'status' => 200,
            'message' =>  'Đã xoá thành công!'
        ]);
    }

    public function updateStatus($id, Request $request)
    {
        canPermissionAjax(AllPermission::suaCauHinh());
        $data = AboutUs::find($id);
        $status = $request->get('status');

        if ($status == 2) {
            $setStatus = 1;
        } else {
            $setStatus = 2;
        }

        if ($data) {
            $data->status = $setStatus;
            $data->save();

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
                'status_code' => $data->status
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Không tìm thấy dữ liệu vui lòng kiểm tra lại!',
        ]);
    }
}
