<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Mail\MeetingProtocolMail;
use App\Models\Meeting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MeetingProtocolPdfController extends Controller
{
    public function sendProtocol(Meeting $meeting)
    {
        // PDF erstellen
        $pdf = Pdf::loadView('pdf.meeting-protocol', ['meeting' => $meeting]);

        Storage::put("protocols/protokoll_$meeting->id.pdf", $pdf->output());

        // Mail mit PDF verschicken
        Mail::to('email@willihelwig.com')->send(new MeetingProtocolMail($meeting, "protocols/protokoll_$meeting->id.pdf"));
    }
}
