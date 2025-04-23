<x-app-layout>
<div x-data="chatbot()" class="mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="chatbox h-[600px] overflow-y-auto p-4" id="chatbox">
            <!-- Welcome Message -->

            <!-- Error Message -->
            <template x-if="errorMessage">
                <div class="error-message text-red-500 p-2 bg-red-50 rounded" x-text="errorMessage"></div>
            </template>

            <!-- Messages -->
            <template x-for="message in messages" :key="message.id">
                <div :class="['message', 'flex', 'items-start', 'mb-4', message.sender === 'user' ? 'justify-end' : 'justify-start']">
                    <template x-if="message.sender === 'bot'">
                        <div class="bot-icon mr-3">
                            <i class="fas fa-robot text-green-600"></i>
                        </div>
                    </template>
                    <div class="flex flex-col">
                        <div :class="['message-content', 'p-3', 'rounded-lg', 'max-w-md',
                            message.sender === 'user'
                                ? 'bg-emerald-100 text-right self-end'
                                : 'bg-green-50 text-left self-start']">
                            <template x-if="message.image">
                                <img :src="message.image" class="max-w-full h-auto rounded mb-2" />
                            </template>
                            <span x-text="message.text"></span>

                            <!-- Edit button for user messages -->
                            <template x-if="message.sender === 'user'">
                                <button
                                    @click="editMessage(message)"
                                    class="ml-2 text-gray-500 hover:text-green-600 message-edit"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                    <template x-if="message.sender === 'user'">
                        <div class="user-icon ml-3">
                            <i class="fas fa-user text-emerald-600"></i>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Quick Action Buttons -->
            <div x-show="!isLoading && messages.length > 0" class="quick-actions flex flex-wrap gap-2 mb-4">
                <button @click="setQuickQuestion('Fertilizers for corn')" class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">Fertilizers</button>
                <button @click="setQuickQuestion('Pest control solutions')" class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">Pest control</button>
                <button @click="setQuickQuestion('Safety information')" class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">Safety info</button>
                <button @click="setQuickQuestion('Recommend crop solutions')" class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">Recommendations</button>
                <button @click="openCart()" class="px-3 py-1 bg-green-600 text-white rounded-full text-sm hover:bg-green-700 transition flex items-center">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    <span x-text="cartItems.length"></span>
                </button>
            </div>

            <!-- Loading Indicator -->
            <template x-if="isLoading">
                <div class="loading-indicator flex justify-center space-x-2 py-2">
                    <div class="loading-dot bg-green-600" style="animation-delay: -0.32s;"></div>
                    <div class="loading-dot bg-green-600" style="animation-delay: -0.16s;"></div>
                    <div class="loading-dot bg-green-600"></div>
                </div>
            </template>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t bg-gray-50">
            <!-- Image Upload -->
            <div x-show="selectedImage" x-cloak class="mb-2 flex items-center">
                <img :src="selectedImage" class="w-20 h-20 object-cover rounded mr-3" />
                <button
                    @click="clearImage"
                    class="text-red-500 hover:text-red-700"
                >
                    <i class="fas fa-times"></i> Remove Image
                </button>
            </div>

            <div class="flex">
                <!-- Image Upload Button -->
                <label class="mr-2 bg-gray-200 text-gray-700 p-3 rounded-l-lg cursor-pointer hover:bg-gray-300 transition">
                    <input
                        type="file"
                        accept="image/*"
                        @change="handleImageUpload"
                        class="hidden"
                    >
                    <i class="fas fa-image"></i>
                </label>

                <!-- Camera Input for Mobile -->
                <label class="mr-2 bg-gray-200 text-gray-700 p-3 cursor-pointer hover:bg-gray-300 transition">
                    <input
                        type="file"
                        accept="image/*"
                        capture="environment"
                        @change="handleImageUpload"
                        class="hidden"
                    >
                    <i class="fas fa-camera"></i>
                </label>

                <input
                    type="text"
                    x-model="userInput"
                    @keydown.enter="sendMessage()"
                    placeholder="Ask about fertilizers, pesticides, herbicides, or crop solutions..."
                    class="w-full p-3 border focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <button
                    @click="sendMessage()"
                    :disabled="isLoading"
                    class="bg-green-600 text-white px-4 rounded-r-lg hover:bg-green-700 transition disabled:opacity-50"
                >
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <!-- Edit Message Modal -->
        <template x-if="editingMessage">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                    <h2 class="text-xl font-bold mb-4">Edit Message</h2>
                    <textarea
                        x-model="editedMessageText"
                        class="w-full p-3 border rounded mb-4 h-32"
                    ></textarea>
                    <div class="flex justify-end space-x-2">
                        <button
                            @click="cancelEdit"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300"
                        >
                            Cancel
                        </button>
                        <button
                            @click="saveEditedMessage"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <!-- Product Recommendations Modal -->
        <template x-if="showRecommendations">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-4xl w-full">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Recommended Agrochemical Products</h2>
                        <button @click="closeRecommendations" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <template x-for="product in recommendedProducts" :key="product.id">
                            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                <img :src="product.image" class="w-full h-48 object-cover" />
                                <div class="p-3">
                                    <h3 class="font-bold" x-text="product.name"></h3>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-green-600 font-bold" x-text="'$' + product.price"></span>
                                        <span x-text="product.size" class="text-sm text-gray-500"></span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1" x-text="product.description"></p>
                                    <div class="flex justify-between mt-3">
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded" x-text="product.category"></span>
                                        <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded" x-text="product.certification"></span>
                                    </div>
                                    <button
                                        @click="addToCart(product)"
                                        class="w-full mt-3 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        <!-- Shopping Cart Modal -->
        <template x-if="showCart">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-3xl w-full">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Your Shopping Cart</h2>
                        <button @click="closeCart()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <template x-if="cartItems.length === 0">
                        <div class="text-center py-8">
                            <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500">Your cart is empty</p>
                            <button
                                @click="closeCart(); setQuickQuestion('Recommend crop solutions')"
                                class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                            >
                                Browse Products
                            </button>
                        </div>
                    </template>

                    <template x-if="cartItems.length > 0">
                        <div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="p-2 text-left">Product</th>
                                            <th class="p-2 text-center">Quantity</th>
                                            <th class="p-2 text-right">Price</th>
                                            <th class="p-2 text-right">Subtotal</th>
                                            <th class="p-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(item, index) in cartItems" :key="index">
                                            <tr class="border-b">
                                                <td class="p-2">
                                                    <div class="flex items-center">
                                                        <img :src="item.image" class="w-12 h-12 object-cover rounded mr-2" />
                                                        <div>
                                                            <div x-text="item.name" class="font-medium"></div>
                                                            <div x-text="item.size" class="text-sm text-gray-500"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="flex items-center justify-center">
                                                        <button
                                                            @click="updateCartItemQuantity(index, -1)"
                                                            class="bg-gray-200 text-gray-600 w-8 h-8 rounded-l flex items-center justify-center"
                                                            :disabled="item.quantity <= 1"
                                                        >
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <span class="w-10 h-8 border-t border-b flex items-center justify-center" x-text="item.quantity"></span>
                                                        <button
                                                            @click="updateCartItemQuantity(index, 1)"
                                                            class="bg-gray-200 text-gray-600 w-8 h-8 rounded-r flex items-center justify-center"
                                                        >
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="p-2 text-right" x-text="'$' + item.price"></td>
                                                <td class="p-2 text-right font-medium" x-text="'$' + (item.price * item.quantity).toFixed(2)"></td>
                                                <td class="p-2 text-right">
                                                    <button @click="removeCartItem(index)" class="text-red-500 hover:text-red-700">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                    <tfoot>
                                        <tr class="border-t-2">
                                            <td colspan="3" class="p-2 text-right font-bold">Total:</td>
                                            <td class="p-2 text-right font-bold" x-text="'$' + calculateCartTotal()"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-6 flex justify-between">
                                <button
                                    @click="closeCart()"
                                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300"
                                >
                                    Continue Shopping
                                </button>
                                <button
                                    @click="proceedToCheckout()"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                                >
                                    Proceed to Checkout
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <!-- Checkout Modal -->
        <template x-if="showCheckout">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-3xl w-full">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Checkout</h2>
                        <button @click="closeCheckout()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Information -->
                        <div>
                            <h3 class="font-bold mb-3">Customer Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" x-model="checkoutForm.name" class="w-full p-2 border rounded" placeholder="Full Name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" x-model="checkoutForm.email" class="w-full p-2 border rounded" placeholder="Email Address">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="tel" x-model="checkoutForm.phone" class="w-full p-2 border rounded" placeholder="Phone Number">
                                </div>
                            </div>

                            <h3 class="font-bold mt-5 mb-3">Shipping Address</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" x-model="checkoutForm.address" class="w-full p-2 border rounded" placeholder="Street Address">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" x-model="checkoutForm.city" class="w-full p-2 border rounded" placeholder="City">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                        <input type="text" x-model="checkoutForm.state" class="w-full p-2 border rounded" placeholder="State/Province">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                        <input type="text" x-model="checkoutForm.postal" class="w-full p-2 border rounded" placeholder="Postal/ZIP Code">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                        <input type="text" x-model="checkoutForm.country" class="w-full p-2 border rounded" placeholder="Country">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div>
                            <h3 class="font-bold mb-3">Order Summary</h3>
                            <div class="border rounded p-3 mb-4">
                                <table class="w-full text-sm">
                                    <tbody>
                                        <template x-for="(item, index) in cartItems" :key="index">
                                            <tr class="border-b">
                                                <td class="py-2">
                                                    <span x-text="item.quantity"></span> x
                                                    <span x-text="item.name"></span>
                                                    <span x-text="'(' + item.size + ')'" class="text-gray-500"></span>
                                                </td>
                                                <td class="py-2 text-right" x-text="'$' + (item.price * item.quantity).toFixed(2)"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                    <tfoot>
                                        <tr class="border-b">
                                            <td class="py-2">Subtotal</td>
                                            <td class="py-2 text-right" x-text="'$' + calculateCartTotal()"></td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-2">Shipping</td>
                                            <td class="py-2 text-right">$10.00</td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-2">Tax</td>
                                            <td class="py-2 text-right" x-text="'$' + calculateTax()"></td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-bold">Total</td>
                                            <td class="py-2 text-right font-bold" x-text="'$' + calculateGrandTotal()"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <h3 class="font-bold mb-3">Payment Method</h3>
                            <div class="space-y-3">
                                <div class="border rounded p-3">
                                    <label class="flex items-center">
                                        <input type="radio" x-model="checkoutForm.paymentMethod" value="credit" class="mr-2">
                                        <span>Credit Card</span>
                                    </label>
                                    <template x-if="checkoutForm.paymentMethod === 'credit'">
                                        <div class="mt-3 space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                                <input type="text" x-model="checkoutForm.cardNumber" class="w-full p-2 border rounded" placeholder="Card Number">
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                                    <input type="text" x-model="checkoutForm.cardExpiry" class="w-full p-2 border rounded" placeholder="MM/YY">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                                    <input type="text" x-model="checkoutForm.cardCvc" class="w-full p-2 border rounded" placeholder="CVC">
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="border rounded p-3">
                                    <label class="flex items-center">
                                        <input type="radio" x-model="checkoutForm.paymentMethod" value="paypal" class="mr-2">
                                        <span>PayPal</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button
                                    @click="submitOrder()"
                                    class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition"
                                    :disabled="isProcessingOrder"
                                >
                                    <template x-if="!isProcessingOrder">
                                        <span>Complete Order</span>
                                    </template>
                                    <template x-if="isProcessingOrder">
                                        <span>Processing...</span>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Order Confirmation Modal -->
        <template x-if="showOrderConfirmation">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full text-center">
                    <div class="mb-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-check text-green-600 text-2xl"></i>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold mb-2">Order Confirmed!</h2>
                    <p class="text-gray-600 mb-4">Thank you for your purchase. Your order number is <span class="font-bold" x-text="'#' + orderNumber"></span>.</p>
                    <p class="text-gray-600 mb-6">We've sent a confirmation email to <span class="font-medium" x-text="checkoutForm.email"></span> with all the details.</p>
                    <button
                        @click="finishOrder()"
                        class="bg-green-600 text-white py-2 px-6 rounded hover:bg-green-700"
                    >
                        Continue Shopping
                    </button>
                </div>
            </div>
        </template>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
   function chatbot() {
    return {
        userInput: '',
        messages: [],
        isLoading: false,
        errorMessage: null,
        selectedImage: null,
        editingMessage: null,
        editedMessageText: '',
        showRecommendations: false,
        cartItems: [],
        showCart: false,
        showCheckout: false,
        isProcessingOrder: false,
        showOrderConfirmation: false,
        orderNumber: '',

        checkoutForm: {
            name: '',
            email: '',
            phone: '',
            address: '',
            city: '',
            state: '',
            postal: '',
            country: '',
            paymentMethod: 'credit',
            cardNumber: '',
            cardExpiry: '',
            cardCvc: ''
        },

        recommendedProducts: [
            {
                id: 1,
                name: "NutriGrow Plus NPK",
                price: "45.99",
                size: "5L",
                category: "Fertilizer",
                certification: "Organic Certified",
                description: "Balanced NPK formula with micronutrients for enhanced crop yield",
                image: "/api/placeholder/400/300"
            },
            {
                id: 2,
                name: "PestShield Ultra",
                price: "39.99",
                size: "2L",
                category: "Insecticide",
                certification: "ECO Friendly",
                description: "Broad-spectrum insecticide with rapid knockdown effect",
                image: "/api/placeholder/400/300"
            },
            {
                id: 3,
                name: "WeedClear Advanced",
                price: "32.50",
                size: "4L",
                category: "Herbicide",
                certification: "Sustainable",
                description: "Selective herbicide for broad-leaf weed control in cereal crops",
                image: "/api/placeholder/400/300"
            },
            {
                id: 4,
                name: "FungaStop Pro",
                price: "48.75",
                size: "1L",
                category: "Fungicide",
                certification: "Advanced",
                description: "Systemic fungicide providing broad-spectrum disease control",
                image: "/api/placeholder/400/300"
            },
            {
                id: 5,
                name: "RootBoost Gold",
                price: "29.99",
                size: "2kg",
                category: "Root Stimulant",
                certification: "Organic",
                description: "Enhances root development and nutrient uptake efficiency",
                image: "/api/placeholder/400/300"
            },
            {
                id: 6,
                name: "YieldMax Complete",
                price: "54.50",
                size: "10kg",
                category: "Fertilizer",
                certification: "Premium",
                description: "All-in-one crop performance enhancer with trace minerals",
                image: "/api/placeholder/400/300"
            }
        ],

        setQuickQuestion(question) {
            this.userInput = question;
            this.sendMessage();
        },

        openCart() {
            this.showCart = true;
        },

        closeCart() {
            this.showCart = false;
        },

        proceedToCheckout() {
            if (this.cartItems.length > 0) {
                this.closeCart();
                this.showCheckout = true;
            }
        },

        closeCheckout() {
            this.showCheckout = false;
        },

        calculateCartTotal() {
            return this.cartItems.reduce((total, item) => {
                return total + (parseFloat(item.price) * item.quantity);
            }, 0).toFixed(2);
        },

        calculateTax() {
            return (parseFloat(this.calculateCartTotal()) * 0.08).toFixed(2);
        },

        calculateGrandTotal() {
            // Calculate total + shipping + tax
            return (parseFloat(this.calculateCartTotal()) + 10.00 + parseFloat(this.calculateTax())).toFixed(2);
        },

        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.selectedImage = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        clearImage() {
            this.selectedImage = null;
        },

        sendMessage() {
            if (!this.userInput.trim() && !this.selectedImage) return;

            // Add user message to chat
            const userMessage = {
                id: Date.now(),
                sender: 'user',
                text: this.userInput.trim(),
                image: this.selectedImage,
                timestamp: new Date()
            };

            this.messages.push(userMessage);
            this.isLoading = true;

            // Clear input and image
            const userQuery = this.userInput;
            this.userInput = '';
            this.selectedImage = null;

            // Simulate API call for bot response
            setTimeout(() => {
                this.generateBotResponse(userQuery);
            }, 1500);

            // Scroll to bottom of chat
            this.$nextTick(() => {
                const chatbox = document.getElementById('chatbox');
                chatbox.scrollTop = chatbox.scrollHeight;
            });
        },

        generateBotResponse(query) {
            let botMessage = {
                id: Date.now(),
                sender: 'bot',
                text: '',
                timestamp: new Date()
            };

            // Show product recommendations if query contains keywords
            if (query.toLowerCase().includes('recommend') ||
                query.toLowerCase().includes('product') ||
                query.toLowerCase().includes('solution')) {
                botMessage.text = "I've found some product recommendations based on your query. Here are some options that might help.";
                this.showRecommendations = true;
            }
            // Handle different types of queries
            else if (query.toLowerCase().includes('fertilizer') || query.toLowerCase().includes('nutrient')) {
                botMessage.text = "Our fertilizer range includes organic and conventional options designed for various crops. Would you like specific recommendations based on your crop type and soil conditions?";
            }
            else if (query.toLowerCase().includes('pest') || query.toLowerCase().includes('insect')) {
                botMessage.text = "For pest control, we offer both chemical and biological solutions. Could you describe the pest problem you're experiencing? Including the crop type and pest species would help me recommend the most effective product.";
            }
            else if (query.toLowerCase().includes('safety') || query.toLowerCase().includes('protection')) {
                botMessage.text = "Safety is our priority. All our products come with detailed safety instructions. Always wear appropriate protective equipment (gloves, masks, goggles) when handling agrochemicals. Would you like safety information for a specific product?";
            }
            else if (query.toLowerCase().includes('organic') || query.toLowerCase().includes('natural')) {
                botMessage.text = "We have a comprehensive range of organic products certified for organic farming. These include natural fertilizers, biopesticides, and plant stimulants. What specific organic solution are you looking for?";
            }
            else {
                botMessage.text = "Thank you for your query about '" + query + "'. Could you provide more details about your crop type, growing conditions, and specific requirements? This will help me recommend the most appropriate products for your needs.";
            }

            this.messages.push(botMessage);
            this.isLoading = false;

            // Scroll to bottom of chat
            this.$nextTick(() => {
                const chatbox = document.getElementById('chatbox');
                chatbox.scrollTop = chatbox.scrollHeight;
            });
        },

        editMessage(message) {
            this.editingMessage = message;
            this.editedMessageText = message.text;
        },

        cancelEdit() {
            this.editingMessage = null;
            this.editedMessageText = '';
        },

        saveEditedMessage() {
            if (!this.editedMessageText.trim()) return;

            // Update the message text
            this.editingMessage.text = this.editedMessageText.trim();

            // Clear editing state
            this.editingMessage = null;
            this.editedMessageText = '';

            // Regenerate bot response
            const lastUserMessage = this.messages.findIndex(msg => msg.id === this.editingMessage.id);
            if (lastUserMessage !== -1) {
                // Remove all messages after the edited one
                this.messages = this.messages.slice(0, lastUserMessage + 1);
                this.isLoading = true;

                // Regenerate bot response
                setTimeout(() => {
                    this.generateBotResponse(this.messages[lastUserMessage].text);
                }, 1000);
            }
        },

        closeRecommendations() {
            this.showRecommendations = false;
        },

        addToCart(product) {
            // Check if product already exists in cart
            const existingItem = this.cartItems.find(item => item.id === product.id);

            if (existingItem) {
                // Increment quantity if product already in cart
                existingItem.quantity += 1;
            } else {
                // Add new item to cart
                this.cartItems.push({
                    ...product,
                    quantity: 1
                });
            }

            // Show confirmation
            this.closeRecommendations();

            // Add bot message confirming addition to cart
            this.messages.push({
                id: Date.now(),
                sender: 'bot',
                text: `I've added ${product.name} to your cart. Would you like to view your cart or continue shopping?`,
                timestamp: new Date()
            });
        },

        updateCartItemQuantity(index, change) {
            const newQuantity = this.cartItems[index].quantity + change;
            if (newQuantity > 0) {
                this.cartItems[index].quantity = newQuantity;
            }
        },

        removeCartItem(index) {
            this.cartItems.splice(index, 1);
        },

        submitOrder() {
            // Basic form validation
            if (!this.checkoutForm.name || !this.checkoutForm.email || !this.checkoutForm.address) {
                alert('Please fill in required fields');
                return;
            }

            this.isProcessingOrder = true;

            // Simulate order processing
            setTimeout(() => {
                this.isProcessingOrder = false;
                this.showCheckout = false;
                this.showOrderConfirmation = true;
                this.orderNumber = Math.floor(10000 + Math.random() * 90000);
            }, 2000);
        },

        finishOrder() {
            this.showOrderConfirmation = false;
            this.cartItems = [];

            // Add confirmation message to chat
            this.messages.push({
                id: Date.now(),
                sender: 'bot',
                text: `Thank you for your order #${this.orderNumber}! Your items will be shipped within 2-3 business days. Is there anything else I can help you with?`,
                timestamp: new Date()
            });
        },

        init() {
            // Add welcome message on initialization
            setTimeout(() => {
                this.messages.push({
                    id: Date.now(),
                    sender: 'bot',
                    text: "Hello! I'm your Agrochemical Products Assistant. How can I help you today? You can ask about fertilizers, pesticides, herbicides, or upload an image of your crop for a more specific recommendation.",
                    timestamp: new Date()
                });
            }, 500);
        }
    };
}

document.addEventListener('DOMContentLoaded', function () {
    chatbot().init();
});
</script>
</x-app-layout>
