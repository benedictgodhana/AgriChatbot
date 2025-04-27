<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch data for the dashboard
        $userCount = \App\Models\User::count();
        $productCount = \App\Models\Product::count();
        $subscriptionCount = \App\Models\Subscription::count();
        $chatCount = \App\Models\Chat::count(); // Assuming you want to count chats
        $sessionCount = \App\Models\Session::count(); // Count sessions
        $knowledgeBaseCount = \App\Models\KnowledgeBase::count(); // Knowledge base articles count
        $attachmentCount = \App\Models\Attachment::count(); // Attachment count
        $messageCount = \App\Models\Message::count(); // Count of messages
        $menuItemCount = \App\Models\MenuItem::count(); // Count of menu items
        $welcomeMessageCount = \App\Models\WelcomeMessage::count(); // Count of welcome messages
    
        // You could also add logic to retrieve specific data like active users, recent subscriptions, etc.
        $recentUsers = \App\Models\User::latest()->take(5)->get(); // Fetch latest 5 users
        $recentSubscriptions = \App\Models\Subscription::latest()->take(5)->get(); // Latest subscriptions
    
        return view('dashboard', compact(
            'userCount', 
            'productCount', 
            'subscriptionCount', 
            'chatCount', 
            'sessionCount', 
            'knowledgeBaseCount', 
            'attachmentCount', 
            'messageCount', 
            'menuItemCount', 
            'welcomeMessageCount', 
            'recentUsers', 
            'recentSubscriptions'
        ));
    }
    
}
