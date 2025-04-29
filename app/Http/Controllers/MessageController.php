<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'chat_id' => 'nullable|exists:chats,id',
            'user_id' => 'required|exists:users,id',
            'sender_type' => 'required|string',
            'content' => 'required|string|max:10000',
            'metadata' => 'nullable|array',
            'is_read' => 'required|boolean',
        ]);

        $chat = $request->chat_id ? Chat::find($request->chat_id) : Chat::create([
            'user_id' => $request->input('user_id'),
            'title' => 'New Chat',
            'description' => 'A new chat has been created.',
            'is_pinned' => false,
            'token' => Str::uuid(),
        ]);

        Log::info('User message received:', $request->all());

        $userMessage = Message::create([
            'chat_id' => $chat->id,
            'user_id' => $request->input('user_id'),
            'sender_type' => $request->input('sender_type'),
            'content' => $request->input('content'),
            'metadata' => $request->input('metadata', []),
            'is_read' => $request->input('is_read', false),
        ]);

        $aiResponse = $this->generateAgriAIResponse($request->input('content'), $chat);

        Message::create([
            'chat_id' => $chat->id,
            'user_id' => null,
            'sender_type' => 'ai',
            'content' => $aiResponse,
            'metadata' => [],
            'is_read' => true,
        ]);

        $this->processAttachments($request, $userMessage);

        return redirect()->route('chat.show', $chat->token);
    }

    private function generateAgriAIResponse($userQuery, $chat)
    {
        try {
            // Fetch chat history
            $chatHistory = Message::where('chat_id', $chat->id)
                ->orderBy('created_at', 'asc')
                ->take(10)
                ->get()
                ->map(function ($msg) {
                    return [
                        'role' => $msg->sender_type === 'user' ? 'user' : 'assistant',
                        'content' => $msg->content,
                    ];
                })
                ->toArray();

            // Add user's query to the history
            $chatHistory[] = ['role' => 'user', 'content' => $userQuery];

            // Fetch API key from configuration
            $apiKey = config('services.claude.api_key');
            if (!$apiKey) {
                throw new \Exception('Claude API Key is missing.');
            }

            // Send request to Claude API
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-3-5-sonnet-20241022',
                'max_tokens' => 1024,
                'messages' => $chatHistory,
                'system' => 'You are AgriChatbot, an expert agricultural assistant. Help farmers with crops, soil, pests, and sustainability. Be friendly, practical, and specific.',
            ]);

            // Log the raw response for debugging
            Log::info('Claude API response raw:', ['body' => $response->body()]);

            // Check for successful response
            if (!$response->successful()) {
                Log::error('Claude API error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Claude API request failed with status ' . $response->status());
            }

            // Parse and check the response content
            $data = $response->json();
            if (isset($data['content']) && !empty($data['content'][0]['text'])) {
                $content = $data['content'][0]['text'];
            } else {
                Log::error('Claude response missing content', ['response' => $data]);
                throw new \Exception('Claude response missing content.');
            }

            // Process and return the content
            $content = nl2br(e($content));
            return $this->processMarkdownLists($content);

        } catch (\Exception $e) {
            // Log the exception and return a user-friendly error message
            Log::error('Claude AI Error: ' . $e->getMessage());
            return "Sorry, I couldn’t get a response from Claude AI. Try again later.";
        }
    }

    private function processMarkdownLists($text)
    {
        $pattern = '/(?:^|\n)(\* .+)(?:\n|$)/m';
        if (preg_match_all($pattern, $text, $matches)) {
            foreach ($matches[0] as $match) {
                $items = explode("\n* ", $match);
                $html = "<ul>";
                foreach ($items as $i => $item) {
                    if ($i == 0) {
                        $item = str_replace('* ', '', $item);
                    }
                    if (trim($item) !== '') {
                        $html .= "<li>" . trim($item) . "</li>";
                    }
                }
                $html .= "</ul>";
                $text = str_replace($match, $html, $text);
            }
        }

        return $text;
    }

    private function processAttachments(Request $request, Message $message)
    {
        foreach (['images', 'attachments'] as $type) {
            if ($request->hasFile($type)) {
                foreach ($request->file($type) as $file) {
                    $path = $file->store('chat_attachments', 'public');
                    Attachment::create([
                        'message_id' => $message->id,
                        'file_path' => $path,
                        'file_type' => $file->getClientMimeType(),
                        'file_name' => $file->getClientOriginalName(),
                        'description' => ucfirst($type) . ' uploaded by user',
                    ]);
                }
            }
        }
    }
}
