@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full bg-white border-4 border-blue-200 text-gray-700 rounded-2xl shadow-sm focus:border-pink-400 focus:ring-4 focus:ring-pink-200 focus:outline-none placeholder-blue-300 py-4 px-5 font-bold text-lg transition-all duration-300 hover:border-blue-400']) !!}>