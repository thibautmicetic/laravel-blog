<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer un article
        </h2>
    </x-slot>

    <form method="post" action="{{ route('articles.store') }}" class="py-12">
        @csrf
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <!-- Input de titre de l'article -->
                    <input type="text" name="title" id="title" placeholder="Titre de l'article" class="w-full rounded-md @if($errors->has('title')) border-red-500 @else border-gray-300 @endif shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('title') is-invalid @enderror">
                    @error('title')
                     <div class="alert alert-danger text-red-500 pt-2">Ce champs est requis</div>
                    @enderror
                </div>

                <div class="pb-6 px-6 text-gray-900">
                    <!-- Label du select -->
                    <label for="categories" class="block text-sm font-medium text-gray-700 mb-2">
                        Sélectionnez les catégories
                    </label>

                    <!-- Select des catégories de l'article -->
                    <select name="categories[]" id="categories" multiple
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="p-6 pt-0 text-gray-900 ">
                    <!-- Contenu de l'article -->
                    <textarea rows="30" name="content" id="content" placeholder="Contenu de l'article" class="w-full @if($errors->has('content')) border-red-500 @else border-gray-300 @endif rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('title') is-invalid @enderror"></textarea>
                    @error('title')
                    <div class="alert alert-danger text-red-500 pt-2">Ce champs est requis</div>
                    @enderror
                </div>

                <div class="p-6 text-gray-900 flex items-center">
                    <!-- Action sur le formulaire -->
                    <div class="grow">
                        <input type="checkbox" name="draft" id="draft" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <label for="draft">Article en brouillon</label>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Créer l'article
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
