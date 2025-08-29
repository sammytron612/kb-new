<x-layouts.app.external>
<div class="container mx-auto py-8">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white ml-6">View article</h1>
    </div>
    <div class="bg-gradient-to-br from-white via-slate-100 to-slate-200 dark:from-zinc-800 dark:via-zinc-900 dark:to-zinc-800 rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 mb-2">{{ $article->title }}</h2>
        <hr class="mb-4">
        <div class="flex flex-wrap items-center text-sm text-zinc-500 dark:text-zinc-400 mb-4 gap-4">
            <span class="flex items-center gap-1"><flux:icon.user /><span class="font-semibold text-lg">{{ $article->author_name }}</span></span>
            <span class="flex items-center gap-1 font-bold">Views <span class="font-semibold">{{ $article->views }}</span></span>
            <span class="flex items-center gap-1"><flux:icon.calendar /></i> <span class="font-semibold">{{ $article->created_at->diffForHumans() }}</span></span>
            <span class="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded text-xs font-semibold uppercase">{{ $article->kb }}</span>
            <span class="font-semibold">Rating</span>
            <span class="text-yellow-500">
                @for ($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= round($article->rating) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 inline">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.75l-6.172 3.245 1.179-6.88L2 9.755l6.904-1.002L12 2.25l3.096 6.503L22 9.755l-5.007 4.36 1.179 6.88z" />
                    </svg>
                @endfor
            </span>
        </div>
        <div class="mb-4 flex items-center justify-between">
            <div><span class="font-semibold">Section</span> - <a href="#" class="text-blue-500 underline font-semibold">{{ $article->section ? $article->section->section : '' }}</a></div>
        </div>

        <!-- Attachments Section -->
        @if(!empty($article->attachments) && count($article->attachments) > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-200 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    Attachments ({{ count($article->attachments) }})
                </h3>
                <div class="bg-white dark:bg-zinc-900 rounded-lg border border-slate-300 dark:border-zinc-600 p-4 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($article->attachments as $attachment)
                            @php
                                $filename = basename($attachment);
                                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                $filesize = '';

                                // Try to get file size
                                $fullPath = storage_path('app/public/' . $attachment);
                                if (file_exists($fullPath)) {
                                    $bytes = filesize($fullPath);
                                    $filesize = $bytes >= 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 1) . ' KB';
                                }

                                // Get appropriate icon based on file extension
                                $icon = match($extension) {
                                    'pdf' => '📄',
                                    'doc', 'docx' => '📝',
                                    'xls', 'xlsx' => '📊',
                                    'ppt', 'pptx' => '📋',
                                    'txt' => '📃',
                                    'zip', 'rar', '7z' => '🗜️',
                                    'jpg', 'jpeg', 'png', 'gif', 'bmp' => '🖼️',
                                    'mp4', 'avi', 'mov', 'wmv' => '🎥',
                                    'mp3', 'wav', 'wma' => '🎵',
                                    default => '📎'
                                };
                            @endphp

                            <a href="{{ asset('storage/' . $attachment) }}"
                               target="_blank"
                               class="flex items-center p-3 border border-gray-200 dark:border-zinc-600 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors duration-200 group">
                                <!-- File Icon -->
                                <span class="text-2xl mr-3 flex-shrink-0">{{ $icon }}</span>

                                <!-- File Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ $filename }}
                                    </p>
                                    @if($filesize)
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $filesize }}</p>
                                    @endif
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 uppercase">{{ $extension }}</p>
                                </div>

                                <!-- Download Icon -->
                                <svg class="w-4 h-4 text-zinc-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="w-full border p-6 rounded-lg border-slate-300 bg-white dark:bg-zinc-900 prose dark:prose-invert max-w-none mb-6 shadow-sm">
            {!! $article->body->body !!}
        </div>

    </div>
</div>
</x-layouts.app.external>
