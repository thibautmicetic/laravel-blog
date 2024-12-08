<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Message flash -->
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Message flash -->
            @if (session('insertSuccess'))
                <div class="bg-green-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                    {{ session('insertSuccess') }}
                </div>
            @endif

            <!-- Message flash -->
            @if (session('updateSuccess'))
                <div class="bg-green-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                    {{ session('updateSuccess') }}
                </div>
            @endif

            <!-- Message flash -->
            @if (session('deleteSuccess'))
                <div class="bg-green-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
                    {{ session('deleteSuccess') }}
                </div>
            @endif

            <!-- Articles -->
            @if($articles->count() > 0)
            @foreach ($articles as $article)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-2xl font-bold">{{ $article->title }}</h2>
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
                        <p class="text-gray-700">{{ substr($article->content, 0, 30) }}...</p>
                        <div class="d-flex flex-row">
                            <div class="text-right">
                                <a href="{{ route('articles.edit', $article->id) }}" class="text-gray-600 hover:text-gray-950">Modifier</a>
                            </div>
                            <form method="post" action="{{ route('articles.remove', $article) }}" class="mt-2">
                                @csrf
                                @method('delete')

                                <div class="flex justify-end">
                                    <x-danger-button class="ms-3">
                                        {{ __('Supprimer') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-4">
                {{ $articles->links() }}
            </div>
                @else
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Vous n'avez pas créé d'articles.") }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
