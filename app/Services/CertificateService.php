<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateService
{
    protected $qrService;

    public function __construct(QRCodeService $qrService)
    {
        $this->qrService = $qrService;
    }

    public function generate(Registration $registration): Certificate
    {
        $certificate = Certificate::create([
            'user_id' => $registration->user_id,
            'event_id' => $registration->event_id,
            'registration_id' => $registration->id,
            'certificate_number' => strtoupper(Str::random(10)),
            'issued_at' => now(),
        ]);

        // Generate PDF + QR
        $pdfPath = $this->generatePDF($registration, $certificate);

        $certificate->certificate_path = $pdfPath;
        $certificate->save();

        return $certificate;
    }

    private function generatePDF($registration, $certificate): string
    {
        // Generate QR (base64 biar kebaca di PDF)
        $qr = base64_encode($this->qrService->generate($certificate->certificate_number));

        $pdf = Pdf::loadView('user.certificate.template', [
            'registration' => $registration,
            'certificate' => $certificate,
            'qr' => $qr
        ]);

        $filename = "certificates/{$certificate->certificate_number}.pdf";
        $path = "public/{$filename}";

        Storage::put($path, $pdf->output());

        return $filename;
    }
}