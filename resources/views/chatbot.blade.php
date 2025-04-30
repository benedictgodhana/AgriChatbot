<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgroAssist - Your Farming Solution Partner</title>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>



@font-face {
            font-family: 'Futura LT';
            src: url('/fonts/futura-lt/FuturaLT-Book.ttf') format('woff2'),
                 url('/fonts/futura-lt/FuturaLT.ttf') format('woff'),
                 url('/fonts/futura-lt/FuturaLT-Condensed.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Futura LT', sans-serif;
            color: var(--text-primary);
            background-color: #f3f4f6;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .chat-container {
            height: calc(100vh - 240px);
            min-height: 400px;
        }
        .chat-messages {
            height: calc(100% - 70px);
        }
        .typing-indicator span {
            animation: typing 1s infinite;
        }
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        @keyframes typing {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 1; }
        }
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .chat-bubble-user {
            border-radius: 18px 18px 0 18px;
        }
        .chat-bubble-ai {
            border-radius: 18px 18px 18px 0;
        }
        .sidebar-item {
            transition: all 0.2s ease;
        }
        .sidebar-item:hover {
            background-color: rgba(16, 185, 129, 0.1);
        }
        .sidebar-item.active {
            background-color: rgba(16, 185, 129, 0.2);
            border-left: 3px solid #10b981;
        }
        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #10b981;
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 9999px;
        }
        .chat-header {
            backdrop-filter: blur(5px);
        }
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="chatApp" class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm z-10 sticky top-0">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-green-600 h-10 w-10 rounded-lg flex items-center justify-center mr-3 logo-pulse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">AgroAssist</h1>
                            <p class="text-xs text-gray-600">Your Farming Solution Partner</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="#" class="text-gray-700 hover:text-green-600 transition">
                                <span class="text-sm">Support</span>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-green-600 transition">
                                <span class="text-sm">Pricing</span>
                            </a>
                            <a href="#" class="text-gray-700 hover:text-green-600 transition">
                                <span class="text-sm">Documentation</span>
                            </a>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="relative p-2 bg-white border border-gray-300 rounded-lg text-gray-700 flex items-center hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z" />
                                </svg>
                                <span class="ml-1 hidden sm:inline">Cart</span>
                                <span x-show="cartCount > 0" class="absolute -top-1 -right-1 bg-green-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full" x-text="cartCount">0</span>
                            </button>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 bg-white border border-gray-300 rounded-lg text-gray-700 flex items-center hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-1 hidden sm:inline">{{ Auth::user()->name }}</span>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                    <div class="border-t border-gray-100"></div>
                                    <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar - Chat History (visible on larger screens) -->
         <!-- Chat History Sidebar Component -->
