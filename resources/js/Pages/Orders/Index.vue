<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

            <div v-if="orders.data.length === 0" class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-500">You haven't placed any orders yet.</p>
                <Link href="/" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">Start Shopping</Link>
            </div>

            <div v-else class="space-y-4">
                <div v-for="order in orders.data" :key="order.id"
                    class="bg-white rounded-lg shadow-md p-6 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Order #{{ order.id }}</p>
                        <p class="text-lg font-semibold">₦{{ Number(order.total).toLocaleString() }}</p>
                        <p class="text-sm text-gray-500">{{ new Date(order.created_at).toLocaleDateString() }}</p>
                    </div>
                    <div class="text-right">
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
                        <Link :href="`/orders/${order.id}`"
                            class="block mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            View Details
                        </Link>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="orders.last_page > 1" class="mt-8 flex justify-center">
                    <nav class="flex space-x-2">
                        <template v-for="(link, index) in orders.links" :key="index">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                :class="[
                                    'px-4 py-2 rounded-md',
                                    link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'
                                ]"
                                v-html="link.label"
                            />
                            <span
                                v-else
                                class="px-4 py-2 rounded-md bg-white text-gray-400 opacity-50 cursor-not-allowed"
                                v-html="link.label"
                            />
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    orders: Object
});
</script>
