<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\MenuItem;
use App\Models\WelcomeMessage;
use App\Models\Subscription;
use App\Models\KnowledgeBase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingsSeeder::class,
            MenuItemsSeeder::class,
            WelcomeMessagesSeeder::class,
            SubscriptionsSeeder::class,
            KnowledgeBaseSeeder::class,
        ]);
    }
}

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // App settings
            ['key' => 'app_name', 'value' => 'FarmerAI', 'group' => 'general'],
            ['key' => 'app_description', 'value' => 'Your agricultural assistant', 'group' => 'general'],
            ['key' => 'ai_name', 'value' => 'FarmerAI', 'group' => 'general'],
            
            // Theme settings
            ['key' => 'primary_color', 'value' => '#2e7d32', 'group' => 'theme'],
            ['key' => 'primary_light', 'value' => '#60ad5e', 'group' => 'theme'],
            ['key' => 'primary_dark', 'value' => '#005005', 'group' => 'theme'],
            ['key' => 'secondary_color', 'value' => '#795548', 'group' => 'theme'],
            ['key' => 'text_on_primary', 'value' => '#ffffff', 'group' => 'theme'],
            ['key' => 'text_primary', 'value' => '#212121', 'group' => 'theme'],
            ['key' => 'background_light', 'value' => '#f8f9fa', 'group' => 'theme'],
            ['key' => 'background_dark', 'value' => '#121212', 'group' => 'theme'],
            ['key' => 'text_dark', 'value' => '#e0e0e0', 'group' => 'theme'],
            ['key' => 'card_dark', 'value' => '#1e1e1e', 'group' => 'theme'],
            
            // Input settings
            ['key' => 'input_placeholder', 'value' => 'Ask about crops, soil, pests, weather, or farming techniques...', 'group' => 'chat'],
            
            // Message limits
            ['key' => 'free_message_limit', 'value' => '10', 'group' => 'limits'],
            ['key' => 'basic_message_limit', 'value' => '50', 'group' => 'limits'],
            ['key' => 'premium_message_limit', 'value' => '0', 'group' => 'limits'], // 0 = unlimited
            
            // API settings
            ['key' => 'ai_api_key', 'value' => 'your-api-key-here', 'group' => 'api', 'is_public' => false],
            ['key' => 'ai_model', 'value' => 'gpt-4', 'group' => 'api', 'is_public' => false],
            ['key' => 'ai_temperature', 'value' => '0.7', 'group' => 'api', 'is_public' => false],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}

class MenuItemsSeeder extends Seeder
{
    public function run()
    {
        // Tools menu items
        $toolsItems = [
            ['title' => 'Export Chat', 'url' => '/chats/export', 'icon' => 'file-export', 'group' => 'tools', 'order' => 1],
            ['title' => 'Print Chat', 'url' => '/chats/print', 'icon' => 'print', 'group' => 'tools', 'order' => 2],
            ['title' => 'Clear History', 'url' => '/chats/clear', 'icon' => 'trash', 'group' => 'tools', 'order' => 3],
        ];

        // Info menu items
        $infoItems = [
            ['title' => 'User Guide', 'url' => '/help/guide', 'icon' => 'book-open', 'group' => 'info', 'order' => 1],
            ['title' => 'Tips & Tricks', 'url' => '/help/tips', 'icon' => 'lightbulb', 'group' => 'info', 'order' => 2],
            ['title' => 'Report Bug', 'url' => '/help/report-bug', 'icon' => 'bug', 'group' => 'info', 'order' => 3],
        ];

        // Settings menu items
        $settingsItems = [
            ['title' => 'Preferences', 'url' => '/settings/preferences', 'icon' => 'sliders-h', 'group' => 'settings', 'order' => 1],
            ['title' => 'Notifications', 'url' => '/settings/notifications', 'icon' => 'bell', 'group' => 'settings', 'order' => 2],
            ['title' => 'Language', 'url' => '/settings/language', 'icon' => 'language', 'group' => 'settings', 'order' => 3],
        ];

        // Profile menu items
        $profileItems = [
            ['title' => 'Profile', 'url' => '/profile', 'icon' => 'user-circle', 'group' => 'profile', 'order' => 1],
            ['title' => 'Subscription', 'url' => '/subscription', 'icon' => 'credit-card', 'group' => 'profile', 'order' => 2],
        ];

        // Footer links
        $footerItems = [
            ['title' => 'Terms', 'url' => '/legal/terms', 'icon' => 'file-contract', 'group' => 'footer', 'order' => 1],
            ['title' => 'Privacy', 'url' => '/legal/privacy', 'icon' => 'shield-alt', 'group' => 'footer', 'order' => 2],
            ['title' => 'Feedback', 'url' => '/feedback', 'icon' => 'comment', 'group' => 'footer', 'order' => 3],
        ];

        // Sidebar links
        $sidebarItems = [
            ['title' => 'Help & FAQ', 'url' => '/help', 'icon' => 'question-circle', 'group' => 'sidebar', 'order' => 1],
            ['title' => 'Knowledge Base', 'url' => '/knowledge', 'icon' => 'book', 'group' => 'sidebar', 'order' => 2],
            ['title' => 'What\'s New', 'url' => '/whats-new', 'icon' => 'bullhorn', 'group' => 'sidebar', 'order' => 3],
        ];

        $allItems = array_merge($toolsItems, $infoItems, $settingsItems, $profileItems, $footerItems, $sidebarItems);

        foreach ($allItems as $item) {
            MenuItem::create($item);
        }
    }
}

