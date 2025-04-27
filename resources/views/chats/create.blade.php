<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->app_name ?? 'FarmerAI - Agricultural Assistant' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
            background-color: var(--background-light);
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
            border-left: 4px solid var(--primary-color);
        }
        
        body.dark-mode .message-user {
            background-color: rgba(96, 173, 94, 0.15);
            border-right: 4px solid var(--primary-color);
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
        }

        .sidebar-link:hover:not(.active) {
            background-color: rgba(96, 173, 94, 0.2);
        }

        .message-ai {
            background-color: #f1f5f9;
            border-left: 4px solid var(--primary-color);
        }

        .message-user {
            background-color: rgba(96, 173, 94, 0.1);
            border-right: 4px solid var(--primary-color);
        }
        
        #sidebar {
            transition: transform 0.3s ease;
            position: fixed;
            height: 100vh;
            z-index: 40;
        }
        
        .sidebar-collapsed #sidebar {
            transform: translateX(-100%);
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
            min-width: 200px;
            z-index: 50;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            transition: background-color 0.2s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .menu-button {
            transition: transform 0.3s ease;
        }
        
        .menu-button.open {
            transform: rotate(90deg);
        }
    </style>
</head>
<body class="{{ session('theme_mode', '') }}">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 flex-shrink-0 bg-white border-r shadow-lg overflow-y-auto">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center">
                <i class="fas fa-seedling text-2xl mr-2" style="color: var(--primary-color);"></i>
                <h1 class="text-xl font-bold" style="color: var(--primary-color);">{{ $settings->app_name ?? 'AgriChatbot' }}</h1>
            </div>
        </div>

        <!-- New Chat Button -->
        <div class="p-4">
            <button class="w-full py-2 px-4 rounded flex items-center justify-center gap-2 btn-primary" onclick="window.location.href='{{ route('chats.create') }}'">
                <i class="fas fa-plus"></i>
                <span>New Chat</span>
            </button>
        </div>

      <!-- Chat History -->
<div class="overflow-y-auto">
    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">Chat History</div>
    
    <div class="space-y-1 px-2">
        @foreach($chats as $chat)
        <a href="{{ route('chat.show', $chat->id) }}" class="block">
            <div class="px-3 py-2 rounded-lg flex items-center sidebar-link {{ $currentChat && $currentChat->id == $chat->id ? 'active' : '' }}">
                <i class="fas fa-comments mr-3"></i>
                <span class="truncate">{{ $chat->title }}</span>
            </div>
        </a>
        @endforeach
    </div>
