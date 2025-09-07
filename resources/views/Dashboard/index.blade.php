@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
    <div class="glass-card p-10 rounded-3xl w-[800px] min-h-[500px] flex flex-col shadow-lg">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Event Dashboard</h1>

        <!-- Total Estimated Price -->
        <div class="mb-6 text-right">
            <span id="total-estimated-cost" class="px-6 py-3 bg-indigo-800 text-white rounded-full text-lg">
                Total Estimated Price: ৳0
            </span>
        </div>

        <!-- Dashboard Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Venue -->
            <div class="p-4 bg-white/50 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-2">Venue</h2>
                <p id="venue-info" class="text-gray-700 text-sm">Loading...</p>
            </div>

            <!-- Seating -->
            <div class="p-4 bg-white/50 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-2">Seating</h2>
                <p id="seating-info" class="text-gray-700 text-sm">Loading...</p>
            </div>

            <!-- Stage -->
            <div class="p-4 bg-white/50 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-2">Stage & Decoration</h2>
                <p id="stage-info" class="text-gray-700 text-sm">Loading...</p>
                <img id="stage-image" src="" alt="" class="mt-2 rounded-lg hidden w-40 h-28 object-cover">
            </div>

            <!-- Catering -->
            <div class="p-4 bg-white/50 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-2">Catering</h2>
                <p id="catering-info" class="text-gray-700 text-sm">Loading...</p>
            </div>

            <!-- Photography -->
            <div class="p-4 bg-white/50 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-2">Photography</h2>
                <p id="photography-info" class="text-gray-700 text-sm">Loading...</p>
            </div>

            <!-- Extra Options -->
            <div class="p-4 bg-white/50 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-2">Extra Options</h2>
                <p id="extra-info" class="text-gray-700 text-sm">Loading...</p>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex justify-between">
            <a href="{{ route('custom-event.index') }}" 
               class="px-6 py-3 bg-gray-300 rounded-full font-semibold hover:bg-gray-400">
                ⬅ Start Over
            </a>
            <button id="download-receipt" 
                    class="px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700">
                Download Receipt
            </button>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
    const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
    const stage = JSON.parse(localStorage.getItem('event_stage') || '{}');
    const catering = JSON.parse(localStorage.getItem('event_catering') || '{}');
    const photography = JSON.parse(localStorage.getItem('event_photography') || '{}');
    const extra = JSON.parse(localStorage.getItem('event_extra') || '{}');

    let total = 0;

    // Venue
    if (venue.size) {
        document.getElementById('venue-info').innerText =
            `${venue.type === 'predefined' ? venue.predefined : 'Custom'} | Size: ${venue.size} sqm | Address: ${venue.address} | Cost: ৳${venue.cost}`;
        total += venue.cost || 0;
    }

    // Seating
    if (seating.attendees) {
        document.getElementById('seating-info').innerText =
            `${seating.attendees} guests | Chair: ${seating.chairType} | Table: ${seating.tableType} | Seat Cover: ${seating.seatCover} | Cost: ৳${seating.cost}`;
        total += seating.cost || 0;
    }

    // Stage
    if (stage.type) {
        document.getElementById('stage-info').innerText =
            `${stage.type} stage ${stage.decoration ? '+ Decoration' : ''} | Cost: ৳${stage.cost}`;
        if (stage.image) {
            const img = document.getElementById('stage-image');
            img.src = stage.image;
            img.classList.remove('hidden');
        }
        total += stage.cost || 0;
    }

    // Catering
    let cateringDetails = '';
    if (catering.catering_required) {
        cateringDetails = `Catering Required: ${catering.catering_required ? 'Yes' : 'No'} | Per Person: ৳${catering.per_person_cost} | Guests: ${catering.total_guests} | Total Cost: ৳${catering.total_catering_cost}`;
        total += catering.total_catering_cost || 0;
    }
    // Integrate catering_selection info if available
    const cateringSelection = JSON.parse(localStorage.getItem('catering_selection') || '{}');
    if (cateringSelection.set_menu) {
        cateringDetails += `\nSet Menu: ${cateringSelection.set_menu}`;
    }
    if (cateringSelection.extra_items && cateringSelection.extra_items.length > 0) {
        cateringDetails += `\nExtra Items: ${cateringSelection.extra_items.join(', ')}`;
    }
    if (cateringDetails) {
        document.getElementById('catering-info').innerText = cateringDetails;
    }

    // Photography
    if (photography.package) {
        document.getElementById('photography-info').innerText =
            `Package: ${photography.package} | Hours: ${photography.hours} | Cost: ৳${photography.cost}`;
        total += photography.cost || 0;
    }

    // Extra
    if (extra.selected && extra.selected.length > 0) {
        document.getElementById('extra-info').innerText =
            `${extra.selected.join(', ')} | Cost: ৳${extra.cost}`;
        total += extra.cost || 0;
    }

    // Total
    document.getElementById('total-estimated-cost').innerText = `Total Estimated Price: ৳${total}`;

    // Download receipt
    document.getElementById('download-receipt').addEventListener('click', function () {
    const eventData = {
        venue, seating, stage, catering, photography, extra, total
    };

    const query = new URLSearchParams({ event_data: JSON.stringify(eventData) });

    window.location.href = `/download-receipt?${query.toString()}`;
});

});
</script>
@endsection
@endsection
