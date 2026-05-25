<template>
    <AppLayout>
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
                <p class="text-gray-600 mb-6">Thank you for your purchase. Your order has been received.</p>

                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <h2 class="text-lg font-semibold mb-4">Order Details</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Number:</span>
                            <span class="font-medium">#{{ order.id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-medium">{{ new Date(order.created_at).toLocaleDateString() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="font-medium text-indigo-600">₦{{ Number(order.total).toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium capitalize">{{ order.status }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>
                    <div class="space-y-1 text-gray-600">
                        <p>{{ order.first_name }} {{ order.last_name }}</p>
                        <p>{{ order.address }}</p>
                        <p>{{ order.city }}, {{ order.state }} {{ order.zip }}</p>
                        <p>{{ order.email }}</p>
                        <p>{{ order.phone }}</p>
                    </div>
                </div>

                <Link href="/" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Continue Shopping
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    order: Object
});
</script>
