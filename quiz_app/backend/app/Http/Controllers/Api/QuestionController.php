<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\UserCorrect;
use Illuminate\Http\Request;
use Auth, DB;

class QuestionController extends Controller
{
    public function index($id, Request $request)
    {
        if (empty($id)) {

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'id không được để trống.',
            ]);
        }

        $perPage = $request->get('per_page') ? $request->get('per_page') : null;

        $data = Question::with(
            ['exam' => function ($query) {
                return $query->select('id', 'time_question', 'title', 'suggest_number');
            }]
        )
            ->where('exam_id', $id)
            ->where('status', 1)
            ->select('id', 'exam_id', 'priority','category', 'title', 'a', 'b', 'c', 'd',
                'answer', 'example', 'translate_example', 'created_at')
            ->orderBy('priority', 'ASC');

        if (!empty($perPage)) {
            $questions = $data->paginate($perPage);
        } else {
            $questions = [
                'current_page' => 1,
                'data' => $data->get()
            ];
        }

        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => $questions
        ]);
    }

    public function getAnswer(Request $request)
    {
        $id = (int)$request->get('question_id');
        $answer = $request->get('answer');

        $request->validate([
            'question_id' => 'required|int',
            'answer' => 'required',
        ], [
            'question_id.required' => 'question_id không được để trống',
            'question_id.int' => 'question_id phải là số nguyên',
            'answer.required' => 'answer không được để trống',
        ]);

        $question = Question::with('exam')
            ->where('id', $id)
            ->first();

        if ($question) {
            $maxQuestion = Question::where('exam_id', $question->exam_id)->max('priority');
            // so lan tra loi bo de
            $numQuest = UserAnswer::where('exam_id', $question->exam_id)
                ->where('user_id', auth::user()->id)->max('num_answer');

            $numAnser = null;

            if ($question->priority == 1) {
                $numAnser = $numQuest + 1;
            } else {
                $numAnser = $numQuest;
            }

            try {
                DB::beginTransaction();
                $correct = true;
                if ($question->answer != $answer) {
                    $correct = false;
                }

                $dataUserAnswer = [
                    'exam_id' => $question->exam_id,
                    'user_id' => auth::user()->id,
                    'question_id' => $id,
                    'answer' => $answer,
                    'answer_field' => $question->answer_field,
                    'correct' => $correct == true ? 1 : null,
                    'num_answer' => $numAnser,
                    'last_question' => ($question->priority == $maxQuestion) ? $maxQuestion : null
                ];

                $userAnswer = new UserAnswer();
                $userAnswer->fill($dataUserAnswer);
                $userAnswer->save();

                // check tong so cau tra loi dung sai?
                $userCorrect = UserCorrect::where('exam_id', $question->exam_id)
                    ->where('user_id', auth::user()->id)->where('num_answer', $numAnser)->first();

                $maxCorrect = isset($userCorrect) ? $userCorrect->correct : 0;
                $maxInCorrect = isset($userCorrect) ? $userCorrect->incorrect : 0;

                if ($correct == true) {
                    $maxCorrect += 1;
                } else {
                    $maxInCorrect += 1;
                }

                if (!empty($userCorrect)) {
                    $userCorrect->correct = $maxCorrect;
                    $userCorrect->incorrect = $maxInCorrect;
                    $userCorrect->save();
                } else {
                    $dataAnswerCorrect = [
                        'user_id' => auth::user()->id,
                        'exam_id' => $question->exam_id,
                        'category_id' => $question->exam->category_id,
                        'correct' => $maxCorrect,
                        'incorrect' => $maxInCorrect,
                        'num_answer' => $numAnser
                    ];

                    $userCorrect = new UserCorrect();
                    $userCorrect->fill($dataAnswerCorrect);
                    $userCorrect->save();
                }

                DB::commit();

                return response()->json([
                    'status' => SUCCESS,
                    'message' => 'ok',
                    'data' => [
                        'question_id' => $id,
                        'correct' => $correct,
                        'answer' => $question->answer,
                        'example' => [
                            'example' => $question->example,
                            'translate_example' => $question->translate_example,
                        ]
                    ]
                ]);

            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
            }
        }

        return response()->json([
            'status' => SUCCESS,
            'message' => 'Không tìm thấy câu hỏi này vui lòng kiểm tra lại',
            'data' => []
        ]);
    }

    public function result(Request $request)
    {
        $examId = $request->get('exam_id');
        $data = $request->get('data');

        if (empty($examId)) {

            return response()->json([
                'status' => SERVER_ERROR,
                'message' => 'exam_id không được để trống.',
            ]);
        }

        $this->saveUserAnswerQuestion($examId, $data);

        $totalQuestion = Question::where('exam_id', $examId)->where('status', 1)->count();
        $userCorrect = UserCorrect::where('exam_id', $examId)->where('user_id', auth::user()->id)
            ->orderBy('num_answer', 'DESC')->first();

        $totalCorrect = $userCorrect->correct;
        $defaultScore = 100;
        $scoresUser = 0;
//        if ($totalCorrect != 0) {
//            $scoresUser = ceil($defaultScore/$totalQuestion) * $totalCorrect;
//        }


        return response()->json([
            'status' => SUCCESS,
            'message' => 'ok',
            'data' => [
                'correct_answer' => $totalCorrect,
                'scores' => $totalCorrect,
                'total_question' => $totalQuestion
            ]
        ]);
    }

    public function saveUserAnswerQuestion($examId, $data)
    {
        // so lan tra loi bo de
        $numQuest = UserAnswer::where('exam_id', $examId)
            ->where('user_id', auth::user()->id)->max('num_answer');

        $numAnser = $numQuest + 1;

        if ($data && count($data) > 0) {
            foreach ($data as $item) {
                $id = $item['question_id'];
                $answer = $item['answer'];
                $this->userCorrect($examId, $id, $answer, $numAnser);
            }
        } else {
            $this->userCorrect($examId, 0, 'wrong', $numAnser);
        }

    }

    public function userCorrect($examId, $questionId, $answer, $numAnser)
    {
        $question = Question::with('exam')
            ->where('id', $questionId)
            ->first();
        $maxQuestion = Question::where('exam_id',$examId)->max('priority');

        $correct = false;
        if (!empty($question) && $question->answer == $answer) {
            $correct = true;
        }

        $dataUserAnswer = [
            'exam_id' => $examId,
            'user_id' => auth::user()->id,
            'question_id' => $questionId,
            'answer' => $answer,
            'answer_field' => isset($question) ? $question->answer_field : null,
            'correct' => $correct == true ? 1 : null,
            'num_answer' => $numAnser,
            'last_question' => (isset($question) && $question->priority == $maxQuestion) ? $maxQuestion : null
        ];

        $userAnswer = new UserAnswer();
        $userAnswer->fill($dataUserAnswer);
        $userAnswer->save();

        // check tong so cau tra loi dung sai?
        $userCorrect = UserCorrect::where('exam_id', $examId)
            ->where('user_id', auth::user()->id)
            ->where('num_answer', $numAnser)->first();

        $maxCorrect = isset($userCorrect) ? $userCorrect->correct : 0;
        $maxInCorrect = isset($userCorrect) ? $userCorrect->incorrect : 0;

        if ($correct == true) {
            $maxCorrect += 1;
        } else {
            if (empty($question)) {
                $maxInCorrect = Question::where('exam_id', $examId)->count();
            } else {
                $maxInCorrect += 1;
            }
        }

        if (!empty($userCorrect)) {
            $userCorrect->correct = $maxCorrect;
            $userCorrect->incorrect = $maxInCorrect;
            $userCorrect->save();
        } else {
            $dataAnswerCorrect = [
                'user_id' => auth::user()->id,
                'exam_id' => $examId,
                'category_id' => !empty($question) ? $question->exam->category_id : null,
                'correct' => $maxCorrect,
                'incorrect' => $maxInCorrect,
                'num_answer' => $numAnser
            ];

            $userCorrect = new UserCorrect();
            $userCorrect->fill($dataAnswerCorrect);
            $userCorrect->save();
        }
    }
}
