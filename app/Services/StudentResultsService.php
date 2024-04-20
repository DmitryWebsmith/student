<?php

namespace App\Services;

use App\Models\StudentAnswer;
use App\Models\Task;
use App\Models\Test;

class StudentResultsService
{
    public function getResultsOfPassedTest(int $studentId, int $taskId): array
    {
        $result = [];

        $result['id'] = $studentId;
        $result['task_id'] = $taskId;
        $result['correctAnswers'] = 0;
        $result['questionNumbers'] = 0;
        $result['questions'] = [];

        $task = Task::query()->findOrFail($taskId);

        $test = Test::query()
            ->findOrFail($task->test_id);

        foreach ($test->questions as $question) {
            $incorrectAnswer = 0;

            foreach ($question->answers as $answer) {
                $studentAnswer = StudentAnswer::query()
                    ->where(
                        [
                            'task_id' => $taskId,
                            'student_id' => $studentId,
                            'answer_id' => $answer->id,
                        ]
                    )
                    ->first();

                if ($answer->type === 'text') {
                    if ($studentAnswer === null) {
                        $incorrectAnswer++;
                        continue;
                    }
                    if ($answer->answer !== $studentAnswer->text) {
                        $incorrectAnswer++;
                    }
                }

                if ($answer->type === 'radiobutton' || $answer->type === 'checkbox') {
                    if ($studentAnswer === null && $answer->truth !== 0) {
                        $incorrectAnswer++;
                    }
                    if ($studentAnswer !== null && $answer->truth !== $studentAnswer->truth) {
                        $incorrectAnswer++;
                    }
                }
            }

            $result['questions'][$question->id] = false;

            if ($incorrectAnswer === 0) {
                $result['correctAnswers'] += 1;
                $result['questions'][$question->id] = true;
            }

            $result['questionNumbers']++;
        }

        $score = $result['correctAnswers'] * 100 / $result['questionNumbers'];

        if ($score >= 85) {
            $result['score'] = 5;
        } elseif ($score < 85 && $score >= 75) {
            $result['score'] = 4;
        } elseif ($score < 75 && $score >= 60) {
            $result['score'] = 3;
        } elseif ($score < 60) {
            $result['score'] = 2;
        }

        return $result;
    }
}
