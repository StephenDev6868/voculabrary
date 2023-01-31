<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Feedback;
use App\Models\FeedbackFile;
use Illuminate\Http\Request;
use Auth, DB;

class AboutUsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');

        $about = AboutUs::where(function ($query) use ($type) {
            if (!empty($type)) {
                return $query->where('type', $type);
            }
        })
            ->select('id', 'title', 'content', 'status', 'app_version', 'logo', 'created_at', 'updated_at')
            ->orderBy('id', 'DESC')->first();

        if ($about->logo) {
            $about->logo = getUrlFile($about->logo);
        }


        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $about
        ]);
    }

    public function feedbackUser(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ], [
            'content.required' => 'Nội dung góp ý không được để trống'
        ]);

        $user = auth::user();

        $feedback = new Feedback();
        $feedback->content = $request->get('content');
        $feedback->user_id = $user->id;
        $feedback->save();

        if ($request->hasfile('fileName')) {
            $folderUploads = '/public/feedback';
            foreach ($request->file('fileName') as $file) {
                $name = $file->getClientOriginalName();
                $src =  uploadFile($file, $folderUploads);
                $feedbackFile = new FeedbackFile();
                $feedbackFile->file_name = $name;
                $feedbackFile->src = $src;
                $feedbackFile->feedback_id = $feedback->id;
                $feedbackFile->save();
            }
        }

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Đã gửi góp ý thành công.'
        ]);


    }
}
