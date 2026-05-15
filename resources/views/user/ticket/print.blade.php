<!DOCTYPE html>
<html>
<head>
    <title>Tiket - {{ $ticket->ticket_code }}</title>
    <style>
        @page { margin: 1in; }
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 40px; }
        .ticket { border: 3px solid #007bff; border-radius: 15px; padding: 30px; background: white; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .qr-code { text-align: center; margin: 30px 0; }
        .qr-code img { max-width: 250px; border: 2px solid #007bff; border-radius: 10px; }
        .ticket-code { font-family: 'Courier New', monospace; font-size: 24px; font-weight: bold; letter-spacing: 4px; color: #007bff; }
        .info { margin: 20px 0; }
        .info div { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .label { font-weight: bold; color: #666; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 2px dashed #ddd; text-align: center; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h2>{{ $event->title }}</h2>
            <p style="font-size: 14px; color: #666;">{{ $event->venue }}</p>
        </div>
        
        <div class="qr-code">
            @if($ticket->qr_code_path)
                <img src="{{ public_path('storage/' . $ticket->qr_code_path) }}" alt="QR Code">
            @else
                <div style="width: 250px; height: 250px; background: #f8f9fa; border: 2px dashed #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #999;">
                    QR Code<br>Belum Tersedia
                </div>
            @endif
        </div>
        
        <div style="text-align: center; margin: 20px 0;">
            <div class="ticket-code">{{ $ticket->ticket_code }}</div>
            <p style="font-size: 16px; margin: 10px 0;">{{ $registration->full_name }}</p>
        </div>
        
        <div class="info">
            <div><span class="label">Tanggal:</span> <span>{{ $event->date->format('d F Y') }}</span></div>
            <div><span class="label">Waktu:</span> <span>{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</span></div>
            <div><span class="label">Lokasi:</span> <span>{{ $event->venue }}</span></div>
            <div><span class="label">Email:</span> <span>{{ $registration->email }}</span></div>
            <div><span class="label">Telepon:</span> <span>{{ $registration->phone }}</span></div>
        </div>
        
        <div class="footer">
            <p>Tiket Digital EventHub Kampus - Jangan Bagikan QR Code</p>
            <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>