<div class="w-64 bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-full"
     x-data="chatHistorySidebar()">

    <!-- Header -->
    <div class="p-4 bg-green-600 text-white flex items-center justify-between">
        <h2 class="font-bold">Chat History</h2>
        <form action="{{ route('chat.create.new') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 px-4 rounded-xl flex items-center justify-center gap-2 btn-primary font-medium">
                    <i class="fas fa-plus"></i>
                    <span>New Chat</span>
                </button>
            </form>
    </div>

    <!-- Search and Filter Section -->
    <div class="p-3 border-b">
        <div class="relative">
            <input type="text"
                   placeholder="Search chats..."
                   class="w-full pl-8 pr-3 py-2 rounded-lg border text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                   x-model="searchQuery"
                   @input="filterChats()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Filter dropdown -->
        <div class="mt-2 relative">
            <button @click="toggleFilterDropdown()"
                    class="text-xs flex items-center justify-between w-full p-2 bg-gray-50 rounded border text-gray-600 hover:bg-gray-100">
                <span x-text="getFilterLabel()">All time</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="isFilterDropdownOpen"
                 @click.away="isFilterDropdownOpen = false"
                 x-cloak
                 class="absolute left-0 right-0 mt-1 bg-white border rounded-lg shadow-lg z-10 py-1">
                <a href="#" @click.prevent="setFilter('all')" class="block px-4 py-2 text-xs hover:bg-gray-100">All time</a>
                <a href="#" @click.prevent="setFilter('today')" class="block px-4 py-2 text-xs hover:bg-gray-100">Today</a>
                <a href="#" @click.prevent="setFilter('week')" class="block px-4 py-2 text-xs hover:bg-gray-100">This week</a>
                <a href="#" @click.prevent="setFilter('month')" class="block px-4 py-2 text-xs hover:bg-gray-100">This month</a>
            </div>
        </div>
    </div>

    <!-- Chat List -->
    <div class="overflow-y-auto flex-grow" x-ref="chatList">
        <!-- Loading State -->
        <div x-show="isLoading" class="flex flex-col items-center justify-center py-8">
            <div class="w-8 h-8 border-4 border-green-200 border-t-green-600 rounded-full animate-spin"></div>
            <p class="mt-2 text-sm text-gray-500">Loading chats...</p>
        </div>


        <!-- Chat Items (Blade Integration) -->
        @foreach($chats as $chat)
            <div @click="selectChat('{{ $chat->token }}')"
                 class="p-3 border-b hover:bg-gray-50 cursor-pointer transition-colors duration-150"
                 :class="{'bg-green-50 border-l-4 border-l-green-600': currentChat === '{{ $chat->token }}'}">
                <div class="flex items-start">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-grow min-w-0">
                        <div class="flex justify-between items-start">
                            <h3 class="font-medium text-sm truncate">{{ $chat->title ?? 'Chat ' . $chat->id }}</h3>
                            <div class="relative group" x-data="{ showActions: false }">
                                <button @click.stop="showActions = !showActions" class="p-1 text-gray-400 hover:text-gray-600 rounded-full opacity-0 group-hover:opacity-100 focus:opacity-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                                <div x-show="showActions"
                                     @click.away="showActions = false"
                                     x-cloak
                                     class="absolute right-0 mt-1 w-40 bg-white rounded-md shadow-lg py-1 z-10">
                                    <a href="#" @click.stop.prevent="renameChat('{{ $chat->token }}')" class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">Rename</a>
                                    <a href="#" @click.stop.prevent="confirmDeleteChat('{{ $chat->token }}')" class="block px-4 py-2 text-xs text-red-600 hover:bg-gray-100">Delete</a>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 truncate mt-1">{{ optional($chat->messages->last())->content }}</p>
                        <div class="flex items-center mt-1 text-xs text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $chat->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteConfirm"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto" @click.away="showDeleteConfirm = false">
            <h3 class="text-lg font-bold mb-2">Delete Chat</h3>
            <p class="text-gray-600 mb-4">Are you sure you want to delete this chat? This action cannot be undone.</p>
            <div class="flex justify-end space-x-2">
                <button @click="showDeleteConfirm = false" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button @click="deleteChat()" class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Rename Modal -->
    <div x-show="showRenameModal"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm mx-auto" @click.away="showRenameModal = false">
            <h3 class="text-lg font-bold mb-2">Rename Chat</h3>
            <input type="text"
                   x-model="newChatName"
                   class="w-full p-2 border rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-green-500"
                   placeholder="Enter a new name">
            <div class="flex justify-end space-x-2">
                <button @click="showRenameModal = false" class="px-4 py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button @click="saveNewChatName()" class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg hover:bg-green-700">
                    Save
                </button>
            </div>
        </div>
    </div>
                    <!-- Sidebar Navigation Links -->
                    <div class="p-4 border-t">
                        <h3 class="text-xs uppercase text-gray-500 mb-2 font-semibold">Navigation</h3>
                        <template x-for="(link, index) in sidebarLinks" :key="index">
                            <a :href="link.url" class="block py-2 px-3 rounded text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 mb-1 transition">
                                <span x-text="link.title"></span>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Chatbot Section -->
                <div class="w-full lg:flex-1 bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                    <div class="p-4 bg-green-600 text-white flex items-center chat-header">
                        <div class="bg-white h-10 w-10 rounded-full flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="font-bold">AgroBot Assistant</h2>
                            <p class="text-xs text-green-100">AI-powered farming expert | Online</p>
                        </div>
                        <div class="flex items-center space-x-2 ml-auto">
                            <button class="p-2 bg-green-700 rounded-full hover:bg-green-800 transition" title="Export chat">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                            <button class="p-2 bg-green-700 rounded-full hover:bg-green-800 transition" title="Manage chats">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                            </button>
                        </div>
                    </div>
