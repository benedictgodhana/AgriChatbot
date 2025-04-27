<x-app-layout>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success bg-green-500 text-white p-4 rounded-md mb-4 shadow-md transition-all" id="successMessage">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>

                <script>
                    setTimeout(function() {
                        let successMessage = document.getElementById('successMessage');
                        if (successMessage) {
                            successMessage.style.transition = "opacity 0.5s";
                            successMessage.style.opacity = "0";
                            setTimeout(() => successMessage.remove(), 500); // Remove after fade-out
                        }
                    }, 4000);
                </script>
            @endif
            
            <!-- Main Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings Management
                        </h1>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-md flex items-center" onclick="toggleModal('addModal')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Setting
                        </button>
                    </div>

                    <!-- Filter Section -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6 shadow-sm">
                        <form method="GET" action="{{ route('settings.index') }}" class="md:flex md:items-center md:gap-4">
                            <div class="flex-1 mb-2 md:mb-0">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" class="pl-10 pr-3 py-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500" placeholder="Search by key or value" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="mb-2 md:mb-0 md:w-48">
                                <select name="group" class="w-full py-2 px-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Groups</option>
                                    <option value="general" {{ request('group') == 'general' ? 'selected' : '' }}>General</option>
                                    <option value="theme" {{ request('group') == 'theme' ? 'selected' : '' }}>Theme</option>
                                    <option value="limits" {{ request('group') == 'limits' ? 'selected' : '' }}>Limits</option>
                                    <option value="api" {{ request('group') == 'api' ? 'selected' : '' }}>API</option>
                                    <option value="chat" {{ request('group') == 'chat' ? 'selected' : '' }}>Chat</option>
                                </select>
                            </div>
                            <div class="mb-2 md:mb-0 md:w-48">
                                <select name="visibility" class="w-full py-2 px-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Visibility</option>
                                    <option value="1" {{ request('visibility') == '1' ? 'selected' : '' }}>Public</option>
                                    <option value="0" {{ request('visibility') == '0' ? 'selected' : '' }}>Private</option>
                                </select>
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors shadow-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Search
                                </button>
                                <a href="{{ route('settings.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors shadow-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Settings Table -->
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visibility</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="settingsTableBody">
                                @foreach ($settings as $setting)
                                
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @php
                                                    $iconClass = 'text-gray-500';
                                                    $bgClass = 'bg-gray-100';
                                                    
                                                    if ($setting->group == 'general') {
                                                        $iconClass = 'text-blue-500';
                                                        $bgClass = 'bg-blue-100';
                                                    } elseif ($setting->group == 'theme') {
                                                        $iconClass = 'text-purple-500';
                                                        $bgClass = 'bg-purple-100';
                                                    } elseif ($setting->group == 'limits') {
                                                        $iconClass = 'text-yellow-500';
                                                        $bgClass = 'bg-yellow-100';
                                                    } elseif ($setting->group == 'api') {
                                                        $iconClass = 'text-red-500';
                                                        $bgClass = 'bg-red-100';
                                                    } elseif ($setting->group == 'chat') {
                                                        $iconClass = 'text-green-500';
                                                        $bgClass = 'bg-green-100';
                                                    }
                                                @endphp
                                                <div class="h-10 w-10 rounded-full {{ $bgClass }} flex items-center justify-center {{ $iconClass }} mr-3">
                                                    @if ($setting->group == 'general')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    @elseif ($setting->group == 'theme')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                                        </svg>
                                                    @elseif ($setting->group == 'limits')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @elseif ($setting->group == 'api')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                                        </svg>
                                                    @elseif ($setting->group == 'chat')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">{{ $setting->key }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($setting->key == 'ai_api_key' && !$setting->is_public)
                                                ••••••••••••••
                                            @elseif (Str::startsWith($setting->key, 'primary_color') || 
                                                   Str::startsWith($setting->key, 'secondary_color') || 
                                                   Str::startsWith($setting->key, 'text_on_primary') ||
                                                   Str::startsWith($setting->key, 'background_'))
                                                <div class="flex items-center">
                                                    <div class="w-6 h-6 rounded mr-2" style="background-color: {{ $setting->value }}"></div>
                                                    {{ $setting->value }}
                                                </div>
                                            @else
                                                {{ $setting->value }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if ($setting->group == 'general') bg-blue-100 text-blue-800
                                                @elseif ($setting->group == 'theme') bg-purple-100 text-purple-800
                                                @elseif ($setting->group == 'limits') bg-yellow-100 text-yellow-800
                                                @elseif ($setting->group == 'api') bg-red-100 text-red-800
                                                @elseif ($setting->group == 'chat') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($setting->group) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if ($setting->is_public) text-green-800 bg-green-100 @else text-red-800 bg-red-100 @endif">
                                                <span class="@if ($setting->is_public) bg-green-400 @else bg-red-400 @endif rounded-full h-2 w-2 mr-1"></span>
                                                {{ $setting->is_public ? 'Public' : 'Private' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ date('Y-m-d', strtotime($setting->updated_at)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button class="bg-blue-100 text-blue-600 p-2 rounded-md hover:bg-blue-200 transition-colors" onclick="viewSetting('{{ $setting->key }}', '{{ $setting->value }}', '{{ $setting->group }}', '{{ $setting->is_public ? 'Public' : 'Private' }}', '{{ $setting->created_at }}', '{{ $setting->updated_at }}')" title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button class="bg-green-100 text-green-600 p-2 rounded-md hover:bg-green-200 transition-colors" onclick="editSetting({{ $setting->id }}, '{{ $setting->key }}', '{{ $setting->value }}', '{{ $setting->group }}', {{ $setting->is_public }})" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button class="bg-yellow-100 text-yellow-600 p-2 rounded-md hover:bg-yellow-200 transition-colors" onclick="copySetting({{ $setting->id }})" title="Copy">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                </button>
                                                <button class="bg-red-100 text-red-600 p-2 rounded-md hover:bg-red-200 transition-colors" onclick="confirmDelete({{ $setting->id }})" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $settings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Setting Modal -->
    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 transform transition-all">
            <div class="border-b p-4 flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Setting
                </h5>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="toggleModal('addModal')">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('settings.store') }}" method="POST" id="addSettingForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Key</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="addSettingKey" name="key" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="addSettingValue" name="value" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Group</label>
                        <select class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="addSettingGroup" name="group" required>
                            <option value="general">General</option>
                            <option value="theme">Theme</option>
                            <option value="limits">Limits</option>
                            <option value="api">API</option>
                            <option value="chat">Chat</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500" id="addSettingPublic" name="is_public" value="1" checked>
                            <span class="ml-2 text-sm text-gray-700">Public Setting</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Public settings are visible to all users. Private settings are only visible to administrators.</p>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100" onclick="toggleModal('addModal')">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow-sm">Add Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 transform transition-all">
            <div class="border-b p-4 flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Setting
                </h5>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="toggleModal('editModal')">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="editSettingForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editSettingId" name="id">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Key</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" id="editSettingKey" name="key" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="editSettingValue" name="value" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Group</label>
                        <select class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" id="editSettingGroup" name="group" required>
                            <option value="general">General</option>
                            <option value="theme">Theme</option>
                            <option value="limits">Limits</option>
                            <option value="api">API</option>
                            <option value="chat">Chat</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="flex items
                            <input type="checkbox" class="rounded text-blue-600 focus:ring-blue-500" id="editSettingPublic" name="is_public" value="1">
                            <span class="ml-2 text-sm text-gray-700">Public Setting</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Public settings are visible to all users. Private settings are only visible to administrators.</p>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100" onclick="toggleModal('editModal')">Cancel</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 shadow-sm">Update Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                                    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 transform transition-all">
            <div class="border-b p-4 flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Delete Setting
                </h5>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="toggleModal('deleteModal')">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>  
            <div class="p-6">
                <p class="text-sm text-gray-700 mb-4">Are you sure you want to delete this setting? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100" onclick="toggleModal('deleteModal')">Cancel</button>
                    <button type="button" id="confirmDeleteButton" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 shadow-sm">Delete Setting</button>
                </div>
            </div>
        </div>

    </div>
    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 transform transition-all">
            <div class="border-b p-4 flex justify-between items-center">
                <h5 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    View Setting
                </h5>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="toggleModal('viewModal')">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text -sm font-medium text-gray-700 mb-1">Key</label>
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" id="viewSettingKey" name="key" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text
-sm font-medium text-gray-700 mb-1">Value</label>
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" id="viewSettingValue" name="value" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text
-sm font-medium text-gray-700 mb-1">Group</label>
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" id="viewSettingGroup" name="group" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text
-sm font-medium text-gray-700 mb-1">Visibility</label>
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" id="viewSettingVisibility" name="visibility" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text
-sm font-medium text-gray-700 mb-1">Created At</label>

                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" id="viewSettingCreatedAt" name="created_at" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text -sm font-medium text-gray-700 mb-1">Updated At</label>
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" id="viewSettingUpdatedAt" name="updated_at" readonly>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100" onclick="toggleModal('viewModal')">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        function viewSetting(key, value, group, visibility, createdAt, updatedAt) {
            document.getElementById('viewSettingKey').value = key;
            document.getElementById('viewSettingValue').value = value;
            document.getElementById('viewSettingGroup').value = group;
            document.getElementById('viewSettingVisibility').value = visibility;
            document.getElementById('viewSettingCreatedAt').value = createdAt;
            document.getElementById('viewSettingUpdatedAt').value = updatedAt;
            toggleModal('viewModal');
        }

        function editSetting(id, key, value, group, isPublic) {
            document.getElementById('editSettingId').value = id;
            document.getElementById('editSettingKey').value = key;
            document.getElementById('editSettingValue').value = value;
            document.getElementById('editSettingGroup').value = group;
            document.getElementById('editSettingPublic').checked = isPublic == 1;
            toggleModal('editModal');
        }
        function copySetting(id) {
            const settingKey = document.getElementById('editSettingKey').value;
            const settingValue = document.getElementById('editSettingValue').value;
            navigator.clipboard.writeText(`${settingKey}: ${settingValue}`).then(() => {
                alert('Setting copied to clipboard!');
            }).catch(err => {
                console.error('Error copying text: ', err);
            });
        }
        function confirmDelete(id) {
            const deleteButton = document.getElementById('confirmDeleteButton');
            deleteButton.onclick = function() {
                document.getElementById('deleteModal').classList.add('hidden');
                document.getElementById('deleteModal').classList.remove('flex');
                // Perform the delete action here
                // For example, you can use AJAX to send a DELETE request to the server
                alert(`Setting with ID ${id} deleted!`);
            };
            toggleModal('deleteModal');
        }
        document.addEventListener('DOMContentLoaded', function() {
            const addSettingForm = document.getElementById('addSettingForm');
            addSettingForm.addEventListener('submit', function(event) {
                event.preventDefault();
                // Perform the form submission logic here
                alert('Setting added!');
                toggleModal('addModal');
            });

            const editSettingForm = document.getElementById('editSettingForm');
            editSettingForm.addEventListener('submit', function(event) {
                event.preventDefault();
                // Perform the form submission logic here
                alert('Setting updated!');
                toggleModal('editModal');
            });
        });
    </script>
</body>
</html>
