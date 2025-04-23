<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Farmer AI Chatbot</title>
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
            --primary-color:darkcyan;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 64px;
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Futura LT', sans-serif;

            background-color: #f9fafb;
            color:darkcyan;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color:darkcyan;
            border-right: 1px solid #e5e7eb;
            transition: width var(--transition-speed) ease;
            position: fixed;
            height: 100vh;
            z-index: 50;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            height: var(--header-height);
            padding: 1rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .logo {
    font-size: 2rem; /* Increase font size */
    font-weight: 700; /* Make it bolder */
    color: var(--primary-color);
    text-align: center; /* Center the text */
    display: flex;
    justify-content: center;
    align-items: center;
}


        .nav-items {
            padding: 1rem 0.75rem;
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all var(--transition-speed) ease;
        }

        .nav-link:hover {
            background-color:white;
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color:white;
            color:white;
        }

        .nav-icon {
            width: 1.5rem;
            height: 1.5rem;
            margin-right: 0.75rem;
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: left var(--transition-speed) ease;
            z-index: 40;
        }

        .sidebar.collapsed ~ .header {
            left: var(--sidebar-collapsed-width);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: #4b5563;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
        }

        .toggle-btn:hover {
            background-color: #f3f4f6;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: #4b5563;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            padding: 0.125rem 0.375rem;
            border-radius: 1rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .user-menu:hover {
            background-color: #f3f4f6;
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
    margin-left: var(--sidebar-width);
    margin-top: var(--header-height);
    padding: 2rem;
    transition: margin-left var(--transition-speed) ease;
    width: calc(100% - var(--sidebar-width)); /* Fluid width */
    overflow-x: hidden; /* Prevent horizontal overflow */
}

.sidebar.collapsed ~ .main-content {
    margin-left: var(--sidebar-collapsed-width);
    width: calc(100% - var(--sidebar-collapsed-width)); /* Adjust width when collapsed */
}

/* Responsive Behavior */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0; /* Full width on small screens */
        width: 100%;
    }

    .sidebar.collapsed ~ .main-content {
        margin-left: 0; /* Full width on small screens */
        width: 100%;
    }
}

        .dashboard {
            padding: 2rem;
        }

        .dashboard h1 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .metric-card {
            background-color: var(--card-background);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .metric-icon {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ebe9fe;
            border-radius: 0.5rem;
            color: var(--primary-color);
        }

        .metric-content {
            text-align: right;
        }

        .metric-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .metric-label {
            font-size: 0.875rem;
            color: var(--secondary-color);
        }

        .recent-bookings {
            background-color: var(--card-background);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
        }

        .recent-bookings h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bookings-table th,
        .bookings-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .bookings-table th {
            background-color: #f3f4f6;
            color: var(--secondary-color);
            font-weight: 600;
        }

        .bookings-table tr:hover {
            background-color: #f9fafb;
        }

        .quick-actions {
            margin-top: 2rem;
        }

        .quick-actions h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background-color: var(--card-background);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-icon {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ebe9fe;
            border-radius: 0.5rem;
            color: var(--primary-color);
            margin: 0 auto 1rem;
        }

        .action-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .action-description {
            font-size: 0.875rem;
            color: var(--secondary-color);
        }
        .nav-link.active {
    background-color: #007bff; /* Your highlight color */
    color: white;
    font-weight: bold;
}
.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
}

.notification-wrapper,
.user-menu-wrapper {
    position: relative;
    cursor: pointer;
}

.dropdown-menu {
    display: none;
    position: absolute;
    top: 40px;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    min-width: 180px;
    z-index: 1000;
}

