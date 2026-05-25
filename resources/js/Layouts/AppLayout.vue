<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link href="/" class="text-2xl font-bold text-indigo-600">YipOnline</Link>
                        <div class="hidden md:flex ml-10 space-x-8">
                            <Link href="/" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Products</Link>
                            <a href="/smarty/products" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Smarty Demo</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link href="/cart" class="relative text-gray-700 hover:text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ cartCount }}</span>
                        </Link>
                        <template v-if="$page.props.auth.user">
                            <Link href="/orders" class="text-gray-700 hover:text-indigo-600">My Orders</Link>
                            <Link href="/admin" class="text-gray-700 hover:text-indigo-600">Admin</Link>
                            <Link href="/logout" method="post" as="button" class="text-gray-700 hover:text-indigo-600">Logout</Link>
                        </template>
                        <template v-else>
                            <Link href="/login" class="text-gray-700 hover:text-indigo-600">Login</Link>
                            <Link href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Register</Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        <div v-if="$page.props.flash && ($page.props.flash.success || $page.props.flash.error)" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ $page.props.flash.error }}
            </div>
        </div>

        <!-- Main Content -->
        <main class="py-8">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-12">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <p class="text-center text-gray-500">&copy; 2024 YipOnline. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const cartCount = computed(() => {
    return Number(usePage().props.cartCount) || 0;
});
</script>