</div>


        <!-- Sidebar Footer -->
        <div class="border-t mt-4 p-4">
            <div class="space-y-2">
                @foreach($sidebarLinks as $link)
                <a href="{{ $link['url'] }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                </a>
                @endforeach
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content-area flex-1 flex flex-col" style="margin-left: 16rem; min-height: 100vh;">
        <!-- Top Navbar (Fixed) -->
        <header class="border-b bg-white shadow-sm py-2 px-4 fixed top-0 left-0 right-0 z-20" style="margin-left: inherit;">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 mr-2" onclick="toggleSidebar()">
                        <i class="fas fa-bars menu-button"></i>
                    </button>
                    <h2 class="font-medium hidden sm:block">{{ $currentChat->title ?? 'Chat' }}</h2>
                </div>
                
                <div class="flex items-center gap-1 sm:gap-3">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded hover:bg-gray-100" onclick="toggleTheme()">
                        <i class="fas fa-{{ session('theme_mode') == 'dark-mode' ? 'sun' : 'moon' }}"></i>
                    </button>
                    
                    <!-- Menu Buttons -->
                    <div class="dropdown">
                        <button class="p-2 rounded hover:bg-gray-100">
                            <i class="fas fa-tools"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-lg shadow-lg py-1 mt-1">
                            @foreach($toolsMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="dropdown">
                        <button class="p-2 rounded hover:bg-gray-100">
                            <i class="fas fa-info-circle"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-lg shadow-lg py-1 mt-1">
                            @foreach($infoMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="dropdown">
                        <button class="p-2 rounded hover:bg-gray-100">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-lg shadow-lg py-1 mt-1">
                            @foreach($settingsMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="dropdown">
                        <button class="flex items-center gap-2 p-1 rounded-full hover:bg-gray-100 border px-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: var(--primary-color);">
                                @if($user->profile_image)
                                <img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                <i class="fas fa-user text-white"></i>
                                @endif
                            </div>
                            <span class="hidden md:inline font-medium">{{ $user->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="dropdown-content bg-white border rounded-lg shadow-lg py-1 mt-1">
                            <div class="px-4 py-2 border-b">
                                <div class="font-medium">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->subscription->name ?? 'Free Account' }}</div>
                            </div>
                            @foreach($profileMenuItems as $item)
                            <a href="{{ $item->url }}" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-{{ $item->icon }} mr-2"></i> {{ $item->title }}
                            </a>
                            @endforeach
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 hover:bg-gray-100">
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
        <div class="h-14"></div>

        <!-- Chat Area -->
        <div class="flex-1 overflow-y-auto p-4" id="chat-messages">
            <!-- Welcome Message -->
            <div class="max-w-8xl mx-auto">
            @if(count($messages) === 0 && isset($welcomeMessage))
                <div class="message message-ai p-4 rounded-lg mb-4">
                    <div class="flex items-start">
                        <div class="mr-4 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: var(--primary-color);">
                            <i class="fas fa-seedling text-white"></i>
                        </div>
                        <div>
                            <div class="font-medium mb-1">{{ $settings->ai_name ?? 'FarmerAI' }}</div>
                            <p>{{ $welcomeMessage->content }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @foreach($messages as $message)
                @if($message->sender_type == 'user')
                <!-- User Message -->
                <div class="message message-user p-4 rounded-lg mb-4">
                    <div class="flex items-start justify-end">
                        <div class="text-right">
                            <div class="font-medium mb-1">You</div>
                            <p>{{ $message->content }}</p>
                        </div>
                        <div class="ml-4 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0">
                            @if($user->profile_image)
                            <img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                            <i class="fas fa-user text-white"></i>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <!-- AI Response -->
                <div class="message message-ai p-4 rounded-lg mb-4">
                    <div class="flex items-start">
                        <div class="mr-4 w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: var(--primary-color);">
                            <i class="fas fa-seedling text-white"></i>
                        </div>
                        <div>
                            <div class="font-medium mb-1">{{ $settings->ai_name ?? 'FarmerAI' }}</div>
                            {!! $message->content !!}
                            
                            @if($message->attachments->count() > 0)
                                @foreach($message->attachments as $attachment)
                                <img src="{{ asset('storage/'.$attachment->file_path) }}" alt="{{ $attachment->description }}" class="my-3 rounded-lg max-w-full h-auto">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t bg-white">
            <div class="max-w-6xl mx-auto">
                <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" id="messageForm">
                    @csrf
                    <input type="hidden" name="chat_id" value="{{ $currentChat->id ?? '' }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}"> <!-- Make sure this is set -->
    <input type="hidden" name="sender_type" value="user"> <!-- Assuming sender_type is 'user' for the current logged-in user -->
    <input type="hidden" name="is_read" value="0"> <!-- Set the value to 0 for false -->
                    <div class="flex items-end gap-2">
                        <div class="flex-1 border rounded-lg overflow-hidden focus-within:ring-2" style="focus-within:ring-color: var(--primary-color);">
                            <textarea name="content" rows="1" placeholder="{{ $settings->input_placeholder ?? 'Ask about crops, soil, pests, weather, or farming techniques...' }}" 
                                class="w-full p-3 focus:outline-none resize-none"
                                style="min-height: 44px; max-height: 200px;" required></textarea>
                            
                            <div class="px-3 py-2 border-t flex justify-between items-center bg-gray-50">
                                <div class="flex space-x-2">
                                    <label class="p-1 rounded hover:bg-gray-200 transition cursor-pointer">
                                        <i class="fas fa-image text-gray-500"></i>
                                        <input type="file" name="images[]" accept="image/*" class="hidden" multiple>
                                    </label>
                                    <label class="p-1 rounded hover:bg-gray-200 transition cursor-pointer">
                                        <i class="fas fa-paperclip text-gray-500"></i>
                                        <input type="file" name="attachments[]" class="hidden" multiple>
                                    </label>
                                    <button type="button" class="p-1 rounded hover:bg-gray-200 transition" id="voiceInputBtn">
                                        <i class="fas fa-microphone text-gray-500"></i>
                                    </button>
                                </div>
                                <div class="text-xs text-gray-500">Shift+Enter for new line</div>
                            </div>
                        </div>
                        
                        <button type="submit" class="p-3 rounded-full flex-shrink-0 btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center py-2 text-xs text-gray-500 border-t">
            <p>{{ $settings->app_name ?? 'FarmerAI' }} © {{ date('Y') }} | 
                @foreach($footerLinks as $link)
                <a href="{{ $link->url }}" class="underline">{{ $link->title }}</a> {{ !$loop->last ? '|' : '' }}
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
                
                recognition.onend = function() {
                    document.getElementById('voiceInputBtn').innerHTML = '<i class="fas fa-microphone text-gray-500"></i>';
                };
                
                recognition.start();
            } else {
                alert('Voice input is not supported in your browser.');
            }
        });
        
        // Scroll to bottom of chat on page load
        window.onload = function() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        };
        
        // Form submission with AJAX
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Disable submit button
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear the form
                    document.querySelector('textarea[name="content"]').value = '';
                    document.querySelector('textarea[name="content"]').style.height = 'auto';
                    
                    // Reload chat messages
                    window.location.reload();
                } else {
                    alert(data.message || 'There was an error sending your message.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error sending your message.');
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            });
        });
        
        // Adjust sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.body.classList.remove('sidebar-collapsed');
                document.getElementById('sidebar-overlay').classList.add('hidden');
            }
        });
    </script>
</body>
</html>