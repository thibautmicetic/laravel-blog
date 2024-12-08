@php
 $isFullWidth = true;
@endphp

<x-guest-layout>
    <x-card>
        <div class="text-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">
                {{ $article->title }}
            </h2>
        </div>

        <div class="text-gray-500 text-sm">
            Publié le {{ $article->created_at->format('d/m/Y') }} par <a href="{{ route('public.index', $article->user->id) }}">{{ $article->user->name }}</a>
        </div>

        <div class="flex">
            @foreach ($article->categories as $category)
                <div class="bg-gray-200 rounded-full mr-2 my-1 p-2 text-sm">
                    <h3>{{ $category->name }}</h3>
                </div>
            @endforeach
        </div>

        <div>
            <div class="mt-6 text-gray-900 dark:text-gray-100">
                <p class="text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="text-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">
                Commentaires
            </h2>
        </div>

        @auth
            <!-- Ajout d'un commentaire -->
            <form action="{{ route('comments.store', ['article' => $article->id]) }}" method="post" class="mt-6">
                @csrf
                @method('POST')
                <input type="hidden" name="articleId" value="{{ $article->id }}">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-gray-900">
                        <!-- Input de titre de l'article -->
                        <textarea type="text" rows="5" name="comment" id="comment" placeholder="Votre commentaire" class="w-full rounded-md @if($errors->has('comment')) border-red-500 @else border-gray-300 @endif shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('comment') is-invalid @enderror"></textarea>
                        @error('comment')
                        <div class="alert alert-danger text-red-500 pt-2">Ce champs est requis</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="shadow-md mt-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Publier
                    </button>
                </div>
            </form>
        @endauth

        @if($comments->isEmpty())
            <x-card :width="$isFullWidth">
                <div class="text-gray-500 text-sm">
                    Aucun commentaire
                </div>
            </x-card>
        @else
            @foreach($comments as $comment)
                <x-card :width="$isFullWidth">
                    <div class="text-gray-500 text-sm">
                        Publié le {{ $comment->created_at->format('d/m/Y') }} par {{ $article->user->name }}
                    </div>

                    <div class="text-gray-500 text-sm">
                        {{$comment->content}}
                    </div>
                </x-card>
            @endforeach
            <div class="mt-6">
                {{$comments->links()}}
            </div>
        @endif
    </x-card>

</x-guest-layout>
