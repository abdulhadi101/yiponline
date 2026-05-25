<template>
    <AppLayout>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <Link href="/orders" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">&larr; Back to My Orders</Link>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-900">Order #{{ order.id }}</h1>
                        <span :class="[
                            'px-3 py-1 rounded-full text-sm font-medium capitalize',
                            order.status === 'completed' ? 'bg-green-100 text-green-800' :
                            order.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                            order.status === 'shipped' ? 'bg-purple-100 text-purple-800' :
                            order.status === 'processing' ? 'bg-blue-100 text-blue-800' :
                            'bg-yellow-100 text-yellow-800'
                        ]">
                            {{ order.status }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">{{ new Date(order.created_at).toLocaleDateString() }}</p>
                </div>

                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold mb-4">Items</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-500 text-sm">
                                <th class="pb-2">Product</th>
                                <th class="pb-2">Qty</th>
                                <th class="pb-2 text-right">Price</th>
                                <th class="pb-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in order.items" :key="item.id" class="border-t">
                                <td class="py-3">{{ item.product_name }}</td>
                                <td class="py-3">{{ item.quantity }}</td>
                                <td class="py-3 text-right">₦{{ Number(item.price).toLocaleString() }}</td>
                                <td class="py-3 text-right font-medium">₦{{ Number(item.price * item.quantity).toLocaleString() }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-t font-bold">
                                <td colspan="3" class="py-3 text-right">Total:</td>
                                <td class="py-3 text-right">₦{{ Number(order.total).toLocaleString() }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>
                    <div class="text-gray-600 space-y-1">
                        <p>{{ order.first_name }} {{ order.last_name }}</p>
                        <p>{{ order.address }}</p>
                        <p>{{ order.city }}, {{ order.state }} {{ order.zip }}</p>
                        <p>{{ order.email }}</p>
                        <p>{{ order.phone }}</p>
                    </div>
                </div>
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
