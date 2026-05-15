<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketApiController extends Controller
{
    public function validateTicket(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string']
        ]);

        $ticket = Ticket::where('code', $request->code)
            ->with(['registration.user', 'registration.event'])
            ->first();

        if (!$ticket) {
            return response()->json([
                'valid' => false,
                'message' => 'Ticket tidak ditemukan'
            ], 404);
        }

        if ($ticket->status === 'used') {
            return response()->json([
                'valid' => false,
                'message' => 'Ticket sudah digunakan'
            ], 400);
        }

        $event = $ticket->registration->event;
        $user = $ticket->registration->user;

        return response()->json([
            'valid' => true,
            'ticket' => [
                'code' => $ticket->code,
                'participant' => $user->name,
                'event' => $event->title,
                'date' => $event->date->format('d M Y'),
                'qr_url' => $ticket->qr_code_path
                    ? Storage::url($ticket->qr_code_path)
                    : null
            ]
        ]);
    }

    public function scan(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string']
        ]);

        $ticket = Ticket::where('code', $request->code)
            ->with(['registration.user', 'registration.event'])
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => '❌ Ticket tidak ditemukan'
            ], 404);
        }

        if ($ticket->status === 'used') {
            return response()->json([
                'success' => false,
                'message' => '❌ Ticket sudah digunakan'
            ], 400);
        }

        $ticket->update([
            'status' => 'used',
            'used_at' => now()
        ]);

        $event = $ticket->registration->event;
        $user = $ticket->registration->user;

        return response()->json([
            'success' => true,
            'message' => '✅ Ticket berhasil divalidasi!',
            'ticket' => [
                'code' => $ticket->code,
                'participant' => $user->name,
                'event' => $event->title
            ]
        ]);
    }
}