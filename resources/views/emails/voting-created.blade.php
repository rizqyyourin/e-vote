<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <div style="background-color: #3564f5; color: white; padding: 20px; text-align: center;">
        <h1 style="margin: 0;">Anda Diundang untuk Voting!</h1>
    </div>

    <div style="padding: 20px; background-color: #f9fafb;">
        <p>Halo,</p>

        <p>Anda diundang untuk mengikuti voting berjudul:</p>

        <div style="background-color: white; border-left: 4px solid #3564f5; padding: 15px; margin: 20px 0;">
            <h2 style="margin-top: 0; color: #1a3ab8;">{{ $voting->title }}</h2>
            @if ($voting->description)
                <p>{{ $voting->description }}</p>
            @endif
        </div>

        <p><strong>Jumlah Kandidat:</strong> {{ $voting->candidates()->count() }}</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $votingUrl }}" style="background-color: #3564f5; color: white; padding: 12px 30px; text-decoration: none; border-radius: 4px; display: inline-block;">
                Berikan Suara Sekarang
            </a>
        </div>

        <p style="color: #666; font-size: 14px;">
            Atau salin link berikut ke browser Anda:<br>
            <code style="background-color: #e5e7eb; padding: 5px 10px; border-radius: 4px;">{{ $votingUrl }}</code>
        </p>

        <p style="color: #666; font-size: 14px; margin-top: 20px;">
            Ingat, setiap pemilih hanya dapat memberikan satu suara.
        </p>
    </div>

    <div style="padding: 20px; background-color: #e5e7eb; text-align: center; color: #666; font-size: 12px;">
        <p>&copy; 2025 E-Voting System. All rights reserved.</p>
    </div>
</div>
