<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->app_name ?? 'AgriChatbot - Agricultural Assistant' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


        @font-face {
            font-family: 'Futura LT';
            src: url('/fonts/futura-lt/FuturaLT-Book.ttf') format('woff2'),
                 url('/fonts/futura-lt/FuturaLT.ttf') format('woff'),
                 url('/fonts/futura-lt/FuturaLT-Condensed.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }   
        
        
        :root {
            --primary-color: {{ $settings->primary_color ?? '#2e7d32' }};
            --primary-light: {{ $settings->primary_light ?? '#60ad5e' }};
            --primary-dark: {{ $settings->primary_dark ?? '#005005' }};
            --secondary-color: {{ $settings->secondary_color ?? '#795548' }};
            --accent-color: #f9a825;
            --text-on-primary: {{ $settings->text_on_primary ?? '#ffffff' }};
            --text-primary: {{ $settings->text_primary ?? '#212121' }};
            --background-light: {{ $settings->background_light ?? '#f8f9fa' }};
            --background-dark: {{ $settings->background_dark ?? '#121212' }};
            --text-dark: {{ $settings->text_dark ?? '#e0e0e0' }};
            --card-dark: {{ $settings->card_dark ?? '#1e1e1e' }};
            --sidebar-width: {{ $settings->sidebar_width ?? '280px' }};
            --transition-speed: {{ $settings->transition_speed ?? '0.3s' }};
        }

        body {
            font-family: 'Futura LT', sans-serif;            
            color: var(--text-primary);
            background-color: #f3f4f6;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background-color: var(--background-dark);
            color: var(--text-dark);
        }
        
        body.dark-mode .bg-white {
            background-color: var(--card-dark);
        }
        
        body.dark-mode .border {
            border-color: #333;
        }
        
        body.dark-mode .text-gray-500 {
            color: #aaa;
        }
        
        body.dark-mode .message-ai {
            background-color: #2a2a2a;
            border-left: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        body.dark-mode .message-user {
            background-color: rgba(96, 173, 94, 0.15);
            border-right: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        body.dark-mode .hover\:bg-gray-100:hover {
            background-color: #333;
        }
        
        body.dark-mode .hover\:bg-gray-200:hover {
            background-color: #444;
        }
        
        body.dark-mode textarea,
        body.dark-mode .bg-gray-50 {
            background-color: #2a2a2a;
            color: var(--text-dark);
        }

        .farmer-primary {
            background-color: var(--primary-color);
            color: var(--text-on-primary);
        }

        .farmer-primary-light {
            background-color: var(--primary-light);
            color: var(--text-on-primary);
        }

        .farmer-primary-dark {
            background-color: var(--primary-dark);
            color: var(--text-on-primary);
        }

        .farmer-secondary {
            background-color: var(--secondary-color);
            color: var(--text-on-primary);
        }

        .sidebar-link.active {
            background-color: var(--primary-light);
            color: var(--text-on-primary);
            border-radius: 8px;
        }

        .sidebar-link {
            border-radius: 8px;
            transition: all 0.2s;
        }

        .sidebar-link:hover:not(.active) {
            background-color: rgba(96, 173, 94, 0.1);
            transform: translateX(3px);
        }

        .message-ai {
            background-color: white;
            border-left: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .message-ai::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--primary-color);
        }

        .message-user {
            background-color: rgba(96, 173, 94, 0.08);
            border-right: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }
        
        .message-user::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--primary-color);
        }
        
        #sidebar {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: fixed;
            height: 100vh;
            z-index: 40;
            background: linear-gradient(to bottom, #ffffff, #f9fbf9);
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.05);
        }
        
        body.dark-mode #sidebar {
            background: linear-gradient(to bottom, #1e1e1e, #121212);
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.2);
        }
        
        .sidebar-collapsed #sidebar {
            transform: translateX(-100%);
            box-shadow: none;
        }
        
        .content-area {
            transition: margin-left 0.3s ease;
        }
        
        .sidebar-collapsed .content-area {
            margin-left: 0 !important;
        }
        
        @media (max-width: 1024px) {
            #sidebar {
                transform: translateX(-100%);
            }
            
            .content-area {
                margin-left: 0 !important;
            }
            
            body:not(.sidebar-collapsed) #sidebar {
                transform: translateX(0);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 220px;
            z-index: 50;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
            transform: translateY(8px);
            opacity: 0;
            transition: transform 0.2s, opacity 0.2s;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
            transform: translateY(0);
            opacity: 1;
        }

        .dropdown-content a {
            transition: all 0.2s;
        }

        .dropdown-content a:hover {
            transform: translateX(3px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            transition: all 0.2s ease;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(46, 125, 50, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(46, 125, 50, 0.2);
        }
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(46, 125, 50, 0.1);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn-primary:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            20% {
                transform: scale(25, 25);
                opacity: 0.3;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }
        
        .menu-button {
            transition: transform 0.3s ease;
        }
        
        .menu-button.open {
            transform: rotate(90deg);
        }

        .chat-input-container {
            border-radius: 16px;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .chat-input-container:focus-within {
            box-shadow: 0 4px 16px rgba(46, 125, 50, 0.15);
            transform: translateY(-2px);
        }

        .ai-avatar {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: 0 4px 8px rgba(46, 125, 50, 0.2);
        }

        .user-avatar {
            background: linear-gradient(135deg, #e0e0e0, #c0c0c0);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .app-header {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        body.dark-mode .app-header {
            background-color: rgba(30, 30, 30, 0.95);
        }

        .rounded-btn {
            border-radius: 12px;
            transition: all 0.2s;
        }

        .rounded-btn:hover {
            transform: translateY(-2px);
        }

        .profile-button {
            transition: all 0.2s;
        }

        .profile-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Animation for messages */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Tool buttons hover effects */
        .tool-btn {
            transition: all 0.2s;
        }

        .tool-btn:hover {
            transform: translateY(-2px);
            background-color: rgba(96, 173, 94, 0.1);
        }

        /* Chat container styling */
#chat-messages {
    font-family: 'Futura LT', sans-serif;            
    color: var(--text-color);
    line-height: 1.6;
}

.max-w-4xl {
    max-width: 800px;
}

/* Message styling */
.message {
    margin-bottom: 0 !important;
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem 1rem !important;
    border-radius: 0 !important;
}

.message-user {
    background-color: var(--user-msg-bg);
}

.message-ai {
    background-color: var(--ai-msg-bg);
}

/* Avatar styling */
.ai-avatar, .user-avatar {
    width: 30px !important;
    height: 30px !important;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

.user-avatar {
    background-color: #3b82f6;
}

/* Text styling */
.font-medium {
    font-weight: 500;
    font-size: 0.9rem;
    color: var(--light-text);
    margin-bottom: 0.5rem !important;
}

.leading-relaxed {
    line-height: 1.6;
}

/* Attachments styling */
.grid-cols-1 {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.rounded-xl {
    border-radius: 0.5rem;
    overflow: hidden;
}

.shadow-md {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.hover\:shadow-lg:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.transition {
    transition: all 0.3s ease;
}

/* Code blocks */
code {
    font-family: 'Courier New', Courier, monospace;
    background-color: #f0f0f0;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
    font-size: 0.9em;
}

pre {
    background-color: #f0f0f0;
    padding: 1rem;
    border-radius: 5px;
    overflow-x: auto;
    margin: 1rem 0;
}
    </style>
</head>
<body class="{{ session('theme_mode', '') }}">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 flex-shrink-0 border-r overflow-y-auto">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-5 border-b">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 shadow-md mr-3">
                    <i class="fas fa-seedling text-xl text-white"></i>
                </div>
                <h1 class="text-xl font-semibold" style="color: var(--primary-color);">{{ $settings->app_name ?? 'AgriChatbot' }}</h1>
            </div>
        </div>

        <!-- New Chat Button -->
        <div class="p-5">
            <form action="{{ route('chat.create.new') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 px-4 rounded-xl flex items-center justify-center gap-2 btn-primary font-medium">
                    <i class="fas fa-plus"></i>
                    <span>New Chat</span>
                </button>
            </form>
        </div>

        <div class="space-y-2 px-4">
            @foreach($chats as $chat)
                <a href="{{ route('chat.show', $chat->token) }}" class="block">
                    <div class="px-4 py-3 rounded-xl flex items-center sidebar-link {{ $currentChat && $currentChat->token == $chat->token ? 'active' : '' }}">
                        <i class="fas fa-comments mr-3"></i>
                        <!-- Show the content of the last message in the chat -->
                        <span class="truncate">{{ optional($chat->messages->last())->content }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Sidebar Footer -->
        <div class="border-t mt-6 p-5">
            <div class="space-y-3">
                @foreach($sidebarLinks as $link)
                <a href="{{ $link['url'] }}" class="flex items-center p-3 rounded-xl hover:bg-gray-100 transition duration-200">
                </a>
                @endforeach
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content-area flex-1 flex flex-col" style="margin-left: 18rem; min-height: 100vh;">
        <!-- Top Navbar (Fixed) -->
        <header class="app-header border-b py-3 px-5 fixed top-0 left-0 right-0 z-20" style="margin-left: inherit;">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="p-2 rounded-xl hover:bg-gray-100 mr-3 rounded-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars menu-button"></i>
                    </button>
                    <h2 class="font-medium hidden sm:block">{{ $currentChat->title ?? 'Chat' }}</h2>
                </div>
                
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-xl hover:bg-gray-100 rounded-btn" onclick="toggleTheme()">
                        <i class="fas fa-{{ session('theme_mode') == 'dark-mode' ? 'sun' : 'moon' }}"></i>
                    </button>
                    
                    <!-- Menu Buttons -->
                    <div class="dropdown">
                        <button class="p-2 rounded-xl hover:bg-gray-100 rounded-btn">
                            <i class="fas fa-tools"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-xl shadow-lg py-2 mt-2">
                            @foreach($toolsMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100 first:rounded-t-xl last:rounded-b-xl">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="dropdown">
                        <button class="p-2 rounded-xl hover:bg-gray-100 rounded-btn">
                            <i class="fas fa-info-circle"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-xl shadow-lg py-2 mt-2">
                            @foreach($infoMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100 first:rounded-t-xl last:rounded-b-xl">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="dropdown">
                        <button class="p-2 rounded-xl hover:bg-gray-100 rounded-btn">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-xl shadow-lg py-2 mt-2">
                            @foreach($settingsMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100 first:rounded-t-xl last:rounded-b-xl">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="dropdown">
                        <button class="flex items-center gap-2 p-1 rounded-full hover:bg-gray-100 border px-3 py-2 profile-button">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                                @if($user->profile_image)
                                <img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                <i class="fas fa-user text-white"></i>
                                @endif
                            </div>
                            <span class="hidden md:inline font-medium">{{ $user->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-xl shadow-lg py-2 mt-2">
                            <div class="px-4 py-3 border-b">
                                <div class="font-medium">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->subscription->name ?? 'Free Account' }}</div>
                            </div>
                            @foreach($profileMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 hover:bg-gray-100 text-red-500">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Spacer for fixed header -->
        <div class="h-16"></div>

        <div class="flex-1 overflow-y-auto p-6" id="chat-messages">
<!-- Welcome Message -->
<div class="max-w-4xl mx-auto">
 @if(count($messages) === 0 && isset($welcomeMessage))
<div class="message message-ai p-5 rounded-2xl mb-6">
<div class="flex items-start">
<div class="mr-4 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 ai-avatar">
<i class="fas fa-seedling text-white"></i>
</div>
<div>
<div class="font-medium mb-2">{{ $settings->ai_name ?? 'AgriChatbot' }}</div>
<p class="leading-relaxed">{{ $welcomeMessage->content }}</p>
</div>
</div>
</div>
 @endif
 @foreach($messages as $message)
 @if($message->sender_type == 'user')
<!-- User Message -->
<div class="message message-user p-5 rounded-2xl mb-6">
<div class="flex items-start justify-end">
<div class="text-right">
<div class="font-medium mb-2">You</div>
<p class="leading-relaxed">{{ $message->content }}</p>
</div>
<div class="ml-4 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 user-avatar">
 @if($user->profile_image)
<img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
 @else
<i class="fas fa-user text-white"></i>
 @endif
</div>
</div>
</div>
 @else
<!-- AI Response -->
<div class="message message-ai p-5 rounded-2xl mb-6">
<div class="flex items-start">
<div class="mr-4 w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 ai-avatar">
<i class="fas fa-seedling text-white"></i>
</div>
<div>
<div class="font-medium mb-2">{{ $settings->ai_name ?? 'AgriChatbot' }}</div>
 {!! $message->content !!}
 @if($message->attachments->count() > 0)
<div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
 @foreach($message->attachments as $attachment)
<img src="{{ asset('storage/'.$attachment->file_path) }}" alt="{{ $attachment->description }}" class="rounded-xl shadow-md max-w-full h-auto hover:shadow-lg transition duration-300">
 @endforeach
</div>
 @endif
</div>
</div>
</div>
 @endif
 @endforeach
</div>
</div>


        <!-- Input Area -->
        <div class="p-6 border-t bg-white">
            <div class="max-w-4xl mx-auto">
                <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" id="messageForm">
                    @csrf
                    <input type="hidden" name="chat_id" value="{{ $currentChat->id ?? '' }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="sender_type" value="user">
                    <input type="hidden" name="is_read" value="0"> 
                    <div class="flex items-end gap-3">
                        <div class="flex-1 border rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-green-400 chat-input-container">
                            <textarea name="content" rows="1" placeholder="{{ $settings->input_placeholder ?? 'Ask about crops, soil, pests, weather, or farming techniques...' }}" 
                                class="w-full p-4 focus:outline-none resize-none"
                                style="min-height: 50px; max-height: 200px;" required></textarea>
                            
                            <div class="px-4 py-3 border-t flex justify-between items-center bg-gray-50">
                                <div class="flex space-x-3">
                                    <label class="p-2 rounded-lg transition cursor-pointer tool-btn">
                                        <i class="fas fa-image text-gray-500"></i>
                                        <input type="file" name="images[]" accept="image/*" class="hidden" multiple>
                                    </label>
                                    <label class="p-2 rounded-lg transition cursor-pointer tool-btn">
                                        <i class="fas fa-paperclip text-gray-500"></i>
                                        <input type="file" name="attachments[]" class="hidden" multiple>
                                    </label>
                                    <button type="button" class="p-2 rounded-lg transition tool-btn" id="voiceInputBtn">
                                        <i class="fas fa-microphone text-gray-500"></i>
                                    </button>
                                </div>
                                <div class="text-xs text-gray-500">Shift+Enter for new line</div>
                            </div>
                        </div>
                        
                        <button type="submit" class="p-4 rounded-xl flex-shrink-0 btn-primary h-12 w-12 flex items-center justify-center">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center py-4 text-sm text-gray-500 border-t">
            <p>{{ $settings->app_name ?? 'AgriChatbot' }} © {{ date('Y') }} | 
                @foreach($footerLinks as $link)
                <a href="{{ $link->url }}" class="hover:text-green-600 transition">{{ $link->title }}</a> {{ !$loop->last ? '|' : '' }}
                @endforeach
            </p>
        </footer>
    </main>

    <script>
        // Textarea auto-expand
        document.querySelector('textarea').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Toggle sidebar
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-collapsed');
            
            // Toggle overlay for mobile
            const overlay = document.getElementById('sidebar-overlay');
            if (document.body.classList.contains('sidebar-collapsed')) {
                overlay.classList.add('hidden');
            } else {
                overlay.classList.remove('hidden');
            }
            
            // Toggle menu button animation
            const menuButton = document.querySelector('.menu-button');
            menuButton.classList.toggle('open');
        }
        
        // Toggle theme
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            
            // Update icon
            const themeToggleIcon = document.querySelector('#theme-toggle i');
            if (document.body.classList.contains('dark-mode')) {
                themeToggleIcon.classList.remove('fa-moon');
                themeToggleIcon.classList.add('fa-sun');
                
                // Save theme preference to session
                fetch('{{ route("theme.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ theme: 'dark-mode' })
                });
            } else {
                themeToggleIcon.classList.remove('fa-sun');
                themeToggleIcon.classList.add('fa-moon');
                
                // Save theme preference to session
                fetch('{{ route("theme.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ theme: '' })
                });
            }
        }
        
        // Voice input handling
        document.getElementById('voiceInputBtn').addEventListener('click', function() {
            if ('webkitSpeechRecognition' in window) {
                const recognition = new webkitSpeechRecognition();
                recognition.continuous = false;
                recognition.lang = '{{ $user->language ?? "en-US" }}';
                
                recognition.onstart = function() {
                    document.getElementById('voiceInputBtn').innerHTML = '<i class="fas fa-microphone-alt text-red-500"></i>';
                };
                
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    document.querySelector('textarea[name="content"]').value += transcript;
                    // Trigger input event to adjust height
                    document.querySelector('textarea[name="content"]').dispatchEvent(new Event('input'));
                };
                recognition.onerror = function(event) {
                    console.error('Speech recognition error:', event.error);
                };
                recognition.onend = function() {
                    document.getElementById('voiceInputBtn').innerHTML = '<i class="fas fa-microphone"></i>';
                };
                recognition.start();
            } else {
                alert('Your browser does not support speech recognition.');
            }
        });
    
        // Form submission handling
        document.getElementById('messageForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            const content = formData.get('content').trim();
            
            if (content === '') {
                alert('Please enter a message.');
                return;
            }
            
            // Disable the submit button to prevent multiple submissions
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            // Submit the form
            this.submit();
        });
    </script>
</body>
</html>

