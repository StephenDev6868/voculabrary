<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Imports\QuestionImport;
use App\Models\Exam;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth, Excel, DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        canPermission(AllPermission::xemCauHoi());
        if ($request->ajax()) {
            $exams = Exam::query()->select('id', 'file', 'title', 'description',
                'category_id', 'priority', 'suggest_number', 'created_at', 'status', 'user_id');

            $data = $this->dataTableFormat($exams, $request);

            return response()->json($data);
        }

        return view('backend::exams.index');
    }

    public function customFormat($data)
    {
        $formatData = [];
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                $formatData[$key]['id'] = $key + 1;
                $formatData[$key]['priority'] = $item->priority;
                $formatData[$key]['title'] = !empty($item->title) ? $item->title : null;
                $formatData[$key]['description'] = !empty($item->description) ? $item->description : null;
                $formatData[$key]['suggest_number'] = !empty($item->suggest_number) ? $item->suggest_number : null;
                $formatData[$key]['category_id'] = !empty($item->category) ? $item->category->name : null;
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
        canPermission(AllPermission::themCauHoi());
        $categories = Category::orderBy('id', 'DESC')->get();

        return view('backend::exams.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $inputFile = $request->file('file');
            $exam = new Exam();
            $exam->title = $request->title;
            $exam->alias = strSlugName($request->get('title'));
            $exam->description = $request->description;
            $exam->category_id = $request->category_id;
            $exam->priority = $request->priority;
            $exam->suggest_number = $request->suggest_number;
            $exam->time_question = $request->time_question;
            $exam->content = $request->get('content');
            $exam->status = !empty($request->get('status')) ? $request->get('status') : 2;
            if (!empty($request->file('file'))) {
                $folderUploads = '/public/exams';
                $exam->file = uploadFile($inputFile, $folderUploads);
            }
            $exam->user_id = auth::user()->id;
            $exam->save();

            // tao bo cau hoi
            if (!empty($inputFile)) {
               Excel::import(new QuestionImport($exam, 1), $inputFile);
            }

            DB::commit();

            return redirect()->route('exam.index')->with('success', 'Thêm mới thành công!');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $exam = Exam::with('questions', 'category')->find($id);

        return view('backend::exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        canPermission(AllPermission::suaCauHoi());
        $categories = Category::orderBy('id', 'DESC')->get();
        $exam = Exam::find($id);

        return view('backend::exams.edit', compact('categories', 'exam'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $inputFile = $request->file('file');
        $exam = Exam::find($id);
        $exam->title = $request->title;
        $exam->alias = strSlugName($request->get('title'));
        $exam->priority = $request->priority;
        $exam->description = $request->description;
        $exam->category_id = $request->category_id;
        $exam->suggest_number = $request->suggest_number;
        $exam->time_question = $request->time_question;
        $exam->content = $request->get('content');
        $exam->status = !empty($request->get('status')) ? $request->get('status') : 2;
        if (!empty($request->file('file'))) {
            $folderUploads = '/public/exams';
            $exam->file = uploadFile($inputFile, $folderUploads, $exam->file);
        }
        $exam->user_id = auth::user()->id;
        $exam->save();

        if (!empty($inputFile)) {

            Question::where('exam_id', $exam->id)->delete();

            Excel::import(new QuestionImport($exam, 2), $inputFile);
        }

        return redirect()->route('exam.index')->with('success', 'Cập nhật thành công!');
    }

    public function updateStatus($id, Request $request)
    {
        canPermissionAjax(AllPermission::suaCauHoi());
        $exam = Exam::find($id);
        $status = $request->get('status');

        if ($status == 2) {
            $setStatus = 1;
        } else {
            $setStatus = 2;
        }

        if ($exam) {
            $exam->status = $setStatus;
            $exam->save();

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thành công!',
                'status_code' => $exam->status
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
        canPermissionAjax(AllPermission::xoaCauHoi());
        $data = Exam::find($id);
        if ($data->file) {
            Storage::delete($data->file);
        }
        $data->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Đã xoá danh mục thành công!'
        ]);
    }
}
