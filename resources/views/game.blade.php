<x-main-layout pageTitle="Countries and Capitals Quiz">

    <body>
        <main class="container">
            <x-question :country="$country" :currentQuestion="$currentQuestion" :totalQuestions="$totalQuestions" />
            <div class="row">
                @foreach ($answers as $answer)
                    <x-answer :capital=$answer />
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-danger mt-3 px-5">CANCELAR JOGO</a>
            </div>
        </main>
    </body>

</x-main-layout>
