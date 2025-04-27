<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;  // Import the Str facade to generate UUID
use OpenAI;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'chat_id' => 'nullable|exists:chats,id',
            'user_id' => 'required|exists:users,id',
            'sender_type' => 'required|string',
            'content' => 'required|string|max:10000', // Increased max size to allow for longer messages
            'metadata' => 'nullable|array',
            'is_read' => 'required|boolean',
        ]);
    
        // Check if the chat exists (if chat_id is passed, find the chat)
        $chat = $request->chat_id ? Chat::find($request->chat_id) : null;
    
        // If no chat exists, create a new chat
        if (!$chat) {
            // Create a new chat if no chat_id is provided
            $chat = Chat::create([
                'user_id' => $request->input('user_id'),
                'title' => 'New Chat', // Default title, you can customize this
                'description' => 'A new chat has been created.',
                'is_pinned' => 0, // Default value for pinned chat
                'token' => Str::uuid(), // Generate a unique token
            ]);
        }
    
        // Log incoming request for debugging
        Log::info($request->all());
    
        // Store the user message
        $userMessage = Message::create([
            'chat_id' => $chat->id,
            'user_id' => $request->input('user_id'),
            'sender_type' => $request->input('sender_type'),
            'content' => $request->input('content'),
            'metadata' => $request->input('metadata', []),
            'is_read' => $request->input('is_read', false),
        ]);
    
        // Generate AI response - call your AI service here
        $aiResponse = $this->generateAgriAIResponse($request->input('content'), $chat);
        
        // Store the AI response
        $aiMessage = Message::create([
            'chat_id' => $chat->id,
            'user_id' => null, // AI doesn't have a user ID
            'sender_type' => 'ai',
            'content' => $aiResponse,
            'metadata' => [],
            'is_read' => true, // AI messages are considered read immediately
        ]);
    
        // Process any uploaded images or attachments if necessary
        if ($request->hasFile('images') || $request->hasFile('attachments')) {
            $this->processAttachments($request, $userMessage);
        }
    
        // Redirect back to the chat page with the chat token
        return redirect()->route('chat.show', $chat->token);
    }
    
    /**
     * Generate AI response for agricultural queries
     *
     * @param string $userQuery The user's question or message
     * @param Chat $chat The current chat object for context
     * @return string The AI-generated response
     */
    private function generateAgriAIResponse($userQuery, $chat)
    {
        try {
            // Get previous messages for context if needed
            $chatHistory = Message::where('chat_id', $chat->id)
                                ->orderBy('created_at', 'asc')
                                ->take(10) // Limit to recent messages
                                ->get()
                                ->map(function($msg) {
                                    return [
                                        'role' => $msg->sender_type == 'user' ? 'user' : 'assistant',
                                        'content' => $msg->content
                                    ];
                                })
                                ->toArray();
    
            // Pass the OpenAI API key directly from .env
            $apiKey = env('OPENAI_API_KEY'); // Make sure this is in your .env file
    
            if (empty($apiKey)) {
                throw new \Exception('OpenAI API key is missing in the .env file.');
            }
    
            // Connect to your preferred AI API (OpenAI example)
            $client = OpenAI::client($apiKey);
    
            $completion = $client->chat()->create([
                'model' => 'gpt-4', // Or your preferred model
                'messages' => array_merge([
                    ['role' => 'system', 'content' => 'You are AgriChatbot, an expert agricultural assistant. You help farmers and gardeners with detailed, accurate advice about crops, soil, pests, farming techniques, and sustainable agricultural practices. Keep your responses friendly, practical, and scientific. Include specific action items when appropriate.'],
                ], $chatHistory, [
                    ['role' => 'user', 'content' => $userQuery]
                ]),
                'temperature' => 0.7,
            ]);
    
            // Extract and format the response
            $aiResponse = $completion->choices[0]->message->content;
    
            // Process the response for proper HTML display
            $aiResponse = nl2br(htmlspecialchars($aiResponse));
    
            // Convert markdown-style lists to HTML lists
            $aiResponse = $this->processMarkdownLists($aiResponse);
    
            return $aiResponse;
    
        } catch (\Exception $e) {
            Log::error('AI Response Generation Error: ' . $e->getMessage());
            return "I apologize, but I'm having trouble generating a response at the moment. Please try again later.";
        }
    }
    
    
    /**
     * Convert markdown-style lists to HTML lists
     *
     * @param string $text The text to process
     * @return string The processed text
     */
    private function processMarkdownLists($text)
    {
        // Convert bullet points (* Item) to HTML list
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
    
    /**
     * Process file attachments for messages
     *
     * @param Request $request The request with files
     * @param Message $message The message to attach files to
     * @return void
     */
    private function processAttachments(Request $request, Message $message)
    {
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('chat_attachments', 'public');
                
                Attachment::create([
                    'message_id' => $message->id,
                    'file_path' => $path,
                    'file_type' => $image->getClientMimeType(),
                    'file_name' => $image->getClientOriginalName(),
                    'description' => 'Image uploaded by user',
                ]);
            }
        }
        
        // Handle other file attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('chat_attachments', 'public');
                
                Attachment::create([
                    'message_id' => $message->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_name' => $file->getClientOriginalName(),
                    'description' => 'File uploaded by user',
                ]);
            }
        }
    }
}
