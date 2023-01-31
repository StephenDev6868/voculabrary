<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToCollection, WithHeadingRow
{
    protected $exam;
    protected $type;

    public function __construct($exam, $type)
    {
        $this->exam = $exam;
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function collection(Collection $collection)
    {
        // TODO: Implement collection() method.
        $arrTitle = ['a', 'b', 'c', 'd'];
        $arrNum = [0, 1, 2, 3];

        $arrCorrectAnswer = [];

        foreach ($collection as $key => $row) {
            $num = mt_rand(0, 3);
            $a = $arrTitle[$num];
            $newArr1 = array_diff($arrNum, [$num]);

            $numB = $this->getIndexOfArray($newArr1);
            $b = $arrTitle[$numB];
            $newArr2 = array_diff($newArr1, [$numB]);


            $numC = $this->getIndexOfArray($newArr2);
            $c = $arrTitle[$numC];
            $newArr3 = array_diff($newArr2, [$numC]);

            $numD = $this->getIndexOfArray($newArr3);
            $d = $arrTitle[$numD];

            $data = [
                'exam_id' => $this->exam->id,
                'priority' => $row['stt'],
                'category' => $row['chu_de'],
                'title' => $row['dich_nghia'],
                $a => strtolower($row['dap_an_dung']),
                $b => strtolower($row['dap_an_sai_1']),
                $c => strtolower($row['dap_an_sai_2']),
                $d => strtolower($row['dap_an_sai_3']),
                'answer' => strtolower($row['dap_an_dung']),
                'answer_field' =>  $a,
                'example' => $row['vi_du'],
                'translate_example' => $row['dich_nghia_vd'],
            ];

//            $data1 = [
//                'data' => $data,
//                'a' => [
//                    'so' => $num,
//                    'a' => $a,
//                    'arr' => $newArr1
//                ],
//                'b' => [
//                    'so' => $numB,
//                    'a' => $b,
//                    'arr' => $newArr2
//                ],
//                'c' => [
//                    'so' => $numC,
//                    'a' => $c,
//                    'arr' => $newArr3
//                ],
//                'd' => [
//                    'so' => $numD,
//                    'a' => $d,
//                    'arr' => $arrNum
//                ]
//
//            ];

            $question = new Question();
            $question->fill($data);
            $question->save();

            $arr = [$question->id => $a];
            $arrCorrectAnswer[] = $arr;
        }

        if (!empty($arrCorrectAnswer) && count($arrCorrectAnswer) > 0) {
            $this->exam->answer = json_encode($arrCorrectAnswer);
            $this->exam->save();
        }
    }

    public function getIndexOfArray($arr)
    {
        $first = array_key_first($arr);
        $last = array_key_last($arr);

        if ($first == 1 && $last == 3) {
            return $last;
        }
        if ($first == 0 && $last == 2) {
            return $first;
        }

        if ($first == 0 && $last == 3) {
            return $last;
        }

        return mt_rand($first, $last);
    }
}