<!-- Chat Messages Component -->
<div class="chat-container flex flex-col p-4 flex-grow"
     x-data="chatMessages({{ json_encode($messages) }})">

    <!-- Messages Display -->
    <div class="chat-messages flex-1 overflow-y-auto mb-4 space-y-4"
         id="chat-messages"
         x-ref="messageContainer">

        <!-- Initial Messages from Server (Blade) -->
        @foreach($messages as $message)
            <div class="flex {{ $message->sender_type === 'ai' ? 'justify-start' : 'justify-end' }}">
                <div class="max-w-3/4 p-3 shadow-sm {{ $message->sender_type === 'ai' ? 'bg-gray-100 text-gray-800 chat-bubble-ai' : 'bg-green-600 text-white chat-bubble-user' }}">
                    <div>{!! $message->content !!}</div>

                    <!-- Attachments -->
                    @if($message->attachments && count($message->attachments) > 0)
                        <div class="mt-2">
                            @foreach($message->attachments as $attachment)
                                <div class="flex items-center bg-white p-2 rounded border mt-1 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <a href="/storage/{{ $attachment->file_path }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $attachment->file_name }}</a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Product Recommendations -->
                    @if(isset($message->products) && count($message->products) > 0)
                        <div class="mt-3 bg-white rounded-lg p-3 border">
                            <p class="font-bold mb-2">Recommended Products:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($message->products as $product)
                                    <div class="border rounded-lg overflow-hidden hover:shadow-md transition">
                                        <div class="h-24 bg-gray-100 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <div class="p-3">
                                            <p class="font-medium text-sm">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-600 mb-2">{{ $product->description }}</p>
                                            <div class="flex justify-between items-center">
                                                <p class="text-green-600 font-bold">${{ $product->price }}</p>
                                                <button @click="addToCart({{ json_encode($product) }})" class="px-2 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z" />
                                                    </svg>
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- New Messages (Alpine.js) -->
        <template x-for="message in newMessages" :key="message.id">
            <div :class="`flex ${message.sender_type === 'ai' ? 'justify-start' : 'justify-end'}`">
                <div :class="`max-w-3/4 p-3 shadow-sm ${message.sender_type === 'ai' ? 'bg-gray-100 text-gray-800 chat-bubble-ai' : 'bg-green-600 text-white chat-bubble-user'}`">
                    <div x-html="message.content"></div>

                    <!-- Attachments if any -->
                    <div x-show="message.attachments && message.attachments.length > 0" class="mt-2">
                        <template x-for="attachment in message.attachments" :key="attachment.id">
                            <div class="flex items-center bg-white p-2 rounded border mt-1 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <a :href="`/storage/${attachment.file_path}`" target="_blank" class="text-sm text-blue-600 hover:underline" x-text="attachment.file_name"></a>
                            </div>
                        </template>
                    </div>

                    <!-- Product recommendations list (if included in AI response) -->
                    <div x-show="message.products && message.products.length > 0" class="mt-3 bg-white rounded-lg p-3 border">
                        <p class="font-bold mb-2">Recommended Products:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <template x-for="product in message.products" :key="product.id">
                                <div class="border rounded-lg overflow-hidden hover:shadow-md transition">
                                    <div class="h-24 bg-gray-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div class="p-3">
                                        <p class="font-medium text-sm" x-text="product.name"></p>
                                        <p class="text-xs text-gray-600 mb-2" x-text="product.description"></p>
                                        <div class="flex justify-between items-center">
                                            <p class="text-green-600 font-bold" x-text="`$${product.price}`"></p>
                                            <button @click="addToCart(product)" class="px-2 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z" />
                                                </svg>
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- AI Typing Indicator -->
        <div x-show="isTyping" class="flex justify-start">
            <div class="bg-gray-100 rounded-lg p-3 text-gray-800 chat-bubble-ai">
                <div class="typing-indicator flex space-x-1">
                    <span class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></span>
                    <span class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                </div>
            </div>
        </div>
    </div>
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


                <!-- Add these components right before the closing </div> of your chat-container -->

