<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        $tenantId = auth()->check() ? auth()->user()->tenant_id : 1;

        $submission = ContactSubmission::create([
            'tenant_id' => $tenantId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => __('messages.contact_form_success')
        ]);
    }

    public function index()
    {
        $messages = ContactSubmission::orderBy('created_at', 'desc')->get();
        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = ContactSubmission::findOrFail($id);

        // Mark as read when viewing
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function markAsRead($id)
    {
        $message = ContactSubmission::findOrFail($id);
        $message->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAsUnread($id)
    {
        $message = ContactSubmission::findOrFail($id);
        $message->update(['is_read' => false]);

        return response()->json(['success' => true]);
    }

    public function getUnreadMessages()
    {
        $unreadMessages = ContactSubmission::unread()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $unreadCount = ContactSubmission::unread()->count();

        return response()->json([
            'messages' => $unreadMessages,
            'unread_count' => $unreadCount
        ]);
    }
}
