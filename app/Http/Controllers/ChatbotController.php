<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatbotController extends Controller
{
    // Database of farming recommendations and products
    private $farmingDatabase = [
        'fertilizer' => [
            'keywords' => ['fertilizer', 'nutrients', 'npk', 'plant food', 'compost', 'manure', 'mbolea'],
            'recommendation' => 'For most crops, apply a balanced NPK fertilizer based on soil test results.',
            'products' => [
                [
                    'name' => 'All-Purpose 10-10-10 NPK',
                    'price' => 'KES 3,000-4,200 per 50kg bag',
                    'image' => 'products/fertilizer/npk_1010.jpg',
                    'description' => 'Balanced formula suitable for most crops'
                ],
                [
                    'name' => 'Organic Compost',
                    'price' => 'KES 950-1,800 per 40kg bag',
                    'image' => 'products/fertilizer/organic_compost.jpg',
                    'description' => 'Improves soil structure and provides slow-release nutrients'
                ],
                [
                    'name' => 'Bone Meal (for phosphorus)',
                    'price' => 'KES 1,800-2,400 per 20kg bag',
                    'image' => 'products/fertilizer/bone_meal.jpg',
                    'description' => 'High in phosphorus, ideal for flowering and fruiting plants'
                ]
            ]
        ],
        'pest control' => [
            'keywords' => ['pest', 'insect', 'bug', 'aphid', 'beetle', 'spray', 'infestation', 'wadudu'],
            'recommendation' => 'Identify the specific pest before treatment. Consider integrated pest management techniques.',
            'products' => [
                [
                    'name' => 'Neem Oil Spray',
                    'price' => 'KES 1,800-3,000 per liter',
                    'image' => 'products/pest/neem_oil.jpg',
                    'description' => 'Natural pesticide effective against many common pests'
                ],
                [
                    'name' => 'Diatomaceous Earth',
                    'price' => 'KES 1,200-2,400 per 10kg bag',
                    'image' => 'products/pest/diatomaceous_earth.jpg',
                    'description' => 'Physical insecticide that damages insect exoskeletons'
                ],
                [
                    'name' => 'Beneficial Insects (ladybugs)',
                    'price' => 'KES 2,400-3,600 per 1500 insects',
                    'image' => 'products/pest/ladybugs.jpg',
                    'description' => 'Natural predators that feed on aphids and other small pests'
                ]
            ]
        ],
        'irrigation' => [
            'keywords' => ['water', 'irrigation', 'watering', 'drought', 'sprinkler', 'drip', 'moisture', 'maji'],
            'recommendation' => 'Drip irrigation is water-efficient for most crops. Consider soil moisture sensors.',
            'products' => [
                [
                    'name' => 'Drip Irrigation Starter Kit',
                    'price' => 'KES 6,000-12,000 for basic setup',
                    'image' => 'products/irrigation/drip_kit.jpg',
                    'description' => 'Complete system for efficient water delivery directly to plant roots'
                ],
                [
                    'name' => 'Soaker Hose (15m)',
                    'price' => 'KES 1,800-3,600',
                    'image' => 'products/irrigation/soaker_hose.jpg',
                    'description' => 'Porous hose that allows water to seep out along its length'
                ],
                [
                    'name' => 'Soil Moisture Sensor',
                    'price' => 'KES 2,400-4,800 per unit',
                    'image' => 'products/irrigation/moisture_sensor.jpg',
                    'description' => 'Monitors soil moisture to help optimize watering schedules'
                ]
            ]
        ],
        'soil' => [
            'keywords' => ['soil', 'dirt', 'ground', 'earth', 'ph', 'acidity', 'alkaline', 'clay', 'loam', 'sandy', 'udongo'],
            'recommendation' => 'Test soil pH and nutrient levels annually. Amend soil based on test results.',
            'products' => [
                [
                    'name' => 'Soil Test Kit',
                    'price' => 'KES 1,800-3,600',
                    'image' => 'products/soil/test_kit.jpg',
                    'description' => 'Tests soil pH, nitrogen, phosphorus, and potassium levels'
                ],
                [
                    'name' => 'Agricultural Lime (to raise pH)',
                    'price' => 'KES 600-1,200 per 40kg bag',
                    'image' => 'products/soil/lime.jpg',
                    'description' => 'Raises soil pH for crops that prefer less acidic conditions'
                ],
                [
                    'name' => 'Sulfur (to lower pH)',
                    'price' => 'KES 1,200-1,800 per 5kg bag',
                    'image' => 'products/soil/sulfur.jpg',
                    'description' => 'Lowers soil pH for acid-loving plants'
                ]
            ]
        ],
        'seeds' => [
            'keywords' => ['seed', 'germinate', 'variety', 'heirloom', 'sow', 'plant', 'sprout', 'mbegu'],
            'recommendation' => 'Choose varieties suited to your climate zone. Consider disease-resistant varieties.',
            'products' => [
                [
                    'name' => 'Heirloom Vegetable Seed Collection',
                    'price' => 'KES 2,400-4,800 for variety pack',
                    'image' => 'products/seeds/heirloom_collection.jpg',
                    'description' => 'Traditional varieties with excellent flavor and adaptability'
                ],
                [
                    'name' => 'Cover Crop Seeds',
                    'price' => 'KES 1,200-3,000 per kg',
                    'image' => 'products/seeds/cover_crop.jpg',
                    'description' => 'Improves soil health between main crop plantings'
                ],
                [
                    'name' => 'Non-GMO Maize Seeds',
                    'price' => 'KES 360-960 per packet',
                    'image' => 'products/seeds/maize.jpg',
                    'description' => 'High-yielding varieties developed for Kenyan conditions'
                ]
            ]
        ],
        'crop rotation' => [
            'keywords' => ['rotation', 'planting schedule', 'crop planning', 'succession', 'mbadilishano'],
            'recommendation' => 'Crop rotation helps prevent pest and disease buildup. Rotate between plant families: legumes, brassicas, alliums, and nightshades.',
            'products' => [
                [
                    'name' => 'Crop Planning Software',
                    'price' => 'KES 6,000-24,000 per year',
                    'image' => 'products/planning/software.jpg',
                    'description' => 'Digital tool for planning crop rotations and schedules'
                ],
                [
                    'name' => 'Soil Test Kit',
                    'price' => 'KES 1,800-3,600',
                    'image' => 'products/planning/test_kit.jpg',
                    'description' => 'Helps determine soil needs after each rotation'
                ],
                [
                    'name' => 'Cover Crop Seed Mix',
                    'price' => 'KES 600-1,800 per kg',
                    'image' => 'products/planning/cover_crop_mix.jpg',
                    'description' => 'Blend of legumes and grasses for soil improvement between crops'
                ]
            ]
        ]
    ];


    // Intent patterns for common farming queries
    private $intentPatterns = [
        'greeting' => [
            'patterns' => ['hello', 'hi', 'hey', 'greetings', 'good morning', 'good afternoon', 'good evening'],
            'response' => "Hello! I'm your farming assistant. What farming topic can I help you with today?"
        ],
        'price_inquiry' => [
            'patterns' => ['how much', 'price', 'cost', 'affordable', 'expensive', 'cheap'],
            'response' => "Prices vary by region and quality. What specific farming product are you interested in?"
        ],
        'help_request' => [
            'patterns' => ['help', 'advice', 'suggestion', 'recommend', 'what should i', 'how do i'],
            'response' => "I can provide information on fertilizers, pest control, irrigation, soil management, and seeds. What specific farming area do you need help with?"
        ],
        'thank_you' => [
            'patterns' => ['thank', 'thanks', 'appreciate', 'grateful'],
            'response' => "You're welcome! Feel free to ask if you have any other farming questions."
        ],
        'comparison' => [
            'patterns' => ['versus', 'vs', 'compare', 'difference', 'better than', 'worse than'],
            'response' => "Comparing farming methods depends on your specific needs, soil conditions, climate, and goals. Could you provide more details about what you're trying to compare?"
        ]
    ];

    // Stopwords to filter out
    private $stopwords = ['the', 'and', 'a', 'an', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'about', 'is', 'are', 'was', 'were'];

    // Training data for simple classifier
    private $trainingData = [];

    public function __construct()
    {
        // Initialize training data from the farming database
        foreach ($this->farmingDatabase as $topic => $data) {
            foreach ($data['keywords'] as $keyword) {
                $this->trainingData[] = [
                    'text' => $keyword,
                    'category' => $topic
                ];
            }
        }
    }

    public function chat(Request $request)
    {
        try {
            $userMessage = $request->input('message');

            // Validate user input
            if (empty($userMessage)) {
                return response()->json(['reply' => 'Please provide a message.'], 400);
            }

            // Process the message with our NLP functions
            $reply = $this->processMessage($userMessage);

            // Log Response
            Log::info('Chatbot Response: ', ['reply' => $reply]);

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            // Log Error
            Log::error('Chatbot Error: ' . $e->getMessage());
            return response()->json(['reply' => 'Error processing your request.'], 500);
        }
    }

    private function processMessage($message)
    {
        $message = strtolower($message);

        // First, check for intents (specific patterns)
        $intent = $this->detectIntent($message);
        if ($intent) {
            return $intent;
        }

        // Tokenize and preprocess the message
        $tokens = $this->tokenize($message);
        $filteredTokens = $this->removeStopwords($tokens);

        // Find the best matching topic
        $bestMatch = $this->findBestMatch($filteredTokens);

        if ($bestMatch) {
            $topic = $this->farmingDatabase[$bestMatch];
            $reply = $topic['recommendation'] . "\n\nRecommended products:\n";
            foreach ($topic['products'] as $product) {
                $reply .= "- " . $product['name'] . ": " . $product['price'] . "\n";
            }
            return $reply;
        }

        // If no good match is found, save this message for learning
        $this->saveUnmatchedQuery($message);

        // Default response
        return "I don't have specific information on that farming topic yet. I can provide information on fertilizers, pest control, irrigation, soil management, seeds, and crop rotation. What would you like to know more about?";
    }

    private function detectIntent($message)
    {
        foreach ($this->intentPatterns as $intent => $data) {
            foreach ($data['patterns'] as $pattern) {
                if (stripos($message, $pattern) !== false) {
                    return $data['response'];
                }
            }
        }
        return null;
    }

    private function tokenize($text)
    {
        // Simple tokenization by spaces and removing punctuation
        $text = preg_replace('/[^\w\s]/', '', $text);
        return explode(' ', trim($text));
    }

    private function removeStopwords($tokens)
    {
        return array_filter($tokens, function($token) {
            return !in_array($token, $this->stopwords) && !empty($token);
        });
    }

    private function findBestMatch($tokens)
    {
        if (empty($tokens)) {
            return null;
        }

        $scores = [];

        // Calculate TF-IDF like scores for each category
        foreach ($this->farmingDatabase as $topic => $data) {
            $scores[$topic] = 0;

            foreach ($tokens as $token) {
                // Simple word matching for now
                if (in_array($token, $data['keywords'])) {
                    $scores[$topic] += 1;
                }

                // Partial matching with stemming-like approach
                foreach ($data['keywords'] as $keyword) {
                    if (strpos($token, $keyword) !== false || strpos($keyword, $token) !== false) {
                        if (strlen($token) >= 4 && strlen($keyword) >= 4) { // Only match substantial substrings
                            $scores[$topic] += 0.5;
                        }
                    }
                }
            }
        }

        // Find topic with highest score
        arsort($scores);
        $topTopic = key($scores);

        // Only return if score is above threshold
        if ($scores[$topTopic] > 0) {
            return $topTopic;
        }

        return null;
    }

    private function saveUnmatchedQuery($query)
    {
        // Save unmatched queries to potentially learn from later
        try {
            $date = date('Y-m-d');
            $path = "chatbot/unmatched_queries_{$date}.txt";

            if (!Storage::exists($path)) {
                Storage::put($path, "{$query}\n");
            } else {
                Storage::append($path, "{$query}\n");
            }
        } catch (\Exception $e) {
            Log::error('Failed to save unmatched query: ' . $e->getMessage());
        }
    }

    // Method to add new topics based on learning
    public function addNewTopic($topic, $keywords, $recommendation, $products)
    {
        $this->farmingDatabase[$topic] = [
            'keywords' => $keywords,
            'recommendation' => $recommendation,
            'products' => $products
        ];

        // Update training data
        foreach ($keywords as $keyword) {
            $this->trainingData[] = [
                'text' => $keyword,
                'category' => $topic
            ];
        }

        return true;
    }

    public function show()
    {
        return view('chatbot');  // Ensure you have a view named 'chatbot.blade.php'
    }

}
