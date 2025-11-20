<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <div style="background-color: #3564f5; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">Hasil Voting</h1>
    </div>

    <div style="padding: 20px; background-color: #f9fafb;">
        <p>Halo,</p>

        <p>Voting yang Anda ikuti telah selesai. Berikut hasil akhirnya:</p>

        <div style="background-color: white; border-left: 4px solid #3564f5; padding: 15px; margin: 20px 0;">
            <h2 style="margin-top: 0; color: #1a3ab8;">{{ $voting->title }}</h2>
            <p><strong>Total Pemilih:</strong> {{ $totalVotes }} suara</p>
        </div>

        <p><strong>Hasil Akhir (Top {{ $voting->top_results }}):</strong></p>
        <ul style="background-color: white; padding: 15px; border-radius: 4px;">
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
                @endphp
                <li>
                    <strong>{{ $candidate->name }}</strong>: {{ $candidate->votes_count }} suara ({{ $percentage }}%)
                </li>
            @endforeach
        </ul>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('voting.show', $voting) }}" style="background-color: #3564f5; color: white; padding: 12px 30px; text-decoration: none; border-radius: 4px; display: inline-block;">
                Lihat Detail Hasil
            </a>
        </div>

        <p style="color: #666; font-size: 14px; margin-top: 20px;">
            Terima kasih telah berpartisipasi dalam voting ini!
        </p>
    </div>

    <div style="padding: 20px; background-color: #e5e7eb; text-align: center; color: #666; font-size: 12px;">
        <p>&copy; 2025 E-Voting System. All rights reserved.</p>
    </div>
</div>
