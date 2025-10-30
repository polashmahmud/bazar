<script setup lang="ts">
</script>

<template>
    <div class="p-4">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-md mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center">
                        <span class="text-white text-xl">🛒</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">স্মার্ট বাজার</h1>
                </div>
                <button class="relative p-2 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>
        </header>

        <main class="max-w-md mx-auto px-4 py-6 pb-24">
            <!-- AI Suggestion Card -->
            <div
                class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-5 mb-6 border border-green-200 shadow-sm">
                <div class="flex items-start space-x-3">
                    <div
                        class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0 animate-pulse">
                        <span class="text-2xl">🤖</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 mb-2">AI সাজেশন</h3>
                        <p class="text-gray-700 text-sm mb-3">আলু ও পেঁয়াজ শেষ হয়ে যাচ্ছে! লিস্টে যোগ করবেন?</p>
                        <div class="flex space-x-2">
                            <button
                                class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium text-sm transition">
                                যোগ করুন
                            </button>
                            <button
                                class="px-4 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg font-medium text-sm transition">
                                পরে
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="text-orange-500 text-2xl mb-1">💰</div>
                    <div class="text-gray-500 text-xs mb-1">আজকের বাজেট</div>
                    <div class="text-gray-800 font-bold text-lg">৳৮০০</div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="text-green-500 text-2xl mb-1">📦</div>
                    <div class="text-gray-500 text-xs mb-1">আইটেম</div>
                    <div class="text-gray-800 font-bold text-lg">১২টি</div>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="text-blue-500 text-2xl mb-1">📅</div>
                    <div class="text-gray-500 text-xs mb-1">শেষবার</div>
                    <div class="text-gray-800 font-bold text-sm">২ দিন আগে</div>
                </div>
            </div>

            <!-- New List Button -->
            <button
                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-4 rounded-xl font-semibold text-lg shadow-lg shadow-green-500/30 mb-6 flex items-center justify-center space-x-2 transition">
                <span class="text-2xl">+</span>
                <span>নতুন লিস্ট তৈরি করুন</span>
            </button>

            <!-- Recent Lists -->
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">সাম্প্রতিক লিস্ট</h2>
            </div>

            <!-- List Card 1 -->
            <div class="bg-white rounded-xl p-4 mb-3 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 mb-1">শুক্রবারের বাজার</h3>
                        <p class="text-sm text-gray-500">২৮ অক্টোবর, ২০২৫</p>
                    </div>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">সম্পন্ন</span>
                </div>
                <div class="flex items-center justify-between text-sm mb-3">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">📦 ১৫টি পণ্য</span>
                        <span class="text-gray-600">💰 ৳১,২৫০</span>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <span class="text-xs text-green-600 font-medium">৳১৫০ সাশ্রয় হয়েছে</span>
                    <button class="text-green-600 text-sm font-medium hover:underline">বিস্তারিত →</button>
                </div>
            </div>

            <!-- List Card 2 -->
            <div class="bg-white rounded-xl p-4 mb-3 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 mb-1">মাসিক মুদি</h3>
                        <p class="text-sm text-gray-500">২৫ অক্টোবর, ২০২৫</p>
                    </div>
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-medium">চলমান</span>
                </div>
                <div class="flex items-center justify-between text-sm mb-3">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">📦 ৮/১২টি পণ্য</span>
                        <span class="text-gray-600">💰 ৳৮৫০/১,৫০০</span>
                    </div>
                </div>
                <div class="pt-3 border-t border-gray-100">
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: 67%"></div>
                    </div>
                    <button class="text-orange-600 text-sm font-medium hover:underline">বাজার চালিয়ে যান →</button>
                </div>
            </div>

            <!-- List Card 3 -->
            <div class="bg-white rounded-xl p-4 mb-3 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 mb-1">সাপ্তাহিক সবজি</h3>
                        <p class="text-sm text-gray-500">২২ অক্টোবর, ২০২৫</p>
                    </div>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">সম্পন্ন</span>
                </div>
                <div class="flex items-center justify-between text-sm mb-3">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">📦 ১০টি পণ্য</span>
                        <span class="text-gray-600">💰 ৳৬৫০</span>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <span class="text-xs text-green-600 font-medium">৳৮০ সাশ্রয় হয়েছে</span>
                    <button class="text-green-600 text-sm font-medium hover:underline">বিস্তারিত →</button>
                </div>
            </div>
        </main>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50">
            <div class="max-w-md mx-auto px-4">
                <div class="flex items-center justify-around py-2">
                    <a href="index.html" class="flex flex-col items-center py-2 px-3 text-green-600">
                        <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <span class="text-xs font-medium">হোম</span>
                    </a>
                    <a href="create-list.html" class="flex flex-col items-center py-2 px-3 text-gray-600">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
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