<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                <form @submit.prevent="searchProducts" class="flex w-full sm:w-auto">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search products..."
                        class="border border-gray-300 rounded-l-md px-4 py-2 w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700">
                        Search
                    </button>
                </form>
            </div>

            <div v-if="products.data.length === 0" class="text-center py-12 text-gray-500">
                No products found.
            </div>

            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <div v-for="product in products.data" :key="product.id" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <img 
                        :src="product.image || '/images/placeholder.svg'" 
                        :alt="product.name"
                        class="w-full h-48 object-cover"
                    />
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ product.name }}</h2>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ product.description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-indigo-600">${{ product.price }}</span>
                            <Link 
                                :href="`/products/${product.id}`"
                                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium"
                            >
                                View Details
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="products.last_page > 1" class="mt-8 flex justify-center">
                <nav class="flex space-x-2">
                    <Link 
                        v-for="(link, index) in products.links" 
                        :key="index"
                        :href="link.url"
                        :class="[
                            'px-4 py-2 rounded-md',
                            link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100',
                            !link.url ? 'opacity-50 cursor-not-allowed' : ''
                        ]"
                        v-html="link.label"
                    />
                </nav>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    products: Object,
    filters: Object
});

const searchQuery = ref(props.filters?.search || '');

function searchProducts() {
    router.get('/products', { search: searchQuery.value }, {
        preserveState: true,
        replace: true
    });
}
</script>
