@if($cartItems->count() > 0)
    <div class="space-y-4">
        @foreach($cartItems as $item)
            <div class="flex items-center space-x-3 p-3 border-b border-gray-200 last:border-b-0">
                <img src="{{ $item->product->primary_image_url }}" 
                     alt="{{ $item->product->name }}" 
                     class="w-12 h-12 object-cover rounded">
                
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-medium text-gray-900 truncate">
                        {{ $item->product->name }}
                    </h4>
                    <p class="text-xs text-gray-500">
                        Qty: {{ $item->quantity }} × ${{ $item->price }}
                    </p>
                </div>
                
                <div class="text-sm font-medium text-gray-900">
                    ${{ number_format($item->total_price, 2) }}
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex justify-between text-sm">
            <span class="text-gray-600">Subtotal</span>
            <span class="font-medium">${{ number_format($cartItems->sum('total_price'), 2) }}</span>
        </div>
    </div>
@else
    <div class="text-center py-8 text-gray-500">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13l2.5 5"></path>
        </svg>
        <p class="text-sm">Your cart is empty</p>
    </div>
@endif