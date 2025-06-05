<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Mail\MeetingProtocolMail;
use App\Models\Meeting;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MeetingProtocolPdfController extends Controller
{
    public function sendProtocol(Meeting $meeting)
    {
        try {
            // Überprüfen, ob Meeting-Daten vollständig sind
            if (!$meeting || !$meeting->id) {
                Log::error('Meeting nicht gefunden oder ID fehlt', ['meeting' => $meeting]);
                return response()->json(['error' => 'Meeting-Daten unvollständig'], 400);
            }

            // Verzeichnis sicherstellen
            Storage::makeDirectory('protocols');

            // PDF erstellen
            $pdf = Pdf::loadView('pdf.meeting-protocol', ['meeting' => $meeting]);

            // PDF speichern
            $pdfPath = "protocols/protokoll_{$meeting->id}.pdf";
            Storage::put($pdfPath, $pdf->output());

            // Prüfen, ob Datei existiert
            if (!Storage::exists($pdfPath)) {
                throw new Exception("PDF-Datei konnte nicht gespeichert werden: {$pdfPath}");
            }

            // Mail mit PDF verschicken
            Mail::to('email@willihelwig.com')
                ->send(new MeetingProtocolMail($meeting, $pdfPath));

            return response()->json(['success' => 'Protokoll wurde erfolgreich verschickt']);
        } catch (Exception $e) {
            Log::error('Fehler beim Versenden des Protokolls', [
                'meeting_id' => $meeting->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Fehler beim Versenden: ' . $e->getMessage()], 500);
        }
    }

}