<!-- Shopping Cart Button -->
<button @click="showCart = true" class="fixed bottom-24 right-6 bg-green-600 text-white p-3 rounded-full shadow-lg hover:bg-green-700 transition">
    <div class="relative">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span x-show="cart.length > 0" x-text="cart.reduce((sum, item) => sum + item.quantity, 0)" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
    </div>
</button>

<!-- Shopping Cart Sidebar -->
<div x-show="showCart" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
    <div x-show="showCart" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50" @click="showCart = false"></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex">
        <div x-show="showCart" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
            <div class="h-full flex flex-col bg-white shadow-xl">
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="flex items-start justify-between">
                        <h2 class="text-lg font-medium text-gray-900">Shopping Cart</h2>
                        <button @click="showCart = false" class="ml-3 h-7 flex items-center justify-center rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <svg class="h-6 w-6 text-gray-400 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-8" x-show="cart.length > 0">
                        <div class="flow-root">
                            <ul class="divide-y divide-gray-200">
                                <template x-for="item in cart" :key="item.id">
                                    <li class="py-6 flex">
                                        <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-md overflow-hidden flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>

                                        <div class="ml-4 flex-1 flex flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                    <h3 x-text="item.name"></h3>
                                                    <p class="ml-4" x-text="`$${(item.price * item.quantity).toFixed(2)}`"></p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500" x-text="item.description"></p>
                                            </div>
                                            <div class="flex-1 flex items-end justify-between text-sm">
                                                <div class="flex items-center">
                                                    <button @click="updateQuantity(item.id, item.quantity - 1)" class="text-gray-500 focus:outline-none px-2">-</button>
                                                    <span class="text-gray-500 mx-2" x-text="item.quantity"></span>
                                                    <button @click="updateQuantity(item.id, item.quantity + 1)" class="text-gray-500 focus:outline-none px-2">+</button>
                                                </div>

                                                <div class="flex">
                                                    <button @click="removeFromCart(item.id)" type="button" class="font-medium text-red-600 hover:text-red-500">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div x-show="cart.length === 0" class="flex flex-col items-center justify-center h-64">
                        <svg class="w-16 h-16 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="mt-4 text-gray-500">Your cart is empty</p>
                        <button @click="showCart = false" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">Continue Shopping</button>
                    </div>
                </div>

                <div class="border-t border-gray-200 p-6" x-show="cart.length > 0">
                    <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                        <p>Subtotal</p>
                        <p x-text="`$${cartTotal.toFixed(2)}`"></p>
                    </div>
                    <div class="flex justify-between">
                        <button @click="clearCart()" class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-red-600 border-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Clear Cart
                        </button>
                        <button @click="checkout()" class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkout-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-md w-full overflow-hidden shadow-xl transform transition-all">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Checkout</h3>

                    <form id="payment-form" class="space-y-4">
    <!-- Shipping Information -->
    <div>
        <h4 class="font-medium text-gray-700 mb-2">Shipping Information</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="firstName" required
                    value="{{ explode(' ', Auth::user()->name)[0] }}"
                    class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="lastName" required
                    value="{{ explode(' ', Auth::user()->name)[1] ?? '' }}"
                    class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>
        <div class="mt-2">
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="address" required class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>
        <div class="grid grid-cols-3 gap-4 mt-2">
            <div>
                <label class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" name="city" required class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">State</label>
                <input type="text" name="state" required class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">ZIP</label>
                <input type="text" name="zip" required class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>
    </div>

    <!-- Mpesa Payment Information -->
    <div>
        <h4 class="font-medium text-gray-700 mb-2">Mpesa Payment</h4>
        <div>
            <label class="block text-sm font-medium text-gray-700">Phone Number (Safaricom)</label>
            <input type="tel" name="phone" required placeholder="07XXXXXXXX"
                class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>
        <p class="text-sm text-gray-500 mt-1">We'll initiate an STK push to this number after you place the order.</p>
    </div>

    <!-- Order Summary -->
    <div class="border-t border-gray-200 pt-4">
        <h4 class="font-medium text-gray-700 mb-2">Order Summary</h4>
        <div class="flex justify-between">
            <span class="text-sm text-gray-500">Subtotal</span>
            <span class="text-sm font-medium" x-text="`$${cartTotal.toFixed(2)}`"></span>
        </div>
        <div class="flex justify-between mt-1">
            <span class="text-sm text-gray-500">Shipping</span>
            <span class="text-sm font-medium">$5.00</span>
        </div>
        <div class="flex justify-between mt-1">
            <span class="text-sm text-gray-500">Tax</span>
            <span class="text-sm font-medium" x-text="`$${(cartTotal * 0.085).toFixed(2)}`"></span>
        </div>
        <div class="flex justify-between mt-2 border-t border-gray-200 pt-2">
            <span class="text-base font-medium">Total</span>
            <span class="text-base font-medium" x-text="`$${(cartTotal + 5 + cartTotal * 0.085).toFixed(2)}`"></span>
        </div>
    </div>
