<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Voting - {{ $voting->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        .header {
            border-bottom: 3px solid #3564f5;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #3564f5;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        .info-section {
            background-color: #f9fafb;
            border-left: 4px solid #3564f5;
            padding: 15px;
            margin-bottom: 30px;
        }
        .info-section p {
            margin: 5px 0;
            font-size: 14px;
        }
        .info-section strong {
            color: #1a3ab8;
        }
        .results-section {
            margin-bottom: 40px;
        }
        .results-section h2 {
            color: #1a3ab8;
            font-size: 18px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        .result-item {
            background-color: #f3f4f6;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .result-item-header {
            margin-bottom: 8px;
            position: relative;
            height: 25px;
        }
        .result-item-name {
            font-weight: bold;
            color: #1a3ab8;
            font-size: 16px;
            display: inline-block;
        }
        .result-item-votes {
            color: #3564f5;
            font-weight: bold;
            font-size: 18px;
            float: right;
        }
        .result-item-percentage {
            color: #666;
            font-size: 12px;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 5px;
        }
        .progress-fill {
            height: 100%;
            background-color: #3564f5;
        }
        .progress-fill.color-1 {
            background-color: #3564f5;
        }
        .progress-fill.color-2 {
            background-color: #10b981;
        }
        .progress-fill.color-3 {
            background-color: #f59e0b;
        }
        .progress-fill.color-4 {
            background-color: #ef4444;
        }
        .progress-fill.color-5 {
            background-color: #8b5cf6;
        }
        .audit-section {
            margin-top: 40px;
        }
        .audit-section h2 {
            color: #1a3ab8;
            font-size: 18px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #f3f4f6;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #d1d5db;
            color: #1a3ab8;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .timestamp {
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $voting->title }}</h1>
            <p class="subtitle">Laporan Hasil Voting</p>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <p><strong>Status:</strong> {{ ucfirst($voting->status) }}</p>
            <p><strong>Total Pemilih:</strong> {{ $totalVotes }} suara</p>
            <p><strong>Total Kandidat:</strong> {{ $voting->candidates()->count() }}</p>
            <p><strong>Tanggal Laporan:</strong> {{ \App\Helpers\DateHelper::formatInUserTimezone(now(), 'd M Y H:i') }}</p>
            @if ($voting->description)
                <p><strong>Deskripsi:</strong> {{ $voting->description }}</p>
            @endif
        </div>

        <!-- Results Section -->
        <div class="results-section">
            <h2>Hasil Voting - Top {{ $voting->top_results }}</h2>

            @php
                $topResults = $voting->candidates()
                    ->withCount('votes')
                    ->orderByDesc('votes_count')
                    ->take($voting->top_results)
                    ->get();
            @endphp

            @foreach ($topResults as $candidate)
                @php
                    $percentage = $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 1) : 0;
                    $colorIndex = ($loop->index % 5) + 1; // Cycle through colors 1-5
                @endphp
                <div class="result-item">
                    <div class="result-item-header">
                        <span class="result-item-name">{{ $candidate->name }}</span>
                        <span class="result-item-votes">{{ $candidate->votes_count }} suara</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill color-{{ $colorIndex }}" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="result-item-percentage">{{ $percentage }}% dari total suara</div>
                </div>
            @endforeach
        </div>

        <!-- Audit Section (if finished) -->
        @if ($voting->status === 'finished' && $showAudit)
            <div class="audit-section">
                <h2>Data Pemilih (Audit Trail)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pemilih</th>
                            <th>Kandidat Pilihan</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voting->votes()->with(['voter', 'candidate'])->latest()->get() as $index => $vote)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $vote->voter->name }}</td>
                                <td>{{ $vote->candidate->name }}</td>
                                <td>{{ $vote->created_at->format('d M Y H:i') }} UTC</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dibuat oleh E-Voting System</p>
            <p class="timestamp">Dihasilkan pada: {{ \App\Helpers\DateHelper::formatInUserTimezone(now(), 'd M Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
