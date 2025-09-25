<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string'
        ]);

        $message = ChatMessage::create([
            'message' => $request->message,
            'session_id' => $request->session_id,
            'sender_type' => 'user',
            'sender_name' => $request->input('sender_name', 'Guest'),
            'sender_email' => $request->input('sender_email'),
        ]);

        // Auto-response simulation (replace with real chat bot logic)
        $responses = [
            "Thank you for your message! Our team will get back to you shortly.",
            "Hello! How can we help you with your project today?",
            "We're here to help! What type of website are you looking to build?",
            "Thanks for reaching out! We'll connect you with one of our specialists.",
            "Great to hear from you! Let's discuss your web development needs."
        ];

        // Create auto-response after 1-2 seconds delay
        ChatMessage::create([
            'message' => $responses[array_rand($responses)],
            'session_id' => $request->session_id,
            'sender_type' => 'support',
            'sender_name' => 'EMPHXS Support',
            'created_at' => now()->addSeconds(rand(1, 3)),
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string'
        ]);

        $messages = ChatMessage::where('session_id', $request->session_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function createSession(Request $request)
    {
        $sessionId = 'chat_' . uniqid() . '_' . time();

        // Create welcome message
        ChatMessage::create([
            'message' => "Hello! 👋 Welcome to EMPHXS support. How can we help you today?",
            'session_id' => $sessionId,
            'sender_type' => 'support',
            'sender_name' => 'EMPHXS Support',
        ]);

        return response()->json([
            'session_id' => $sessionId
        ]);
    }
}