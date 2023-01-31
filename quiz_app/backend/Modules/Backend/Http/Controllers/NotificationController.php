<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        canPermission(AllPermission::xemDanhSachThongBao());
        if ($request->ajax()) {
            $notifications = Notification::query()->select('id', 'title', 'description',
                'content', 'created_at', 'status', 'user_id', 'date');

            $data = $this->dataTableFormat($notifications, $request);

            return response()->json($data);
        }

        return view('backend::notifications.index');
    }

    public function customFormat($data)
    {
        $formatData = [];
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                $formatData[$key]['id'] = $key + 1;
                $formatData[$key]['title'] = !empty($item->title) ? $item->title : null;
                $formatData[$key]['description'] = !empty($item->description) ? $item->description : null;
                $formatData[$key]['content'] = $item->content;
                $formatData[$key]['date'] = date('d/m/Y', strtotime($item->date));
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
        canPermission(AllPermission::themThongBao());
        return view('backend::notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $notification = new Notification();
        $notification->title = $request->title;
        $notification->alias = strSlugName($request->get('title'));
        $notification->description = $request->description;
        $notification->content = $request->get('content');
        $notification->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $notification->date = !empty($request->date) ? formatYMD($request->date) : null;
        $notification->user_id = auth::user()->id;
        $notification->save();

        return redirect()->route('notification.index')->with('success', 'Thêm mới thành công!');
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
        canPermission(AllPermission::suaThongBao());
        $notification = Notification::find($id);

        return view('backend::notifications.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);

        $notification->title = $request->title;
        $notification->alias = strSlugName($request->get('title'));
        $notification->description = $request->description;
        $notification->content = $request->get('content');
        $notification->status = !empty($request->get('status')) ? $request->get('status') : 2;
        $notification->date = !empty($request->date) ? formatYMD($request->date) : null;
        $notification->user_id = auth::user()->id;
        $notification->save();

        return redirect()->route('notification.index')->with('success', 'Cập nhật thành công!');
    }

    public function updateStatus($id, Request $request)
    {
        canPermissionAjax(AllPermission::suaThongBao());
        $notification = Notification::find($id);
        $status = $request->get('status');

        if ($status == 2) {
            $setStatus = 1;
        } else {
            $setStatus = 2;
        }

        if ($notification) {
            $notification->status = $setStatus;
            $notification->save();

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
                'status_code' => $notification->status
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
        canPermissionAjax(AllPermission::xoaThongBao());
        $data = Notification::find($id);
        $data->delete();

        return response()->json([
            'status' => 200,
            'message' =>  'Đã xoá thành công!'
        ]);
    }
}
