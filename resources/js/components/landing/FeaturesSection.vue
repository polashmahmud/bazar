<template>
    <section id="features" class="bg-white py-12 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center sm:mb-16">
                <h2 class="mb-4 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">Powerful Features</h2>
                <p class="mx-auto max-w-2xl text-lg text-gray-600 sm:text-xl">Discover what makes Bazar the perfect choice for your shopping needs</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="rounded-xl bg-gradient-to-br from-indigo-50 to-cyan-50 p-6 transition-shadow duration-300 hover:shadow-lg sm:p-8">
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-600">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900">Smart Cart Management</h3>
                    <p class="text-gray-600">Easily add, update, and track your shopping items with our intelligent cart system.</p>
                </div>

                <!-- Feature 2 -->
                <div class="rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 p-6 transition-shadow duration-300 hover:shadow-lg sm:p-8">
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-green-600">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900">Secure PIN Login</h3>
                    <p class="text-gray-600">Quick and secure access with our 4-digit PIN authentication system.</p>
                </div>

                <!-- Feature 3 -->
                <div class="rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 p-6 transition-shadow duration-300 hover:shadow-lg sm:p-8">
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-purple-600">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900">Purchase History</h3>
                    <p class="text-gray-600">Track and analyze your shopping patterns with detailed purchase history.</p>
                </div>

                <!-- Feature 4 -->
                <div class="rounded-xl bg-gradient-to-br from-yellow-50 to-orange-50 p-6 transition-shadow duration-300 hover:shadow-lg sm:p-8">
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-600">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900">Lightning Fast</h3>
                    <p class="text-gray-600">Experience blazing fast performance with our optimized interface and PWA support.</p>
                </div>

                <!-- Feature 5 -->
                <div class="rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 p-6 transition-shadow duration-300 hover:shadow-lg sm:p-8">
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-600">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900">Mobile Optimized</h3>
                    <p class="text-gray-600">Fully responsive design that works perfectly on all your devices.</p>
                </div>

                <!-- Feature 6 -->
                <div class="rounded-xl bg-gradient-to-br from-red-50 to-pink-50 p-6 transition-shadow duration-300 hover:shadow-lg sm:p-8">
                    <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-red-600">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-gray-900">User Friendly</h3>
                    <p class="text-gray-600">Intuitive interface designed with user experience as the top priority.</p>
                </div>
            </div>
        </div>
    </section>
</template>