</form>

                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button" id="payment-button" @click="processPayment()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                Complete Purchase
            </button>
            <button type="button" @click="document.getElementById('checkout-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- Payment Success Modal -->
<div id="payment-success" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-md w-full overflow-hidden shadow-xl transform transition-all p-6 text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Payment successful!</h3>
        <div class="mt-2">
            <p class="text-sm text-gray-500">
                Thank you for your purchase. Your order has been processed successfully.
            </p>
        </div>
        <div class="mt-5">
            <button type="button" @click="document.getElementById('payment-success').classList.add('hidden'); showCart = false;" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:text-sm">
                Continue Shopping
            </button>
        </div>
    </div>
</div>
@include('components.product-display', ['products' => $products])
</div>
<script>
   // Main application script for AgroAssist
document.addEventListener('alpine:init', () => {
    // Define the main chat application data
    Alpine.data('chatApp', () => ({
        userInput: '',
        isTyping: false,
        newMessages: [],
        selectedFiles: [],
        sidebarOpen: window.innerWidth >= 1024, // For responsive sidebar
        cartCount: 0, // Initialize cart count

        // Sidebar navigation links
        sidebarLinks: [
            { name: 'Dashboard', icon: 'home', url: '/dashboard' },
            { name: 'My Crops', icon: 'plant', url: '/crops' },
            { name: 'Weather', icon: 'cloud', url: '/weather' },
            { name: 'Marketplace', icon: 'shopping-cart', url: '/marketplace' },
            { name: 'Knowledge Base', icon: 'book-open', url: '/knowledge' },
            { name: 'Settings', icon: 'settings', url: '/settings' }
        ],

        init() {
            this.loadInitialMessages();
            this.loadCartCount();

            this.$nextTick(() => this.scrollToBottom());

            window.addEventListener('chat-message-received', () => {
                this.scrollToBottom();
            });

            window.addEventListener('cart-updated', (event) => {
                this.cartCount++;
                this.showNotification(event.detail.message);
            });

            // Handle responsive sidebar
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    this.sidebarOpen = true;
                } else {
                    this.sidebarOpen = false;
                }
            });
        },

        loadInitialMessages() {
            // You can fetch initial messages from server here if needed
            // For now, we'll start with an empty array
            this.newMessages = [];
        },

        loadCartCount() {
            // You can fetch the cart count from server
            // For now, we'll use 0 as a default
            this.cartCount = 0;

            // Uncomment and modify when you have the endpoint ready
            /*
            fetch('/api/cart/count')
                .then(res => res.json())
                .then(data => {
                    this.cartCount = data.count;
                })
                .catch(console.error);
            */
        },

        sendMessage() {
            if (this.userInput.trim() === '' && this.selectedFiles.length === 0) return;

            const tempMessage = {
                id: Date.now(),
                content: this.userInput,
                sender_type: 'user',
                attachments: this.prepareAttachments(),
                created_at: new Date().toISOString()
            };

            this.newMessages.push(tempMessage);
            this.userInput = '';
            this.selectedFiles = [];

            this.$nextTick(() => this.scrollToBottom());

            this.isTyping = true;

            this.sendToServer(tempMessage)
                .then(response => {
                    this.isTyping = false;

                    const aiResponse = {
                        id: Date.now() + 1,
                        content: response.content,
                        sender_type: 'ai',
                        attachments: response.attachments || [],
                        products: response.products || [],
                        created_at: new Date().toISOString()
                    };

                    this.newMessages.push(aiResponse);
                    window.dispatchEvent(new CustomEvent('chat-message-received'));
                    this.$nextTick(() => this.scrollToBottom());
                })
                .catch(error => {
                    this.isTyping = false;
                    console.error('Send error:', error);
                    this.newMessages.push({
                        id: Date.now() + 1,
                        content: 'Sorry, there was an error sending your message. Please try again later.',
                        sender_type: 'ai',
                        created_at: new Date().toISOString()
                    });
                });
        },

        async sendToServer(message) {
            const formData = new FormData();
            formData.append('content', message.content);

            this.selectedFiles.forEach(file => {
                formData.append('attachments[]', file);
            });

            // Get the CSRF token from meta tags - add fallbacks in case they're missing
            const metaToken = document.querySelector('meta[name="csrf-token"]');

            // Default values or extracted values
            // Use the correct route from your Laravel routes - chatbot.store
            const url = '/chatbot';
            const token = metaToken ? metaToken.content : '';

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData
            });

            if (!response.ok) {
                // For demo purposes, return mock data if the endpoint fails
                // Remove this in production and let it throw the error
                return {
                    content: "I'm sorry, but I couldn't process your request. Our servers might be experiencing issues. Please try again later.",
                    attachments: []
                };
            }

            return await response.json();
        },

        handleFileUpload(event) {
            this.selectedFiles = Array.from(event.target.files);
        },

        removeFile(index) {
            this.selectedFiles.splice(index, 1);
        },

        prepareAttachments() {
            return this.selectedFiles.map(file => ({
                file_name: file.name,
                file_size: file.size,
                file_type: file.type
            }));
        },

        toggleVoiceInput() {
            alert('Voice input feature coming soon!');
        },

        addToCart(product) {
            const metaToken = document.querySelector('meta[name="csrf-token"]');
            const token = metaToken ? metaToken.content : '';

            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ product_id: product.id, quantity: 1 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.dispatchEvent(new CustomEvent('cart-updated', {
                        detail: { message: `${product.name} added to cart!` }
                    }));
                }
            })
            .catch(console.error);
        },

        scrollToBottom() {
            const container = this.$refs.messageContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },

        showNotification(message) {
            // You can implement a toast notification system here
            console.log('Notification:', message);
            // Example implementation with a simple alert
            // alert(message);
        }
    }));
});
</script>
 </div>
        </main>
        <footer class="bg-white shadow-sm py-4">
            <div class="container mx-auto text-center text-gray-600">
                <p class="text-sm">&
                    &copy; 2023 AgroAssist. All rights reserved.
                </p>
                <p class="text-xs">Powered by AI and your farming expertise.</p>
            </div>
        </footer>
    </div>




