<x-layouts.app.main :title="__('Site Statistics')">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 relative">
        <!-- Subtle Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-30">
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-green-100 dark:bg-green-900/20 rounded-full blur-2xl"></div>
        </div>

        <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Subtle Header Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>

                <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-3">
                    Site Statistics
                </h1>

                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Comprehensive analytics and insights into your Knowledge Base performance
                </p>
            </div>

            <!-- Subtle Stats Cards -->
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

                <!-- Most Viewed Article Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            @if($mostViewedArticle)
                                <div class="text-sm font-medium text-gray-900 dark:text-white truncate text-wrap">
                                    {{ $mostViewedArticle->title }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ number_format($mostViewedArticle->views) }} views
                                </div>
                            @else
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    No articles yet
                                </div>
                            @endif
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Most Popular</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Articles Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
                <!-- Simple Header -->
                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Top Performance</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Most viewed articles and analytics</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Top Articles List -->
                        <div class="space-y-4">
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-4">Top 5 Articles</h3>

                            @forelse ($topArticles as $index => $article)
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 flex-1 min-w-0">
                                            <!-- Ranking Badge -->
                                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center font-medium text-white text-sm
                                                {{ $index === 0 ? 'bg-yellow-500' : '' }}
                                                {{ $index === 1 ? 'bg-gray-400' : '' }}
                                                {{ $index === 2 ? 'bg-orange-500' : '' }}
                                                {{ $index > 2 ? 'bg-blue-500' : '' }}">
                                                {{ $index + 1 }}
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $article->title }}
                                                </h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    by {{ $article->author_name ?? 'Unknown Author' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="text-right ml-4">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ number_format($article->views) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                views
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-900 dark:text-white mb-2">No articles yet</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Start creating content to see analytics here</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Chart Section -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-4">View Analytics</h3>

                            <div class="relative h-64">
                                @if(count($topArticles) > 0)
                                    <canvas id="mostViewedChart" class="w-full h-full"></canvas>
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <div class="text-center">
                                            <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">No data to display</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Average Views -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $totalArticles > 0 ? number_format(round($totalViews / $totalArticles)) : '0' }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Avg Views per Article</div>
                        </div>
                    </div>
                </div>

                <!-- Published Articles -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-50 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ number_format(\App\Models\Article::where('approved', 1)->count()) }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Published Articles</div>
                        </div>
                    </div>
                </div>

                <!-- Engagement Rate -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pink-50 dark:bg-pink-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $totalArticles > 0 ? number_format(($totalViews / $totalArticles) * 100 / 100, 1) : '0' }}%
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Engagement Score</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('mostViewedChart');
            if (ctx && {{ count($topArticles) > 0 ? 'true' : 'false' }}) {
                const chartData = {
                    labels: [
                        @foreach($topArticles as $article)
                            '{{ Str::limit($article->title, 20) }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Views',
                        data: [
                            @foreach($topArticles as $article)
                                {{ $article->views }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(245, 101, 101, 0.7)',
                            'rgba(139, 92, 246, 0.7)',
                            'rgba(249, 115, 22, 0.7)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 101, 101, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(249, 115, 22, 1)'
                        ],
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    usePointStyle: true,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                cornerRadius: 8,
                                padding: 10,
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.parsed.toLocaleString() + ' views';
                                    }
                                }
                            }
                        },
                        cutout: '60%'
                    }
                });
            }
        });
    </script>
</x-layouts.app>
