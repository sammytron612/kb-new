<x-layouts.app.main>
    <div class="bg-gray-50 dark:bg-zinc-900 py-8 sm:py-12 overflow-x-hidden">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 overflow-x-hidden">
            <!-- Page Header & Actions -->
            <div class="mb-6">
                <!-- Mobile: Centered Header -->
                <div class="text-center mb-4 md:hidden pt-16 sm:pt-0">
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Article Details</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Review the content, attachments, and feedback.</p>
                </div>

                <!-- Desktop: Header and Buttons Side by Side -->
                <div class="hidden md:flex md:items-center md:justify-center mb-4">
                    <div class="text-center">
                        <h1 class="textlg md:text-3xl font-bold text-zinc-900 dark:text-white mt-4">Article Details</h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Review the content, attachments, and feedback.</p>
                    </div>
                </div>

                <!-- Mobile: Centered Action Buttons -->
                <div class="flex items-center justify-center gap-2 flex-wrap md:hidden">
                    @can('canEdit', $article)
                        <a href="{{ route('article.edit', $article->id) }}" class="inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                            <svg class="w-4 h-4 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span class="hidden sm:inline">Edit</span>
                        </a>
                    @endcan
                    <button onclick="window.print()" class="inline-flex items-center justify-center px-3 py-2 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-200 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span class="hidden sm:inline">Print</span>
                    </button>
                    @can('canDelete', $article)
                        <div x-data>
                            <form id="delete-form-{{ $article->id }}" action="{{ route('article.destroy', $article->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button @click="if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) { document.getElementById('delete-form-{{ $article->id }}').submit(); }"
                                    class="inline-flex items-center justify-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium shadow-sm">
                                <svg class="w-4 h-4 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span class="hidden sm:inline">Delete</span>
                            </button>
                        </div>
                    @endcan
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 sm:p-8 overflow-x-hidden min-w-0">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-extrabold text-zinc-900 dark:text-white mb-4 break-words">{{ $article->title }}</h2>
                        <!-- Action Buttons for Desktop -->
                        <div class="hidden md:flex items-center gap-2 flex-shrink-0">
                            @can('canEdit', $article)
                                <a href="{{ route('article.edit', $article->id) }}" class="inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    <span>Edit</span>
                                </a>
                            @endcan
                            <button onclick="window.print()" class="inline-flex items-center justify-center px-3 py-2 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-200 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors text-sm font-medium shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                <span>Print</span>
                            </button>
                            @can('canDelete', $article)
                                <div x-data>
                                    <form id="delete-form-{{ $article->id }}" action="{{ route('article.destroy', $article->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button @click="if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) { document.getElementById('delete-form-{{ $article->id }}').submit(); }"
                                            class="inline-flex items-center justify-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium shadow-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 text-sm border-t border-b border-zinc-200 dark:border-zinc-700 py-4 mb-6 overflow-x-hidden">
                        <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-300 min-w-0">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="font-medium truncate">{{ $article->author_name }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-300 min-w-0">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-medium">{{ $article->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-300 min-w-0">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span class="font-medium">{{ number_format($article->views) }} views</span>
                        </div>
                        <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-300 min-w-0">
                            <span class="uppercase inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $article->kb }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 text-zinc-600 dark:text-zinc-300 min-w-0">
                            @if($article->rating)
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 flex-shrink-0 {{ $i <= round($article->rating) ? 'text-yellow-400' : 'text-zinc-300 dark:text-zinc-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            @else
                                <span class="text-xs font-medium">No rating yet</span>
                            @endif
                        </div>
                    </div>

                    <!-- Attachments Section -->
                    @if(!empty($article->attachments) && count($article->attachments) > 0)
                        <div class="mb-8 overflow-x-hidden">
                            <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 mb-3">Attachments</h3>
                            <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($article->attachments as $attachment)
                                        @php
                                            $filename = basename($attachment);
                                            $filesize = file_exists(storage_path('app/public/' . $attachment)) ? round(filesize(storage_path('app/public/' . $attachment)) / 1024, 1) . ' KB' : '';
                                        @endphp
                                        <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="flex items-center p-3 border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors duration-200 group">
                                            <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate group-hover:text-blue-500">{{ $filename }}</p>
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $filesize }}</p>
                                            </div>
                                            <svg class="w-5 h-5 text-zinc-400 group-hover:text-blue-500 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    @endforeach
                                </div>
                                @if(count($article->attachments) > 1)
                                    <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                        <a href="{{ route('attachment.download', $article) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download All
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Article Body -->
                    <div class="overflow-x-hidden min-w-0">
                        <div class="prose prose-zinc dark:prose-invert max-w-none prose-sm sm:prose-base overflow-x-hidden">
                            <div style="word-wrap: break-word; overflow-wrap: anywhere; word-break: break-word; hyphens: auto; max-width: 100%;">
                                {!! $article->body->body !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Section for Feedback and Comments -->
                <div class="bg-zinc-50 dark:bg-zinc-900/50 px-6 sm:px-8 py-6 border-t border-zinc-200 dark:border-zinc-700 overflow-x-hidden">
                    <div class="space-y-8">
                        @if($article->scope)
                            <livewire:email-article :article="$article" />
                        @endif
                        <livewire:article-feedback :article="$article" />
                        <livewire:article-latest-comments :article="$article" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.main>