<script>
    function chatHistorySidebar() {
    return {
        chats: [],
        filteredChats: [],
        currentChat: null,
        isLoading: true,
        searchQuery: '',
        filterType: 'all',
        isFilterDropdownOpen: false,
        showDeleteConfirm: false,
        showRenameModal: false,
        newChatName: '',
        chatToDelete: null,
        chatToRename: null,

        init() {
            // Set current chat from URL if available
            const pathSegments = window.location.pathname.split('/');
            if (pathSegments.length > 2 && pathSegments[1] === 'chat') {
                this.currentChat = pathSegments[2];
            }

            // Load chats - in real implementation, this would be replaced by
            // a fetch or axios call to your backend
            this.loadChats();
        },

        loadChats() {
            // This function would normally fetch chats from your backend
            // For now we're relying on the Blade template to render them
            this.isLoading = false;
        },

        filterChats() {
            // Filtering is handled server-side in our implementation
            // This is just a placeholder for client-side filtering if needed
            // You could send an AJAX request to filter chats based on searchQuery and filterType
        },

        toggleFilterDropdown() {
            this.isFilterDropdownOpen = !this.isFilterDropdownOpen;
        },

        getFilterLabel() {
            const labels = {
                'all': 'All time',
                'today': 'Today',
                'week': 'This week',
                'month': 'This month'
            };
            return labels[this.filterType] || 'All time';
        },

        setFilter(type) {
            this.filterType = type;
            this.isFilterDropdownOpen = false;
            this.filterChats();
        },

        selectChat(token) {
            // Navigate to the selected chat
            window.location.href = `/chat/${token}`;
        },

        createNewChat() {
            // Send request to create a new chat
            fetch('/chats', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.chat) {
                    // Navigate to the new chat
                    window.location.href = `/chat/${data.chat.token}`;
                }
            })
            .catch(error => {
                console.error('Error creating new chat:', error);
            });
        },

        confirmDeleteChat(token) {
            this.chatToDelete = token;
            this.showDeleteConfirm = true;
        },

        deleteChat() {
            if (!this.chatToDelete) return;

            fetch(`/chats/${this.chatToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload page or redirect to /chats if current chat was deleted
                    if (this.currentChat === this.chatToDelete) {
                        window.location.href = '/chats';
                    } else {
                        // Reload the page to refresh the chat list
                        window.location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Error deleting chat:', error);
            })
            .finally(() => {
                this.showDeleteConfirm = false;
                this.chatToDelete = null;
            });
        },

        renameChat(token) {
            // Find the chat to get its current name
            const chatElement = document.querySelector(`[data-chat-token="${token}"]`);
            if (chatElement) {
                const titleElement = chatElement.querySelector('.chat-title');
                if (titleElement) {
                    this.newChatName = titleElement.textContent.trim();
                }
            }

            this.chatToRename = token;
            this.showRenameModal = true;
        },

        saveNewChatName() {
            if (!this.chatToRename || !this.newChatName.trim()) return;

            fetch(`/chats/${this.chatToRename}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title: this.newChatName.trim()
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to update the chat title
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error renaming chat:', error);
            })
            .finally(() => {
                this.showRenameModal = false;
                this.chatToRename = null;
                this.newChatName = '';
            });
        }
    };
}
</script>


