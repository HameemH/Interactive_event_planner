@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Event Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
        
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

        <!-- Filter and Search -->
        <div class="mb-6 flex flex-wrap gap-4">
            <select class="border border-gray-300 rounded px-3 py-2" onchange="filterEvents(this.value)">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="completed">Completed</option>
            </select>
            <input type="text" placeholder="Search events..." class="border border-gray-300 rounded px-3 py-2 flex-1 min-w-64" onkeyup="searchEvents(this.value)" />
        </div>

        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200" id="eventsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Cost</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($events as $event)
                        <tr class="event-row" data-status="{{ $event->status }}" data-search="{{ strtolower($event->event_name . ' ' . $event->user->name . ' ' . $event->category) }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $event->event_name }}</div>
                                <div class="text-sm text-gray-500">{{ ucfirst($event->category) }} Event</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $event->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $event->user->email }}</div>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                @if($event->isPending())
                                    <form method="POST" action="{{ route('admin.events.status', $event) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-green-600 hover:text-green-900 ml-2">
                                            <i class="fas fa-check mr-1"></i>Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.events.status', $event) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('Are you sure you want to reject this event?')">
                                            <i class="fas fa-times mr-1"></i>Reject
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Events Found</h3>
                <p class="text-gray-500">No events have been submitted yet.</p>
            </div>
        @endif
    </div>
</div>

<script>
function filterEvents(status) {
    const rows = document.querySelectorAll('.event-row');
    rows.forEach(row => {
        if (status === '' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function searchEvents(query) {
    const rows = document.querySelectorAll('.event-row');
    const searchTerm = query.toLowerCase();
    
    rows.forEach(row => {
        const searchData = row.dataset.search;
        if (searchData.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection