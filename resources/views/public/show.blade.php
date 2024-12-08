@php
 $isFullWidth = true;
@endphp

<x-guest-layout>
    <x-card>
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">
                {{ $article->title }}
            </h2>
            @auth
                <a href="{{ route('article.like', $article) }}" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.719,17.073l-6.562-6.51c-0.27-0.268-0.504-0.567-0.696-0.888C1.385,7.89,1.67,5.613,3.155,4.14c0.864-0.856,2.012-1.329,3.233-1.329c1.924,0,3.115,1.12,3.612,1.752c0.499-0.634,1.689-1.752,3.612-1.752c1.221,0,2.369,0.472,3.233,1.329c1.484,1.473,1.771,3.75,0.693,5.537c-0.19,0.32-0.425,0.618-0.695,0.887l-6.562,6.51C10.125,17.229,9.875,17.229,9.719,17.073 M6.388,3.61C5.379,3.61,4.431,4,3.717,4.707C2.495,5.92,2.259,7.794,3.145,9.265c0.158,0.265,0.351,0.51,0.574,0.731L10,16.228l6.281-6.232c0.224-0.221,0.416-0.466,0.573-0.729c0.887-1.472,0.651-3.346-0.571-4.56C15.57,4,14.621,3.61,13.612,3.61c-1.43,0-2.639,0.786-3.268,1.863c-0.154,0.264-0.536,0.264-0.69,0C9.029,4.397,7.82,3.61,6.388,3.61" clip-rule="evenodd" />
                    </svg>
                    <span>{{$article->likes}}</span>
                </a>
            @endauth
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
