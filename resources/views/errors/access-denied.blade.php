@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto text-center">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Error Icon -->
            <div class="mb-6">
                <svg class="mx-auto h-24 w-24 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 8.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>

            <!-- Error Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Access Denied</h1>
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @else
                <p class="text-gray-600 mb-6">
                    You don't have permission to access this area. Please contact an administrator if you believe this is an error.
                </p>
            @endif

            <!-- User Info -->
            <div class="bg-gray-100 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-600">
                    <strong>Current User:</strong> {{ Auth::user()->name }} ({{ Auth::user()->email }})
                </p>
                <p class="text-sm text-gray-600">
                    <strong>Your Role:</strong> 
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ Auth::user()->role === 'organizer' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(Auth::user()->isOrganizer())
                    <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                        Go to Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                        Go to Dashboard
                    </a>
                @endif
                
                <a href="{{ url('/') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                    Go to Home
                </a>
            </div>

            <!-- Help Text -->
            <div class="mt-8 text-sm text-gray-500">
                <p>If you need different permissions, please contact an organizer to update your account role.</p>
            </div>
        </div>
    </div>
</div>
@endsection