class WelcomeMessagesSeeder extends Seeder
{
    public function run()
    {
        $welcomeMessages = [
            [
                'content' => "Hello! I'm FarmerAI, your agricultural assistant. How can I help with your farming questions today? I can provide advice on crops, soil management, pest control, weather planning, and more.",
                'is_active' => true
            ],
            [
                'content' => "Welcome to FarmerAI! I'm here to assist with all your agricultural needs. Whether you need help with crop selection, disease identification, or sustainable farming practices, I'm ready to provide expert guidance.",
                'is_active' => true
            ],
            [
                'content' => "Greetings! I'm your FarmerAI assistant, designed to support your agricultural journey. Ask me about planting schedules, soil health, irrigation methods, or any other farming topics you're curious about.",
                'is_active' => true
            ],
            [
                'content' => "Hi there! I'm FarmerAI, your personal farming advisor. How can I help optimize your agricultural operations today? I can provide recommendations for crop rotation, pest management, or efficient resource usage.",
                'is_active' => true
            ]
        ];

        foreach ($welcomeMessages as $message) {
            WelcomeMessage::create($message);
        }
    }
}

class SubscriptionsSeeder extends Seeder
{
    public function run()
    {
        $subscriptions = [
            [
                'name' => 'Free',
                'description' => 'Basic access to FarmerAI with limited features',
                'price' => 0.00,
                'message_limit' => 10,
                'has_file_upload' => false,
                'has_voice_input' => false,
                'has_advanced_features' => false,
            ],
            [
                'name' => 'Basic',
                'description' => 'Enhanced access with file uploads and more messages',
                'price' => 9.99,
                'message_limit' => 50,
                'has_file_upload' => true,
                'has_voice_input' => false,
                'has_advanced_features' => false,
            ],
            [
                'name' => 'Premium',
                'description' => 'Full access to all FarmerAI features with unlimited messages',
                'price' => 19.99,
                'message_limit' => null, // null for unlimited
                'has_file_upload' => true,
                'has_voice_input' => true,
                'has_advanced_features' => true,
            ]
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::create($subscription);
        }
    }
}

class KnowledgeBaseSeeder extends Seeder
{
    public function run()
    {
        $knowledgeBaseEntries = [
            [
                'title' => 'Crop Rotation Basics',
                'content' => "Crop rotation is the practice of growing different types of crops in the same area across a sequence of growing seasons. It reduces reliance on one set of nutrients, pest and weed pressure, and the probability of developing resistant pests and weeds.\n\nBenefits include:\n- Improved soil structure and fertility\n- Pest and disease control\n- Weed suppression\n- Reduced soil erosion\n- Increased biodiversity\n\nCommon rotation sequences include:\n1. Corn → Soybeans → Wheat → Cover crop\n2. Potatoes → Beans → Grains → Forage",
                'category' => 'crop_management',
                'tags' => json_encode(['crop rotation', 'soil health', 'pest control', 'sustainable farming']),
                'source' => 'Agricultural Extension Service'
            ],
            [
                'title' => 'Soil pH Management',
                'content' => "Soil pH is a measure of the acidity or alkalinity of soil. pH is measured on a scale of 1-14, with 7 being neutral. Below 7 is acidic and above 7 is alkaline.\n\nMost plants thrive in soil with a pH between 6.0 and 7.5. Some plants, like blueberries, prefer more acidic conditions.\n\nAdjusting soil pH:\n- To raise pH (make less acidic): add lime\n- To lower pH (make more acidic): add sulfur or aluminum sulfate\n\nAlways test your soil before making adjustments and apply amendments according to soil test recommendations.",
                'category' => 'soil_management',
                'tags' => json_encode(['soil pH', 'soil amendments', 'lime', 'sulfur', 'soil testing']),
                'source' => 'National Soil Health Institute'
            ],
            [
                'title' => 'Integrated Pest Management',
                'content' => "Integrated Pest Management (IPM) is an ecosystem-based strategy focusing on long-term prevention of pests through a combination of techniques.\n\nKey components of IPM:\n1. Prevention: Cultural practices that discourage pest development\n2. Monitoring: Regular field scouting to identify pests\n3. Action thresholds: Determining when action is necessary\n4. Control methods: Using the most effective, least-risk options\n   - Biological controls: Beneficial insects, microbes\n   - Cultural controls: Crop rotation, trap crops\n   - Mechanical controls: Traps, barriers\n   - Chemical controls: Used as a last resort\n\nIPM benefits include reduced pesticide use, lower costs, and environmental protection.",
                'category' => 'pest_management',
                'tags' => json_encode(['IPM', 'pest control', 'beneficial insects', 'sustainable farming', 'pesticide reduction']),
                'source' => 'USDA Agricultural Research Service'
            ],
        ];

        foreach ($knowledgeBaseEntries as $entry) {
            KnowledgeBase::create($entry);
        }
    }
}