<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Category;
use App\Models\HistoryUserRegisterService;
use App\Models\UserArticle;
use Illuminate\Http\Request;
use Auth, DB;

class ArticleController extends Controller
{
    public function search(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search') ? $request->get('search') : null;

        $articles = Exam::where(function ($query) use ($search) {
            if (!empty($search)) {
                return $query->where('title', 'LIKE', $search . "%");
            }
        })
            ->select('id', 'title', 'data', 'price', 'expired_at', 'fee_every_day', 'category_id')
            ->paginate($perPage);


        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $articles
        ]);

    }

    public function getListCategory(Request $request)
    {
        $categoryId = $request->get('category_id');
        $categories = Category::where('status', 1)
            ->where(function ($query) use ($categoryId) {
                if (!empty($categoryId)) {
                    return $query->where('id', $categoryId);
                }
            })
            ->select('id', 'name')->get();

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $categories
        ]);

    }

    public function getDataByCategoryId(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $categoryId = $request->get('category_id');

        $articles = Exam::with([
            'category' => function ($query) {
                return $query->select('id', 'name');
            }
        ])->where(function ($query) use ($categoryId) {
            if (!empty($search)) {
                return $query->where('category_id', $categoryId);
            }
        })
            ->select('id', 'title', 'thumbnail', 'description', 'data', 'price', 'expired_at', 'fee_every_day', 'category_id')
            ->paginate($perPage);

        if (!empty($articles)) {
            foreach ($articles as $article) {
                $article->thumbnail = !empty($article->thumbnail) ? getUrlFile($article->thumbnail) : null;
            }
        }


        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $articles
        ]);
    }

    public function show($id)
    {
        $article = Exam::with([
            'category' => function ($query) {
                return $query->select('id', 'name');
            }
        ])->where('id', $id)->select('id', 'title', 'thumbnail', 'description', 'content',
            'data', 'price', 'expired_at', 'fee_every_day', 'created_at', 'updated_at', 'category_id')->first();

        if (!empty($article)) {
            $article->thumbnail = !empty($article->thumbnail) ? getUrlFile($article->thumbnail) : null;
        }

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $article
        ]);
    }

    public function registerService(Request $request)
    {
        $id = $request->get('id');

        if (empty($id)) {

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'id không được để trống.',
            ]);
        }

        $article = Exam::where('id', $id)->first();

        if (empty($article)) {

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Không tìm thấy dịch vụ này vui lòng kiểm tra lại.',
            ]);
        }

        if ($article->status != 1) {
            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'Dịch vụ này tạm thời bị khoá.',
            ]);
        }

        $user = auth::user();
        $myWallet = $user->wallet;
        $categogryName = $article->category->name;

        if ($myWallet < $article->price) {

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Số tiền trong ví không đủ để đăng ký.'
            ]);
        }

        if (!empty($article->expired_at) && date('Y-m-d') > $article->expired_at) {

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Thông tin ' . strtolower($categogryName) . ' đã hết hạn sử dụng'
            ]);
        }

        try {
            DB::beginTransaction();
            $userArticle = new UserArticle();
            $userArticle->user_id = $user->id;
            $userArticle->article_id = $id;
            $userArticle->price = $article->price;
            $userArticle->save();

            $historyRegisterService = new HistoryUserRegisterService();
            $historyRegisterService->user_id = $user->id;
            $historyRegisterService->article_id = $id;
            $historyRegisterService->total_wallet = $myWallet;
            $historyRegisterService->price = $article->price;
            $historyRegisterService->save();

            $user->wallet = $myWallet - $article->price;
            $user->save();

            DB::commit();

            return response()->json([
                'status' => SUCCESS,
                'message' => 'Đăng ký thành công',
                'data' => [
                    'category' => $categogryName,
                    'title' => $article->title
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'error',
                'data' => $e
            ]);

        }

    }
}
