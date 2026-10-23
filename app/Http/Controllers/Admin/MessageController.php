<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'inbox'); // 'inbox', 'archived', 'all'

        $query = Message::orderByDesc('created_at');

        if ($status === 'inbox') {
            $query->where('is_archived', false);
        } elseif ($status === 'archived') {
            $query->where('is_archived', true);
        }

        $messages = $query->paginate(15)->withQueryString();
        $unreadCount = Message::where('is_read', false)->where('is_archived', false)->count();

        return view('admin.messages.index', compact('messages', 'status', 'unreadCount'));
    }

    public function show(Message $message): View
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function toggleArchive(Message $message): RedirectResponse
    {
        $message->update(['is_archived' => !$message->is_archived]);
        $statusText = $message->is_archived ? 'diarsipkan' : 'dipindahkan ke kotak masuk';
        return back()->with('success', "Pesan berhasil {$statusText}.");
    }

    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan telah dihapus.');
    }
}

