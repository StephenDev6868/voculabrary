<?php

namespace Modules\Backend\Http\Controllers;

use App\Common\AllPermission;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\ReplyFeedback;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Mail, auth;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        canPermission(AllPermission::xemDanhSachGopY());
        if ($request->ajax()) {
            $feedback = Feedback::query()->select('*');
            $data = $this->dataTableFormat($feedback, $request);

            return response()->json($data);
        }

        return view('backend::feedback.index');
    }

    public function customFormat($data)
    {
        $formatData = [];
        if (count($data) > 0) {
            foreach ($data as $key => $item) {
                $formatData[$key]['id'] = $key + 1;
                $formatData[$key]['user_id'] = !empty($item->user) ? $item->user->fullname : null;
                $formatData[$key]['content'] = $item->content;
                $formatData[$key]['file_feedback'] = $item->getFile();
                $formatData[$key]['reply'] = $item->getReply();
                $formatData[$key]['created_at'] = date('d/m/Y H:i:s', strtotime($item->created_at));
                $formatData[$key]['action'] = $item->getAction();
            }
        }

        return $formatData;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $feedback = Feedback::with('feedbackFile', 'replyFeedback')->find($id);

        return view('backend::feedback.show', compact('feedback'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = Feedback::find($id);
        $data->delete();

        return response()->json([
            'status' => 200,
            'message' =>  'Đã xoá thành công!'
        ]);
    }

    public function sendEmail(Request $request, $id)
    {
        // send otp to email using email api
        $subject = $request->get('title') ? $request->get('title') : env('APP_NAME') . ' Cảm ơn góp ý của bạn';
        $content = $request->get('content');
        if (empty($content)) {
            return redirect()->back()->with('danger', 'Vui lòng nhập nội dung!');
        }

        $data = Feedback::find($id);
        if (!empty($data->user->email)) {
            $toEmail = $data->user->email;// mail nhận
            $toName = $data->user->fullname ? $data->user->fullname : 'No name';

            $replyFeedback = new ReplyFeedback();
            $replyFeedback->user_id = auth::user()->id;
            $replyFeedback->feedback_id = $id;
            $replyFeedback->title = $subject;
            $replyFeedback->content = $content;
            $replyFeedback->save();

            $data->reply = 1;
            $data->save();

            Mail::Send('emails.feedback', ['content' => $content], function ($message) use ($toEmail, $toName, $subject) {
                $message->to($toEmail, $toName)->subject($subject);
            });

            return redirect()->route('feedback.index')->with('success', 'Thêm mới thành công!');
        }

        return redirect()->back()->with('danger', 'Không tìm thấy email người nhận');

    }
}
