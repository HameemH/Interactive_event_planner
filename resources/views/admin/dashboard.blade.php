@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Organizer Dashboard</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-100 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800">Total Events</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $eventStats['total'] }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-yellow-800">Pending Events</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $eventStats['pending'] }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-green-800">Approved Events</h3>
                <p class="text-3xl font-bold text-green-600">{{ $eventStats['approved'] }}</p>
            </div>
            <div class="bg-red-100 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-red-800">Rejected Events</h3>
                <p class="text-3xl font-bold text-red-600">{{ $eventStats['rejected'] }}</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex gap-4 mb-8">
            <a href="{{ route('admin.events') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="fas fa-calendar-alt mr-2"></i>
                Manage Events
            </a>
            <a href="{{ route('admin.users') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-users mr-2"></i>
                Manage Users
            </a>
        </div>

        <!-- Recent Events Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Recent Events</h2>
                <a href="{{ route('admin.events') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    View All Events
                </a>
            </div>

            @if($events->count() > 0)
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cost</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($events->take(5) as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $event->event_name }}</div>
                                    <div class="text-sm text-gray-500">{{ ucfirst($event->category) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $event->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->event_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ৳{{ number_format($event->total_cost, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $event->status_badge_color }}">
                                        {{ $event->formatted_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">No events submitted yet.</p>
                </div>
            @endif
        </div>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Recent Users</h2>
            <a href="{{ route('admin.users') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Manage All Users
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($users->take(5) as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'organizer' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection