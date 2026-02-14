<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use function Pest\Laravel\session;

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

    private function prepareQuiz(int $totalQuestions): array
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

    public function prepareGame(Request $r): RedirectResponse
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

        \session()->put(['quiz' => $quiz, 'total_questions' => $totalQuestions, 'current_question' => 1, 'correct_answers' => 0, 'wrong_answers' => 0]);

        return \redirect()->route('game');
    }

    public function game() : View
    {
        $quiz = \session()->get('quiz');
        $total_questions = \session()->get('total_questions');
        $current_question = \session()->get('current_question') - 1;
        $answers = $quiz[$current_question]['wrong_answers'];
        $answers[] = $quiz[$current_question]['correct_answer'];
        \shuffle($answers);
        $data = ['country' => $quiz[$current_question]['country'], 'totalQuestions' => $total_questions, 'currentQuestion' => $current_question, 'answers' => $answers];

        return view('game', $data);

    }

    public function answer($cript): View|RedirectResponse
    {
        try {
            $answer =  Crypt::decryptString($cript);
        } catch (\Exception $error) {
            return \redirect()->back();
        }

        $quiz = \session('quiz');
        $current_question = \session('current_question') - 1;
        $correct_answer = $quiz[$current_question]['correct_answer'];
        $correct_answers = \session('correct_answers');
        $wrong_answers = \session('wrong_answers');

        if ($answer == $correct_answer) {
            $correct_answers++;
            $quiz[$current_question]['correct'] = \true;
        } else {
            $wrong_answers++;
            $quiz[$current_question]['correct'] = \false;
        }

        \session()->put(['quiz' => $quiz, 'correct_answers' => $correct_answers, 'wrong_answers' => $wrong_answers]);

        $data = [
            'country' => $quiz[$current_question]['country'],
            'correct_answer' => $correct_answer,
            'chosen_answer' => $answer,
            'current_question' => $current_question,
            'total_questions' => \session('total_questions')
        ];


        return \view('answer_result', $data);
    }

    public function nextQuestion() : RedirectResponse
    {
        $current_question = \session('current_question');
        $total_questions = \session('total_questions');

        if ($current_question < $total_questions) {
            $current_question++;
            \session()->put(['current_question' => $current_question]);
            return \redirect()->route('game');
        } else {
            return \redirect()->route('show_results');
        }
    }

    public function calculatePercentage() : float
    {
        return round(\session('correct_answers') / \session('total_questions') * 100, 2 );
    }

    public function showResults(): View
    {
        echo "<h1>Resultados finais</h1>";

        $data = [
            'total_questions' => \session('total_questions'),
            'correct_answers' => \session('correct_answers'),
            'wrong_answers' => \session('wrong_answers'),
            'percentage' => $this->calculatePercentage(),
        ];
        return view('final', $data);
    }
}
