<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            Mail::raw($validated['message'], function ($message) use ($validated) {
                $message->to('info@dein-crm.de') // Empfänger anpassen
                ->subject('Kontaktformular: ' . $validated['name'])
                    ->replyTo($validated['email']);
            });

            return redirect()->back()->with('success', Lang::get('Vielen Dank für Ihre Nachricht.'));
        } catch (\Exception $e) {
            Log::error('Kontaktformular Fehler: ' . $e->getMessage());
            return redirect()->back()->withErrors([Lang::get('Es gab ein Problem beim Senden Ihrer Nachricht.')]);
        }
    }
}
