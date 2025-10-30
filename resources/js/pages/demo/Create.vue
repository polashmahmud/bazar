<script setup lang="ts">
</script>

<template>
    <div class="p-4">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-md mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="index.html" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h1 class="text-xl font-bold text-gray-800">নতুন বাজার লিস্ট</h1>
                </div>
                <button class="text-green-600 font-medium text-sm">সংরক্ষণ</button>
            </div>
        </header>

        <main class="max-w-md mx-auto px-4 py-6 pb-24">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text" placeholder="পণ্য খুঁজুন বা বলুন..."
                        class="w-full bg-white border border-gray-300 rounded-xl py-3 pl-12 pr-12 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <button
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-green-500 hover:bg-green-600 p-2 rounded-lg transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Quick Categories -->
            <div class="mb-6">
                <div class="flex space-x-2 overflow-x-auto pb-2">
                    <button
                        class="flex items-center space-x-2 bg-green-100 text-green-700 px-4 py-2 rounded-full whitespace-nowrap font-medium text-sm">
                        <span>🥬</span>
                        <span>সবজি</span>
                    </button>
                    <button
                        class="flex items-center space-x-2 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-full whitespace-nowrap hover:bg-gray-50 font-medium text-sm">
                        <span>🐟</span>
                        <span>মাছ</span>
                    </button>
                    <button
                        class="flex items-center space-x-2 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-full whitespace-nowrap hover:bg-gray-50 font-medium text-sm">
                        <span>🥩</span>
                        <span>মাংস</span>
                    </button>
                    <button
                        class="flex items-center space-x-2 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-full whitespace-nowrap hover:bg-gray-50 font-medium text-sm">
                        <span>🛒</span>
                        <span>মুদি</span>
                    </button>
                    <button
                        class="flex items-center space-x-2 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-full whitespace-nowrap hover:bg-gray-50 font-medium text-sm">
                        <span>🌶️</span>
                        <span>মসলা</span>
                    </button>
                </div>
            </div>

            <!-- AI Suggestions Section -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center space-x-2">
                        <span>🤖</span>
                        <span>আপনার জন্য সাজেশন</span>
                    </h2>
                    <button class="text-green-600 text-sm font-medium">আরো</button>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <!-- Suggestion Card 1 -->
                    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-start justify-between mb-2">
                            <span class="text-2xl">🥔</span>
                            <button
                                class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                                <span class="text-lg leading-none">+</span>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1">আলু</h3>
                        <p class="text-xs text-gray-500 mb-2">শেষবার: ৫ দিন আগে</p>
                        <p class="text-sm text-gray-600">২ কেজি</p>
                    </div>

                    <!-- Suggestion Card 2 -->
                    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-start justify-between mb-2">
                            <span class="text-2xl">🧅</span>
                            <button
                                class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                                <span class="text-lg leading-none">+</span>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1">পেঁয়াজ</h3>
                        <p class="text-xs text-gray-500 mb-2">শেষবার: ৩ দিন আগে</p>
                        <p class="text-sm text-gray-600">১ কেজি</p>
                    </div>

                    <!-- Suggestion Card 3 -->
                    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-start justify-between mb-2">
                            <span class="text-2xl">🍅</span>
                            <button
                                class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                                <span class="text-lg leading-none">+</span>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1">টমেটো</h3>
                        <p class="text-xs text-gray-500 mb-2">শেষবার: ১ সপ্তাহ আগে</p>
                        <p class="text-sm text-gray-600">১ কেজি</p>
                    </div>

                    <!-- Suggestion Card 4 -->
                    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                        <div class="flex items-start justify-between mb-2">
                            <span class="text-2xl">🌶️</span>
                            <button
                                class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                                <span class="text-lg leading-none">+</span>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1">কাঁচা মরিচ</h3>
                        <p class="text-xs text-gray-500 mb-2">শেষবার: ৪ দিন আগে</p>
                        <p class="text-sm text-gray-600">১০০ গ্রাম</p>
                    </div>
                </div>
            </div>

            <!-- Frequently Bought -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">প্রায়ই কেনা হয়</h2>

                <div class="space-y-2">
                    <!-- Item 1 -->
                    <div class="bg-white rounded-xl p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🍚</span>
                            <div>
                                <h3 class="font-semibold text-gray-800">চাল</h3>
                                <p class="text-sm text-gray-500">৫ কেজি</p>
                            </div>
                        </div>
                        <button
                            class="w-8 h-8 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                            <span class="text-xl leading-none">+</span>
                        </button>
                    </div>

                    <!-- Item 2 -->
                    <div class="bg-white rounded-xl p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🥛</span>
                            <div>
                                <h3 class="font-semibold text-gray-800">দুধ</h3>
                                <p class="text-sm text-gray-500">২ লিটার</p>
                            </div>
                        </div>
                        <button
                            class="w-8 h-8 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                            <span class="text-xl leading-none">+</span>
                        </button>
                    </div>

                    <!-- Item 3 -->
                    <div class="bg-white rounded-xl p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🐟</span>
                            <div>
                                <h3 class="font-semibold text-gray-800">রুই মাছ</h3>
                                <p class="text-sm text-gray-500">১ কেজি</p>
                            </div>
                        </div>
                        <button
                            class="w-8 h-8 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                            <span class="text-xl leading-none">+</span>
                        </button>
                    </div>

                    <!-- Item 4 -->
                    <div class="bg-white rounded-xl p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🥚</span>
                            <div>
                                <h3 class="font-semibold text-gray-800">ডিম</h3>
                                <p class="text-sm text-gray-500">১২টি</p>
                            </div>
                        </div>
                        <button
                            class="w-8 h-8 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition">
                            <span class="text-xl leading-none">+</span>
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Floating Action Button -->
        <button
            class="fixed bottom-20 right-6 w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 rounded-full shadow-lg flex items-center justify-center text-white text-2xl z-40">
            +
        </button>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50">
            <div class="max-w-md mx-auto px-4">
                <div class="flex items-center justify-around py-2">
                    <a href="index.html" class="flex flex-col items-center py-2 px-3 text-gray-600">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="text-xs font-medium">হোম</span>
                    </a>
                    <a href="create-list.html" class="flex flex-col items-center py-2 px-3 text-green-600">
                        <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">লিস্ট</span>
                    </a>
                    <a href="history.html" class="flex flex-col items-center py-2 px-3 text-gray-600">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-xs font-medium">হিস্টরি</span>
                    </a>
                    <a href="settings.html" class="flex flex-col items-center py-2 px-3 text-gray-600">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-xs font-medium">সেটিংস</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</template>