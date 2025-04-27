<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriChatbot - Agricultural Assistant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#2e7d32',
                            light: '#60ad5e',
                            dark: '#005005',
                        },
                        secondary: '#795548',
                        accent: '#f9a825',
                    },
                },
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                },
            },
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');


        

@font-face {
  font-family: 'Futura LT';
  src: url('/fonts/futura-lt/FuturaLT-Book.ttf') format('woff2'),
       url('/fonts/futura-lt/FuturaLT.ttf') format('woff'),
       url('/fonts/futura-lt/FuturaLT-Condensed.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
}
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }
        
        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800;
        }
        
        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300 dark:bg-gray-600 rounded;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400 dark:bg-gray-500;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .message {
            animation: fadeIn 0.3s ease-out forwards;
        }

        body {
            font-family: 'Futura LT', sans-serif;

        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-300">
    <!-- Mobile sidebar overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed h-full z-40 w-72 bg-gradient-to-b from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 shadow-md mr-3">
                    <i class="fas fa-seedling text-xl text-white"></i>
                </div>
                <h1 class="text-xl font-semibold text-primary">AgriChatbot</h1>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="p-4 space-y-2">
            <!-- Dashboard -->
            <a href="/dashboard" class="flex items-center gap-3 p-3 rounded-xl bg-primary text-white hover:bg-primary-dark transform hover:translate-x-1 transition-all duration-200">
                <i class="fas fa-tachometer-alt w-6 text-center"></i>
                <span>Dashboard</span>
            </a>

           
            <!-- Products -->
            <a href="/products" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:translate-x-1 transition-all duration-200">
                <i class="fas fa-boxes w-6 text-center"></i>
                <span>Products</span>
            </a>

            <!-- Orders -->
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:translate-x-1 transition-all duration-200">
                <i class="fas fa-truck-loading w-6 text-center"></i>
                <span>Orders</span>
            </a>

            <!-- Users -->
            <a href="/users" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:translate-x-1 transition-all duration-200">
                <i class="fas fa-users-cog w-6 text-center"></i>
                <span>Users</span>
            </a>
            
            <!-- Settings -->
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:translate-x-1 transition-all duration-200">
                <i class="fas fa-cog w-6 text-center"></i>
                <span>Settings</span>
            </a>

            <!-- Logout -->
            <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:translate-x-1 transition-all duration-200 mt-8">
                <i class="fas fa-sign-out-alt w-6 text-center"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="min-h-screen transition-all duration-300 lg:ml-72" id="content-area">
        <!-- Top Navbar -->
        <header class="sticky top-0 bg-white/95 dark:bg-gray-800/95 backdrop-blur-md shadow-sm z-20 py-3 px-5">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                   
                </div>
                
                <div class="flex items-center gap-3">
                    <!-- New Chat Button -->
                  
                    
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-transform duration-200 hover:scale-105" onclick="toggleTheme()">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:block"></i>
                    </button>
                    
                    <!-- User Profile -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 border dark:border-gray-600 px-3 py-2 transition-transform duration-200 hover:scale-105">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gradient-to-r from-primary to-primary-dark">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <span class="hidden md:inline font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-56 rounded-xl shadow-lg py-2 bg-white dark:bg-gray-700 border dark:border-gray-600 invisible opacity-0 transform translate-y-2 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="px-4 py-3 border-b dark:border-gray-600">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                            </div>
                            <a href="/profile" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <i class="fas fa-user-circle mr-2"></i> Profile
                            </a>
                            <a href="/settings" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <i class="fas fa-cog mr-2"></i> Settings
                            </a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Chat Area -->
        <div class="max-w-8xl mx-auto p-4 md:p-6">
            <!-- Messages -->
            <div class="space-y-6 pb-20">
            {{ $slot }}
            </div>
        </div>
    </main>

    <script>
        // Textarea auto-expand
        const textarea = document.querySelector('textarea');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
            
            // Toggle overlay for mobile
            const overlay = document.getElementById('sidebar-overlay');
            overlay.classList.toggle('hidden');
            
            // Adjust content area on desktop
            if (window.innerWidth >= 1024) {
                const contentArea = document.getElementById('content-area');
                contentArea.classList.toggle('lg:ml-0');
                contentArea.classList.toggle('lg:ml-72');
            }
        }
        
        // Toggle theme
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            
            // Save preference to localStorage
            const isDarkMode = document.documentElement.classList.contains('dark');
            localStorage.setItem('darkMode', isDarkMode ? 'true' : 'false');
        }
        
        // Set initial theme based on saved preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
        
        // Voice input functionality
        const voiceInputBtn = document.getElementById('voiceInputBtn');
        if (voiceInputBtn) {
            voiceInputBtn.addEventListener('click', function() {
                if ('webkitSpeechRecognition' in window) {
                    const recognition = new webkitSpeechRecognition();
                    recognition.continuous = false;
                    recognition.lang = 'en-US';
                    
                    recognition.onstart = function() {
                        voiceInputBtn.innerHTML = '<i class="fas fa-microphone-alt text-red-500"></i>';
                    };
                    
                    recognition.onresult = function(event) {
                        const transcript = event.results[0][0].transcript;
                        textarea.value += transcript;
                        textarea.dispatchEvent(new Event('input'));
                    };
                    
                    recognition.onerror = function(event) {
                        console.error('Speech recognition error:', event.error);
                    };
                    
                    recognition.onend = function() {
                        voiceInputBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                    };
                    
                    recognition.start();
                } else {
                    alert('Your browser does not support speech recognition.');
                }
            });
        }
    
        // Form submission
        const messageForm = document.getElementById('messageForm');
        if (messageForm) {
            messageForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                const content = textarea.value.trim();
                
                if (content === '') {
                    alert('Please enter a message.');
                    return;
                }
                
                // Add user message to chat (for demo purposes)
                const messagesContainer = document.querySelector('.space-y-6');
                
                const userMessageHTML = `
                    <div class="message flex gap-4 flex-row-reverse">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex-1">
                            <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-xl shadow-sm border-r-4 border-blue-500 max-w-full ml-auto">
                                <p class="text-gray-800 dark:text-gray-200">
                                    ${content}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
                
                messagesContainer.insertAdjacentHTML('beforeend', userMessageHTML);
                
                // Clear textarea and reset height
                textarea.value = '';
                textarea.style.height = 'auto';
                
                // Scroll to bottom
                window.scrollTo(0, document.body.scrollHeight);
                
                // In a real app, you would send the message to the server here
            });
        }
    </script>
</body>
</html>