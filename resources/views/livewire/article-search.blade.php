<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Knowledge Base Search</h1>
        <p class="text-gray-600 dark:text-gray-300">Find the information you need quickly and efficiently</p>
    </div>

    <!-- Search Section -->
    <div class="mb-8">
        <div class="relative max-w-2xl mx-auto">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text"
                   wire:model.live.debounce.300ms="search"
                   placeholder="Search articles, topics, or keywords..."
                   class="w-full pl-12 pr-4 py-4 text-lg border border-gray-300 dark:border-zinc-600 rounded-xl shadow-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white bg-white transition-all duration-200 hover:shadow-xl placeholder:text-sm md:placeholder:text-lg   placeholder:text-center" />
            @if($search)
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                    <button wire:click="$set('search', '')" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
        @if($search)
            <div class="text-center mt-4">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Searching for: <span class="font-semibold text-blue-600 dark:text-blue-400">"{{ $search }}"</span>
                </span>
            </div>
        @endif
    </div>

    <!-- Results Section -->
    @if($articles)
        <div class="grid gap-6 lg:gap-8">
            @forelse ($articles as $article)
                <div class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 shadow-lg hover:shadow-xl rounded-xl p-4 sm:p-6 transition-all duration-300 group">
                    <!-- Article Header -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 space-y-4 sm:space-y-0">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('article.show', $article->id) }}"
                               class="sm:text-md md:text-lg font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 group-hover:text-blue-600">
                                {{ $article->title }}
                            </a>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 uppercase">
                                    {{ $article->kb ?? $article->id }}
                                </span>
                                @if($article->status === 'published')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        Published
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 sm:ml-4 flex-shrink-0">
                            <a href="{{ route('article.show', $article->id) }}"
                               class="inline-flex items-center px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-200 text-xs sm:text-sm font-medium">
                                <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span class="hidden sm:inline">View</span>
                            </a>
                            @can('canEdit', $article)
                                <a href="{{ route('article.edit', $article->id) }}"
                                   class="inline-flex items-center px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200 text-xs sm:text-sm font-medium">
                                    <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    <span class="hidden sm:inline">Edit</span>
                                </a>
                            @endcan
                            @can('canDelete', $article)
                                <form action="{{ route('article.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-200 text-xs sm:text-sm font-medium">
                                        <svg class="w-4 h-4 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        <span class="hidden sm:inline">Delete</span>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <!-- Article Excerpt -->
                    @php $body = Str::limit(strip_tags($article->body->body ?? ''), 150); @endphp
                    <div class="mb-4 hidden md:block my-4">
                        <div class="text-xs font-bold text-gray-500 dark:text-gray-400">Article excerpt:</div>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm">
                            {!! $body !!}....
                        </p>
                    </div>

                    <!-- Article Metadata -->
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-100 dark:border-zinc-700">
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white truncate">{{ $article->author_name }}</span>
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </div>
                            <span class="font-medium">{{ number_format($article->views ?? 0) }} views</span>
                        </div>

                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <span class="font-medium">{{ $article->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            @if(($article->rating ?? 0) > 0)
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4" fill="{{ $i <= $article->rating ? '#FFD700' : 'none' }}" stroke="{{ $i <= $article->rating ? '#FFD700' : '#d1d5db' }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                                    @endfor
                                    <span class="ml-1 text-sm font-medium text-gray-900 dark:text-white">{{ $article->rating }}/5</span>
                                </div>
                            @else
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                                    <span class="text-sm text-gray-400">Not rated</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-zinc-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.514.835-6.318 2.291l-.982-.982A7.962 7.962 0 016 12h.01c0-.348.014-.694.041-1.036A8.001 8.001 0 1119.96 10.964c.027.342.041.688.041 1.036H20a7.963 7.963 0 01.318 4.291l-.982.982z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No articles found</h3>
                    @if($search)
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            We couldn't find any articles matching "<span class="font-semibold">{{ $search }}</span>"
                        </p>
                        <button wire:click="$set('search', '')"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Clear search
                        </button>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">
                            Try adjusting your search terms or browse all available articles.
                        </p>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="mt-12 flex justify-center">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-gray-200 dark:border-zinc-700 p-2">
                    {{ $articles->links() }}
                </div>
            </div>
        @endif
    @endif
</div>
