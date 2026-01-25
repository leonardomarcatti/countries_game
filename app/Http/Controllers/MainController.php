<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;


class MainController extends Controller
{
    private array $app_data;

    public function __construct()
    {
        // Load countries and capitals

        $this->app_data = config('app_data');
    }

    public function home() : View
    {
        return \view('home');
    }

    private function prepareQuiz(int $totalQuestions)
    {
        $questions = [];
        $total_countries = count($this->app_data);
        $indexes = range(0, $total_countries-1);
        shuffle($indexes);
        $indexes_slice = \array_slice($indexes, 0, $totalQuestions);

        foreach ($indexes_slice as $key => $index) {
            $question['number'] = $key+1;
            $question['country'] = $this->app_data[$index]['country'];
            $question['correct_answer'] = $this->app_data[$index]['capital'];


            $other_capitals = \array_column($this->app_data, 'capital');
            $other_capitals = \array_diff($other_capitals, [$question['correct_answer']]);

            \shuffle($other_capitals);

            $question['wrong_answers'] = \array_slice($other_capitals, 0, 3);
            $question['correct'] = null;

            $questions[] = $question;
        }

        return $questions;
    }

    public function prepareGame(Request $r)
    {

        $r->validate([
            'total_questions' => 'required|integer|min:3|max:30'
        ], [
            'total_questions.required' => 'Escolha o número de questões',
            'total_questions.integer' => 'Ocampo deve ser um número inteiro',
            'total_questions.min' => 'O número mínimo deve ser 3',
            'total_questions.max' => 'O número máximo deve ser 30',
        ]);

        $totalQuestions = \intval($r->total_questions);

        $quiz = $this->prepareQuiz($totalQuestions);
        dd($quiz);
    }
}