.dropdown-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.dropdown-menu ul li {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.dropdown-menu ul li a {
    text-decoration: none;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dropdown-menu ul li:hover {
    background: #f5f5f5;
}

.dropdown-menu.show {
    display: block;
}

.chat-container {
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .chatbox {
            height: 500px;
            overflow-y: auto;
            padding: 1rem;
            background-color: #FFFFFF;
        }
        .message {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }
        .message-user {
            justify-content: flex-end;
        }
        .message-bot {
            justify-content: flex-start;
        }
        .message-content {
            max-width: 80%;
            padding: 0.75rem;
            border-radius: 8px;
        }
        .message-user .message-content {
            background-color: var(--primary-color);
            color: white;
        }
        .message-bot .message-content {
            background-color: #F1F1F1;
            color: black;
        }
        .user-icon, .bot-icon {
            width: 36px;
            height: 36px;
            margin-right: 10px;
            margin-left: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-icon {
            background-color: var(--primary-color);
            color: white;
        }
        .bot-icon {
            background-color: #10A37F;
            color: white;
        }
        .loading-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .loading-dot {
            width: 8px;
            height: 8px;
            margin: 0 4px;
            background-color: #10A37F;
            border-radius: 50%;
            animation: loading 1.4s infinite ease-in-out both;
        }
        @keyframes loading {
            0%, 80%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }
        .error-message {
            background-color: #FFE5E5;
            color: #D8000C;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .loading-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #48bb78;
            animation: loading-bounce 0.6s infinite alternate;
        }
        @keyframes loading-bounce {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }
        .message-edit {
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .message-edit:hover {
            opacity: 1;
        }
    </style>
</head>
<body  class="bg-gray-900">
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-seedling mr-2"></i> Farmer AI
        </div>
    </div>
    <nav class="nav-items">

        <!-- Chat Access -->
        @can('interact with chatbot') <!-- Chat permission -->
        <div class="nav-item">
            <a href="#" class="nav-link active">
                <i class="fas fa-comment nav-icon"></i>
                <span>Chat</span>
            </a>
        </div>
        @endcan

        <!-- Search Products -->
        @can('search products') <!-- Search products permission -->
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-search nav-icon"></i>
                <span>Search Products</span>
            </a>
        </div>
        @endcan

        <!-- Place Orders (Farmers only) -->
        @can('place orders') <!-- Place orders permission -->
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <span>Place Order</span>
            </a>
        </div>
        @endcan

        <!-- Manage Products (Manufacturers only) -->
        @can('manage product listings') <!-- Manage product listings permission -->
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-boxes nav-icon"></i>
                <span>Manage Products</span>
            </a>
        </div>
        @endcan

        <!-- Receive Orders (Manufacturers only) -->
        @can('receive orders') <!-- Receive orders permission -->
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-truck-loading nav-icon"></i>
                <span>Receive Orders</span>
            </a>
        </div>
        @endcan

        <!-- Manage Users (Admin only) -->
        @can('manage users') <!-- Manage users permission -->
        <div class="nav-item">
            <a href="/users" class="nav-link">
                <i class="fas fa-users-cog nav-icon"></i>
                <span>Manage Users</span>
            </a>
        </div>
        @endcan

        <!-- Logout -->
        <div class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <span class="nav-text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

    </nav>
</aside>




          <!-- Header -->
          <header class="header">
    <div class="header-left">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="header-right">
        <!-- Notification Button -->

        <!-- User Menu -->
        <div class="user-menu-wrapper">
            <div class="user-menu">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <span>{{ Auth::user()->name }}</span>
                <span>({{ Auth::user()->getRoleNames()->implode(', ') }})</span> <!-- User's role(s) -->
            </div>
            <div class="dropdown-menu user-dropdown">
                <ul>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>


        <!-- Main Content -->
        <main class="main-content">
            <div class="chat-container">
            {{ $slot }}
            </div>
        </main>
    </div>



    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let currentPath = window.location.pathname;

        document.querySelectorAll(".nav-link").forEach(link => {
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const userMenu = document.querySelector(".user-menu");
        const notificationMenu = document.createElement("div");
        const userDropdown = document.createElement("div");

        // Create Notification Menu


        // Create User Dropdown Menu
        userDropdown.classList.add("dropdown-menu");
        userDropdown.innerHTML = `
            <ul>
                                <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>            </ul>
        `;
        userMenu.appendChild(userDropdown);


        // Toggle User Menu
        userMenu.addEventListener("click", function (event) {
            event.stopPropagation();
            userDropdown.classList.toggle("show");
            notificationMenu.classList.remove("show"); // Hide notification menu
        });

        // Hide menus when clicking outside
        document.addEventListener("click", function () {
            notificationMenu.classList.remove("show");
            userDropdown.classList.remove("show");
        });
    });
</script>


</body>
</html>
