<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

            <div v-if="cart && Object.keys(cart).length > 0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(item, productId) in cart" :key="productId">
                                <td class="px-6 py-4 whitespace-nowrap">{{ item.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ item.price.toFixed(2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="number" 
                                        :value="item.quantity" 
                                        min="1"
                                        @change="updateQuantity(productId, $event.target.value)"
                                        class="w-20 border border-gray-300 rounded-md px-2 py-1"
                                    />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ (item.price * item.quantity).toFixed(2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        @click="removeItem(productId)"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xl font-semibold">Total:</span>
                        <span class="text-2xl font-bold text-indigo-600">${{ total }}</span>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button 
                            @click="clearCart"
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                        >
                            Clear Cart
                        </button>
                        <Link 
                            href="/checkout"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                        >
                            Proceed to Checkout
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white rounded-lg shadow-md p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-gray-500">Start shopping to add items to your cart.</p>
                <div class="mt-6">
                    <Link href="/" class="text-indigo-600 hover:text-indigo-800 font-medium">Continue Shopping &rarr;</Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    cart: Object,
    total: String
});

function updateQuantity(productId, quantity) {
    router.patch(`/cart/update/${productId}`, { quantity: parseInt(quantity) });
}

function removeItem(productId) {
    router.delete(`/cart/remove/${productId}`);
}

function clearCart() {
    router.delete('/cart/clear');
}
</script>
