<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Order Management</h1>
                <Link href="/management" class="text-indigo-600 hover:text-indigo-800">&larr; Back to Dashboard</Link>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <form @submit.prevent="filterOrders" class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-700">Filter by Status:</label>
                    <select v-model="statusFilter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Orders</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Apply Filter
                    </button>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="order in orders.data" :key="order.id">
                            <td class="px-6 py-4 whitespace-nowrap font-medium">#{{ order.id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ order.first_name }} {{ order.last_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ order.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">₦{{ Number(order.total).toLocaleString() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <select 
                                    :value="order.status"
                                    @change="updateStatus(order.id, $event.target.value)"
                                    :class="[
                                        'px-2 py-1 rounded-md text-sm font-medium capitalize',
                                        getStatusClass(order.status)
                                    ]"
                                >
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button 
                                    @click="viewOrder(order)"
                                    class="text-indigo-600 hover:text-indigo-800 text-sm font-medium"
                                >
                                    View Details
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

        <!-- Order Detail Modal -->
        <div v-if="showModal && selectedOrder" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6 border-b flex justify-between items-center">
                    <h2 class="text-xl font-bold">Order #{{ selectedOrder.id }}</h2>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="font-semibold mb-2">Customer</h3>
                        <p>{{ selectedOrder.first_name }} {{ selectedOrder.last_name }}</p>
                        <p class="text-sm text-gray-600">{{ selectedOrder.email }} | {{ selectedOrder.phone }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Shipping Address</h3>
                        <p class="text-sm text-gray-600">{{ selectedOrder.address }}, {{ selectedOrder.city }}, {{ selectedOrder.state }} {{ selectedOrder.zip }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Order Info</h3>
                        <p class="text-sm text-gray-600">Date: {{ new Date(selectedOrder.created_at).toLocaleDateString() }}</p>
                        <p class="text-sm text-gray-600">Status: <span class="capitalize font-medium">{{ selectedOrder.status }}</span></p>
                        <p class="text-lg font-bold text-indigo-600 mt-1">Total: ₦{{ Number(selectedOrder.total).toLocaleString() }}</p>
                    </div>
                    <div v-if="selectedOrder.items && selectedOrder.items.length">
                        <h3 class="font-semibold mb-2">Items</h3>
                        <div v-for="item in selectedOrder.items" :key="item.id" class="flex justify-between text-sm text-gray-600 py-1">
                            <span>{{ item.product_name }} x {{ item.quantity }}</span>
                            <span>₦{{ Number(item.price * item.quantity).toLocaleString() }}</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 border-t bg-gray-50 flex justify-end">
                    <button @click="closeModal" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Close</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    orders: Object,
    filters: Object
});

const statusFilter = ref(props.filters?.status || '');

function filterOrders() {
    router.get('/management/orders', { status: statusFilter.value });
}

function updateStatus(orderId, status) {
    router.patch(`/management/orders/${orderId}`, { status });
}

const selectedOrder = ref(null);
const showModal = ref(false);

function viewOrder(order) {
    selectedOrder.value = order;
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    selectedOrder.value = null;
}

function getStatusClass(status) {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        processing: 'bg-blue-100 text-blue-800',
        shipped: 'bg-purple-100 text-purple-800',
        completed: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
}
</script>
