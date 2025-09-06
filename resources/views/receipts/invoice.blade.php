<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; background: #f9fafb; }
        .container { width: 100%; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #4f46e5; }
        .section { margin-bottom: 20px; }
        .section h2 { background: #4f46e5; color: white; padding: 8px; border-radius: 5px; }
        .box { border: 1px solid #ddd; padding: 10px; border-radius: 5px; margin-top: 5px; }
        .total { text-align: right; font-size: 18px; font-weight: bold; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Event Receipt</h1>
            <p>Date: {{ now()->format('d M, Y') }}</p>
        </div>

        <div class="section">
            <h2>Venue</h2>
            <div class="box">
                {{ $data['venue']['predefined'] ?? 'Custom' }} |
                Size: {{ $data['venue']['size'] ?? '-' }} sqm |
                Cost: ৳{{ $data['venue']['cost'] ?? 0 }}
            </div>
        </div>

        <div class="section">
            <h2>Seating</h2>
            <div class="box">
                Guests: {{ $data['seating']['attendees'] ?? 0 }} |
                Chair: {{ $data['seating']['chairType'] ?? '-' }} |
                Cost: ৳{{ $data['seating']['cost'] ?? 0 }}
            </div>
        </div>

        <div class="section">
            <h2>Stage</h2>
            <div class="box">
                {{ $data['stage']['type'] ?? '-' }} |
                Decoration: {{ !empty($data['stage']['decoration']) ? 'Yes' : 'No' }} |
                Cost: ৳{{ $data['stage']['cost'] ?? 0 }}
            </div>
        </div>

        <div class="section">
            <h2>Catering</h2>
            <div class="box">
                Package: {{ $data['catering']['package'] ?? '-' }} |
                Guests: {{ $data['catering']['guests'] ?? 0 }} |
                Cost: ৳{{ $data['catering']['cost'] ?? 0 }}
            </div>
        </div>

        <div class="section">
            <h2>Photography</h2>
            <div class="box">
                Package: {{ $data['photography']['package'] ?? '-' }} |
                Hours: {{ $data['photography']['hours'] ?? 0 }} |
                Cost: ৳{{ $data['photography']['cost'] ?? 0 }}
            </div>
        </div>

        <div class="section">
            <h2>Extra</h2>
            <div class="box">
                {{ implode(', ', $data['extra']['selected'] ?? []) }} |
                Cost: ৳{{ $data['extra']['cost'] ?? 0 }}
            </div>
        </div>

        <div class="total">
            Total Estimated Price: ৳{{ $data['total'] ?? 0 }}
        </div>
    </div>
</body>
</html>
