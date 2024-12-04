<x-guest-layout>
    <div class="text-center mb-6 mt-3">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des articles publiés de {{ $user->name }}
        </h2>
    </div>

    <!-- Message flash -->
    @if (session('errorDraft'))
        <div class="bg-red-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
            {{ session('errorDraft') }}
        </div>
    @endif

    <div>
        <hr>
        <!-- Articles -->
        @foreach ($articles as $article)
            <div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold">{{ $article->title }}</h2>
                    <p class="text-gray-700 dark:text-gray-300">{{ substr($article->content, 0, 30) }}...</p>

                    <a href="{{ route('public.show', [$article->user_id, $article->id]) }}" class="text-red-500 hover:text-red-700">Lire la suite</a>
                </div>
            </div>
            <hr>
        @endforeach
        <div class="mt-3">
            {{ $articles->links() }}
        </div>
    </div>
</x-guest-layout>
