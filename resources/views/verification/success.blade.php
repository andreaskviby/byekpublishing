@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center">
        <!-- Success Icon -->
        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-display font-bold text-gray-900 mb-4">{{ $title }}</h1>

        <!-- Message -->
        <p class="text-gray-600 mb-8 leading-relaxed">{{ $message }}</p>

        <!-- Decorative Element -->
        @if($type === 'review')
            <div class="text-4xl mb-6">🦋🦋🦋</div>
        @else
            <div class="text-4xl mb-6">📧✨💝</div>
        @endif

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('home') }}" 
               class="block w-full bg-primary-600 text-white py-3 px-6 rounded-lg font-semibold
                      hover:bg-primary-700 transition-colors duration-200">
                Return to Homepage
            </a>
            <a href="{{ route('books') }}" 
               class="block w-full text-primary-600 py-3 px-6 rounded-lg font-semibold
                      hover:bg-primary-50 transition-colors duration-200">
                Browse More Books
            </a>
        </div>
    </div>
</div>
@endsection