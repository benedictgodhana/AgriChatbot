
<!-- Product Display Component -->
<div class="product-showcase mt-6 bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Featured Products</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="border rounded-lg overflow-hidden hover:shadow-md transition">
                <div class="h-48 bg-gray-100 flex items-center justify-center">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    @endif
                </div>
                <div class="p-4">
                    <h4 class="font-medium text-gray-900">{{ $product->name }}</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ $product->description }}</p>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</span>
                        <button @click="addToCart({
                                id: {{ $product->id }},
                                name: '{{ $product->name }}',
                                description: '{{ $product->description }}',
                                price: {{ $product->price }}
                            })"
                            class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3z" />
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
