<x-layouts.app.main :title="__('Dashboard')">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 relative">
        <!--Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-30">
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-green-100 dark:bg-green-900/20 rounded-full blur-2xl"></div>
        </div>

        <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
            <!--  Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v0M8 11h8m-4 4h4"></path>
                    </svg>
                </div>

                <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-3">
                    Dashboard
                </h1>

                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Overview of your Knowledge Base activity and metrics
                </p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-8">
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700/50 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Total Articles Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ number_format($totalArticles) }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Articles</div>
                        </div>
                    </div>
                </div>

                <!-- Total Views Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-50 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ number_format($totalViews) }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Views</div>
                        </div>
                    </div>
                </div>

                <!-- Top Contributor Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            @if($topAuthor && $topAuthor !== 'No articles yet')
                                <span class="text-sm font-semibold text-purple-600 dark:text-purple-400">{{ substr($topAuthor, 0, 2) }}</span>
                            @else
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                {{ $topAuthor && $topAuthor !== 'No articles yet' ? $topAuthor : 'No contributors' }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Top Contributor</div>
                        </div>
                    </div>
                </div>
            </div>

                   <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-12">
                <!-- Create Article -->
                @can(['canCreate'])
                <a href="{{route('article.create')}}" class="w-full group block">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl shadow-lg hover:shadow-xl p-6 transition-all duration-200 transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white text-lg">Create</div>
                                <div class="text-blue-100 text-sm">New article</div>
                            </div>
                        </div>
                    </div>
                </a>
                @endcan

                <!-- View Statistics -->
                <a href="/stats" class="w-full group block">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 rounded-xl shadow-lg hover:shadow-xl p-6 transition-all duration-200 transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white text-lg">Analytics</div>
                                <div class="text-purple-100 text-sm">View stats</div>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- User Profile -->
                <a href="/settings/profile" class="w-full group block" wire:navigate>
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-lg hover:shadow-xl p-6 transition-all duration-200 transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-white text-lg">Profile</div>
                                <div class="text-orange-100 text-sm">Settings</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Articles List Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Simple Header -->
                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Articles</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Latest content updates</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles List Content -->
                <div class="p-6">
                    <livewire:list-articles />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.main>