<script>
    // Define the chatMessages function that Alpine.js is looking for
   // Alpine.js Shopping Cart Component
function chatMessages(initialMessages) {
    return {
        newMessages: [],
        isTyping: false,
        cart: [],
        showCart: false,
        cartTotal: 0,

        // Initialize messages and cart from local storage if available
        init() {
            // Initialize existing messages
            this.scrollToBottom();

            // Load cart from localStorage if it exists
            const savedCart = localStorage.getItem('shoppingCart');
            if (savedCart) {
                this.cart = JSON.parse(savedCart);
                this.updateCartTotal();
            }

            // Listen for cart button clicks
            this.$watch('showCart', (value) => {
                if (value) {
                    document.body.classList.add('overflow-hidden');
                } else {
                    document.body.classList.remove('overflow-hidden');
                }
            });
        },

        // Scroll to the bottom of the chat container
        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messageContainer;
                container.scrollTop = container.scrollHeight;
            });
        },

        // Add a product to the cart
        addToCart(product) {
            // Check if the product is already in the cart
            const existingProduct = this.cart.find(item => item.id === product.id);

            if (existingProduct) {
                // If already in cart, increment quantity
                existingProduct.quantity += 1;
            } else {
                // Otherwise add it with quantity 1
                this.cart.push({
                    ...product,
                    quantity: 1
                });
            }

            // Update cart total
            this.updateCartTotal();

            // Save cart to localStorage
            localStorage.setItem('shoppingCart', JSON.stringify(this.cart));

            // Show cart after adding item
            this.showCart = true;

            // Show a brief notification
            this.showNotification(`${product.name} added to cart!`);
        },

        // Remove a product from the cart
        removeFromCart(productId) {
            this.cart = this.cart.filter(item => item.id !== productId);
            this.updateCartTotal();
            localStorage.setItem('shoppingCart', JSON.stringify(this.cart));
        },

        // Update the quantity of a product in the cart
        updateQuantity(productId, newQuantity) {
            const product = this.cart.find(item => item.id === productId);
            if (product) {
                product.quantity = parseInt(newQuantity);
                if (product.quantity <= 0) {
                    this.removeFromCart(productId);
                } else {
                    this.updateCartTotal();
                    localStorage.setItem('shoppingCart', JSON.stringify(this.cart));
                }
            }
        },

        // Calculate the total price of items in the cart
        updateCartTotal() {
            this.cartTotal = this.cart.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        },

        // Clear the entire cart
        clearCart() {
            this.cart = [];
            this.updateCartTotal();
            localStorage.removeItem('shoppingCart');
        },

        // Proceed to checkout
        checkout() {
            // Start the checkout process
            if (this.cart.length === 0) {
                alert('Your cart is empty');
                return;
            }

            // Show the checkout form
            document.getElementById('checkout-modal').classList.remove('hidden');
        },

        // Process payment
        processPayment() {
            const form = document.getElementById('payment-form');
            const formData = new FormData(form);

            // Simple validation
            let isValid = true;
            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value) {
                    input.classList.add('border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                alert('Please fill in all required fields');
                return;
            }

            // Show loading state
            document.getElementById('payment-button').disabled = true;
            document.getElementById('payment-button').innerText = 'Processing...';

            // Here you would normally send data to your payment processor
            // For demo purposes, we'll simulate a successful payment after a delay
            setTimeout(() => {
                // Hide checkout form
                document.getElementById('checkout-modal').classList.add('hidden');

                // Show success message
                document.getElementById('payment-success').classList.remove('hidden');

                // Clear the cart
                this.clearCart();

                // Reset payment button
                document.getElementById('payment-button').disabled = false;
                document.getElementById('payment-button').innerText = 'Complete Purchase';

                // Hide success message after 5 seconds
                setTimeout(() => {
                    document.getElementById('payment-success').classList.add('hidden');
                    this.showCart = false;
                }, 5000);
            }, 2000);
        },

        // Show a temporary notification
        showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-0';
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('translate-y-20');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 2000);
        }
    };
}
</script>
</body>
</html>
