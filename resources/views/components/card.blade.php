{{--Afficher ou non une carte sur toute la largeur de l'écran, passé dynamiquement--}}
@props(['width' => false])

<div class="{{ $width ? 'w-full' : 'w-5/6' }} mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">{{$slot}}</div>
