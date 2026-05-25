<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <Link href="/" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">&larr; Back to Products</Link>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                    <img 
                        :src="product.image || '/images/placeholder.svg'" 
                        :alt="product.name"
                        class="w-full h-96 object-cover rounded-lg"
                    />
                    
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ product.name }}</h1>
                        <p class="text-2xl font-bold text-indigo-600 mb-4">₦{{ Number(product.price).toLocaleString() }}</p>
                        <p class="text-gray-600 mb-6">{{ product.description }}</p>
                        
                        <div class="mb-6">
                            <span class="text-gray-700 font-medium">Stock: </span>
                            <span :class="product.stock > 0 ? 'text-green-600' : 'text-red-600'">
                                {{ product.stock > 0 ? product.stock + ' available' : 'Out of Stock' }}
                            </span>
                        </div>

                        <form @submit.prevent="addToCart">
                            <button 
                                type="submit"
                                :disabled="product.stock <= 0"
                                :class="[
                                    'w-full py-3 px-6 rounded-md font-semibold text-white',
                                    product.stock > 0 ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-400 cursor-not-allowed'
                                ]"
                            >
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    product: Object
});

function addToCart() {
    router.post(`/cart/add/${props.product.id}`);
}
</script>
