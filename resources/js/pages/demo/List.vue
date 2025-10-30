<script setup lang="ts">
</script>

<template>
    <div class="p-4">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-md mx-auto px-4 py-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <a href="index.html" class="p-2 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">মাসিক মুদি</h1>
                            <p class="text-sm text-gray-500">২৫ অক্টোবর, ২০২৫</p>
                        </div>
                    </div>
                    <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Budget Tracker -->
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl p-4 border border-orange-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-700 font-medium">বাজেট ট্র্যাকার</span>
                        <span class="text-sm font-semibold text-gray-800">৳৮৫০ / ৳১,৫০০</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-orange-400 to-orange-500 h-3 rounded-full flex items-center justify-end pr-1"
                            style="width: 57%">
                            <span class="text-xs text-white font-bold">৫৭%</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">আরো ৳৬৫০ খরচ করতে পারবেন</p>
                </div>
            </div>
        </header>

        <main class="max-w-md mx-auto px-4 py-6 pb-24">
            <!-- Progress Stats -->
            <div class="flex items-center justify-between mb-6 bg-white rounded-xl p-4 shadow-sm">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">৮</div>
                    <div class="text-xs text-gray-500">কেনা হয়েছে</div>
                </div>
                <div class="w-px h-12 bg-gray-200"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">৪</div>
                    <div class="text-xs text-gray-500">বাকি আছে</div>
                </div>
                <div class="w-px h-12 bg-gray-200"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">১২</div>
                    <div class="text-xs text-gray-500">মোট আইটেম</div>
                </div>
            </div>

            <!-- সবজি Category -->
            <div class="mb-6">
                <button class="w-full flex items-center justify-between bg-white rounded-t-xl px-4 py-3 shadow-sm">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">🥬</span>
                        <h2 class="text-lg font-semibold text-gray-800">সবজি</h2>
                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium">৫টি</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div class="bg-white rounded-b-xl shadow-sm divide-y divide-gray-100">
                    <!-- Item 1 - Checked -->
                    <div class="item-card p-4 bg-green-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">আলু</h3>
                                <p class="text-sm text-gray-500">২ কেজি</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳৮০</div>
                                <div class="font-semibold text-green-600">প্রকৃত: ৳৭০</div>
                                <div class="text-xs text-green-600 font-medium mt-1">৳১০ সাশ্রয়</div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 - Unchecked -->
                    <div class="item-card p-4">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox"
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">পেঁয়াজ</h3>
                                <p class="text-sm text-gray-500">১ কেজি</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">আনুমানিক: ৳৬০</div>
                                <input type="text" placeholder="প্রকৃত দাম"
                                    class="w-20 text-right border border-gray-300 rounded px-2 py-1 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-green-500">
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 - Checked with warning -->
                    <div class="item-card p-4 bg-orange-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">টমেটো</h3>
                                <p class="text-sm text-gray-500">১ কেজি</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳৪০</div>
                                <div class="font-semibold text-orange-600">প্রকৃত: ৳৬০</div>
                                <div class="text-xs text-orange-600 font-medium mt-1">৳২০ বেশি</div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 4 - Checked -->
                    <div class="item-card p-4 bg-green-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">কাঁচা মরিচ</h3>
                                <p class="text-sm text-gray-500">১০০ গ্রাম</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳২০</div>
                                <div class="font-semibold text-green-600">প্রকৃত: ৳২০</div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 5 - With comparison badge -->
                    <div class="item-card p-4">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox"
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">শসা</h3>
                                <p class="text-sm text-gray-500">৫০০ গ্রাম</p>
                                <span
                                    class="inline-block bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-medium mt-1">
                                    গতবার ৳৫ সস্তা
                                </span>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">আনুমানিক: ৳৩০</div>
                                <input type="text" placeholder="প্রকৃত দাম"
                                    class="w-20 text-right border border-gray-300 rounded px-2 py-1 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-green-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- মাছ Category -->
            <div class="mb-6">
                <button class="w-full flex items-center justify-between bg-white rounded-t-xl px-4 py-3 shadow-sm">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">🐟</span>
                        <h2 class="text-lg font-semibold text-gray-800">মাছ</h2>
                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium">৩টি</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div class="bg-white rounded-b-xl shadow-sm divide-y divide-gray-100">
                    <!-- Fish Item 1 -->
                    <div class="item-card p-4 bg-green-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">রুই মাছ</h3>
                                <p class="text-sm text-gray-500">১ কেজি</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳৩৫০</div>
                                <div class="font-semibold text-green-600">প্রকৃত: ৳৩২০</div>
                                <div class="text-xs text-green-600 font-medium mt-1">৳৩০ সাশ্রয়</div>
                            </div>
                        </div>
                    </div>

                    <!-- Fish Item 2 -->
                    <div class="item-card p-4">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox"
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">ইলিশ মাছ</h3>
                                <p class="text-sm text-gray-500">৫০০ গ্রাম</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">আনুমানিক: ৳৮০০</div>
                                <input type="text" placeholder="প্রকৃত দাম"
                                    class="w-20 text-right border border-gray-300 rounded px-2 py-1 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-green-500">
                            </div>
                        </div>
                    </div>

                    <!-- Fish Item 3 -->
                    <div class="item-card p-4 bg-green-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">চিংড়ি</h3>
                                <p class="text-sm text-gray-500">২৫০ গ্রাম</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳২৫০</div>
                                <div class="font-semibold text-green-600">প্রকৃত: ৳২৪০</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- মুদি Category -->
            <div class="mb-6">
                <button class="w-full flex items-center justify-between bg-white rounded-t-xl px-4 py-3 shadow-sm">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">🛒</span>
                        <h2 class="text-lg font-semibold text-gray-800">মুদি</h2>
                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium">৪টি</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div class="bg-white rounded-b-xl shadow-sm divide-y divide-gray-100">
                    <!-- Grocery Item 1 -->
                    <div class="item-card p-4 bg-green-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">চাল</h3>
                                <p class="text-sm text-gray-500">৫ কেজি</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳৩০০</div>
                                <div class="font-semibold text-green-600">প্রকৃত: ৳২৮০</div>
                                <div class="text-xs text-green-600 font-medium mt-1">৳২০ সাশ্রয়</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grocery Item 2 -->
                    <div class="item-card p-4 bg-green-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">ডাল</h3>
                                <p class="text-sm text-gray-500">১ কেজি</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳১২০</div>
                                <div class="font-semibold text-green-600">প্রকৃত: ৳১২০</div>
                            </div>
                        </div>
                    </div>

                    <!-- Grocery Item 3 -->
                    <div class="item-card p-4">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox"
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">তেল</h3>
                                <p class="text-sm text-gray-500">১ লিটার</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">আনুমানিক: ৳১৮০</div>
                                <input type="text" placeholder="প্রকৃত দাম"
                                    class="w-20 text-right border border-gray-300 rounded px-2 py-1 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-green-500">
                            </div>
                        </div>
                    </div>

                    <!-- Grocery Item 4 -->
                    <div class="item-card p-4 bg-green-50">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" checked
                                class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 line-through">লবণ</h3>
                                <p class="text-sm text-gray-500">১ কেজি</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400 line-through">আনুমানিক: ৳৩০</div>
                                <div class="font-semibold text-green-600">প্রকৃত: ৳২৮</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Floating Action Button for AI Suggestions -->
        <button
            class="fixed bottom-20 right-6 w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 rounded-full shadow-lg flex items-center justify-center text-white text-2xl z-40 animate-pulse">
            🤖
        </button>

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