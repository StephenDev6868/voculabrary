<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Question;
use App\Models\Slider;
use App\Models\UserCorrect;
use App\Models\UserReadNotification;
use Illuminate\Http\Request;
use Auth;
use Hash;

class HomeController extends Controller
{

    public function index()
    {

        $user = Auth::user();
        $userExamId = $user->userAnswer->pluck('exam_id')->toArray();

        $categoryVocabulary = Category::getCategoryByName(QUESTON_VOCABULARY);
        $examVocabulary = null;
        if ($categoryVocabulary) {
            $examVocabulary = Exam::with(['category' => function($query) {
                    return $query->select('id', 'name');
                }])
                ->where('category_id', $categoryVocabulary->id)
                ->where('status', 1)
                ->select('id', 'time_question', 'title', 'description', 'category_id')
                ->orderBy('priority', 'ASC')->first();

        }

        $questionByCategory = Category::getCategoryByName(QUESTION_BY_CATEGORY);
        $exam = null;
        if ($questionByCategory) {
            $arrExamId = Exam::where('category_id', $questionByCategory->id)->select('id')->pluck('id')->toArray();
            $key = array_rand($arrExamId);
            $examId = $arrExamId[$key];
            $exam = Exam::with(['category' => function($query) {
                    return $query->select('id', 'name');
                }])->where('category_id', $questionByCategory->id)
                ->where(function ($query) use ($examId) {
                    if (!empty($examId) && env('ACTIVE_CHECK_EXAM')) {
                        return $query->where('id', $examId);
                    }
                })
                ->where('status', 1)
                ->select('id', 'time_question', 'title', 'description', 'category_id')
                ->orderBy('priority', 'ASC')->first();
        }

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => [
                'exam_by_vocabulary' => $examVocabulary,
                'exam_by_category' => $exam,
            ]
        ]);
    }

    public function getSlider()
    {
        $sliders = Slider::where('status', 1)
            ->select('id', 'src', 'link', 'description')
            ->orderBy('id', 'DESC')->take(10)->get();

        $slidersFormat = $this->formatSlider($sliders);

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $slidersFormat
        ]);
    }


    public function getWallet()
    {
        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'wallet_money' => auth::user()->wallet
        ]);
    }

    public function getMyData(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $articles = Exam::with(['category' => function ($query) {
            return $query->select('id', 'name');
        }])
            ->whereHas('users', function ($query) {
                return $query->where('user_id', auth::user()->id);
            })
            ->select('id', 'title', 'data', 'price', 'expired_at', 'fee_every_day', 'category_id')
            ->orderBy('expired_at', 'ASC')
            ->paginate($perPage);

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $articles
        ]);


    }

    public function formatSlider($sliders)
    {
        foreach ($sliders as $slider) {
            $slider->src = getUrlFile($slider->src);
        }

        return $sliders;
    }

    public function formatServices($data)
    {
        foreach ($data as $item) {
            $item->thumbnail = getUrlFile($item->thumbnail);
        }

        return $data;
    }

    public function formatDataUsing($data)
    {
        $list = [];

        foreach ($data as $item) {
            if (empty($item->expired_at) || $item->expired_at >= date('Y-m-d')) {
                $arr['id'] = $item->id;
                $arr['title'] = $item->title;
                $arr['thumbnail'] = !empty($item->thumbnail) ? getUrlFile($item->thumbnail) : null;
                $arr['data'] = $item->data;
                $arr['price'] = $item->price;
                $arr['expired_at'] = $item->expired_at;
                $arr['fee_every_day'] = $item->fee_every_day;
                $arr['category_id'] = $item->category_id;

                $list[] = $arr;
            }
        }

        return $list;
    }

    public function notification(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $type = $request->get('type') ? $request->get('type') : null;

        $notifications = Notification::where(function ($query) use ($type) {
            if (empty($type)) {
                return $query->doesntHave('userReadNotification');
            }
        })->where('status', 1)->orderBy('id', 'DESC')
            ->paginate($perPage);

        foreach ($notifications as $notification) {
            $notification->is_readed = false;
            if (count($notification->userReadNotification) > 0) {
                $notification->is_readed = true;
            }
        }

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $notifications
        ]);
    }

    public function detailNotification($id)
    {

        if (empty($id)) {

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'id không được để trống.',
            ]);
        }
        $notification = Notification::find($id);
        $userReadNotify = UserReadNotification::where('user_id', auth::user()->id)
            ->where('notification_id', $id)->first();
        if (empty($userReadNotify)) {
            $userReadNotication = new UserReadNotification();
            $userReadNotication->user_id = auth::user()->id;
            $userReadNotication->notification_id = $notification->id;
            $userReadNotication->save();
        }

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $notification
        ]);
    }

    public function getRank(Request $request)
    {
        $examId = $request->get('exam_id');

        $user = Auth::user();
        $userExamId = $user->userAnswer->pluck('exam_id')->toArray();

//        if (!empty($id)) {
//            $examId = $id;
//
//        } else {
//            // 3000 tu vung
//            $categoryVocabulary = Category::getCategoryByName(QUESTON_VOCABULARY);
//            if ($categoryVocabulary) {
//                $exam = Exam::where('category_id', $categoryVocabulary->id)->where('status', 1)
//                    ->select('id', 'category_id')->first();
//
//                $examId = $exam->id ? $exam->id : null;
//            }
//        }
        $ranks = null;

        if (empty($examId)) {

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'exam_id không được để trống.',
            ]);
        }

        $ranks = UserCorrect::with(['user' => function ($query) {
                return $query->where('social_type', '!=', 3)
                    ->select('id', 'fullname', 'email', 'address');
            }])
            ->where(function ($query) use ($userExamId) {
                if (env('ACTIVE_CHECK_EXAM')) {
                    return $query->whereNotIn('exam_id', $userExamId);
                }
            })
            ->where('exam_id', $examId)
            ->where('user_id', auth::user()->id)
            ->select('id', 'exam_id', 'correct', 'created_at', 'user_id')
            ->orderBy('correct', 'DESC')
            ->orderBy('created_at', 'DESC')->take(5)->get();

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Bảng xếp hạng người dùng',
            'data' => $ranks
        ]);
    }
}

