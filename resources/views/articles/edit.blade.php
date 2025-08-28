<x-layouts.app.main :title="__('Edit Article')">
    <div class="max-w-6xl mx-auto py-8 px-4">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Edit Article</h1>
            <p class="text-gray-600 dark:text-gray-300">Update your article content and settings</p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-xl shadow-lg flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 space-y-2">
                @foreach ($errors->all() as $error)
                    <div class="p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-xl shadow-lg flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
                        </svg>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Main Form Container -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-gray-200 dark:border-zinc-700 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Article Details
                </h2>
                <p class="text-blue-100 text-sm mt-1">Update the information below to modify your article</p>
            </div>

            <!-- Form Content -->
            <div class="p-4 sm:p-6 lg:p-8">
                <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <!-- Title -->
                        <div class="lg:col-span-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Article Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white transition-all duration-200"
                                   placeholder="Enter a descriptive title for your article..."
                                   required value="{{ old('title', $article->title) }}" />
                            @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Section -->
                        <div>
                            <label for="section" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Section <span class="text-red-500">*</span>
                            </label>
                            <livewire:section-selector
                                name="sectionId"
                                :selected="old('section', $article->sectionId)"
                                :required="true"
                                placeholder="Search or select a section..."
                            />
                            @error('sectionId') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror



                        <!-- Tags -->
                        <div>
                            <label for="tags" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Tags
                            </label>
                            <input type="text" name="tags" id="tags"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white transition-all duration-200"
                                   placeholder="tag1, tag2, tag3..."
                                   value="{{ old('tags', is_array($article->tags) ? implode(',', $article->tags) : $article->tags) }}" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Separate multiple tags with commas</p>
                            @error('tags') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Scope -->
                        <div>
                            <label for="scope" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Visibility <span class="text-red-500">*</span>
                            </label>
                            <select name="scope" id="scope"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white transition-all duration-200">
                                <option value="1" @if(old('scope', $article->scope)==1) selected @endif>
                                    🌍 Public - Visible to everyone
                                </option>
                                <option value="2" @if(old('scope', $article->scope)==2) selected @endif>
                                    🔒 Private - Internal use only
                                </option>
                            </select>
                            <p class="text-xs text-orange-600 dark:text-orange-400 mt-1">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"></path>
                                </svg>
                                Private articles cannot be sent as emails
                            </p>
                            @error('scope') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="published" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="published" id="published"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white transition-all duration-200">
                                <option value="1" @if(old('published', $article->published)==1) selected @endif>
                                    ✅ Published - Make it live
                                </option>
                                <option value="0" @if(old('published', $article->published)==0) selected @endif>
                                    📝 Draft - Save for later
                                </option>
                            </select>
                            @error('published') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Expires -->
                        <div>
                            <label for="expires" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Expiration Date
                            </label>
                            @if($article->expires)
                                <input type="date" name="expires" id="expires"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white transition-all duration-200"
                                       value="{{ old('expires', $article->expires->format('Y-m-d')) }}" />
                            @else
                                <input type="date" name="expires" id="expires"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-700 dark:text-white transition-all duration-200"
                                       value="{{ old('expires') }}" />
                            @endif
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Article will be archived after this date</p>
                            @error('expires') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Existing Attachments -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Current Attachments
                            </label>
                            @if(!empty($article->attachments))
                                <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                                    @foreach($article->attachments as $attachment)
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-zinc-600 last:border-b-0" id="attachment-{{$loop->index}}">
                                            <a href="{{ asset('storage/' . $attachment) }}" target="_blank"
                                               class="text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                {{ basename($attachment) }}
                                            </a>
                                            <livewire:remove-attachment :attachment="$attachment" :articleId="$article->id" :attachmentIndex="$loop->index"/>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-zinc-700 rounded-lg p-4 text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    No attachments found
                                </div>
                            @endif
                        </div>

                        <!-- New Attachments -->
                        <div>
                            <label for="attachments" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Add New Attachments
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg p-4 hover:border-blue-400 transition-colors duration-200">
                                <input type="file" name="attachments[]" id="attachments" multiple
                                       class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300" />
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Support for multiple file uploads</p>
                            </div>
                            @error('attachments') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Article Body -->
                    <div class="space-y-4">
                        <label for="article_body" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Article Content <span class="text-red-500">*</span>
                        </label>
                        <div class="editor-container">
                            <div class="layout-observer"></div>
                            <textarea name="article_body" id="editor"
                                      class="w-full"
                                      placeholder="Start writing your article content here...">{{ old('article_body', $article->body->body) }}</textarea>
                        </div>
                        @error('article_body') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-zinc-700">
                        <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.02] shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Article
                        </button>

                        <a href="{{ route('dashboard') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TinyMCE Scripts -->
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.api_key') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        let tinymceObserver = null;
        let isInitialized = false;

        function initTinyMCE() {
            if (isInitialized) return;

            const isMobile = window.innerWidth <= 768;

            tinymce.init({
                licence_key: '{{ config('services.tinymce.api_key') }}',
                selector: '#editor',
                height: 400,
                width: '100%',
                resize: true,
                plugins: 'autoresize advlist lists link image fullscreen code table media searchreplace paste wordcount',
                toolbar: isMobile ?
                    'undo redo | bold italic | bullist numlist | link' :
                    'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code fullscreen',
                toolbar_mode: 'sliding',
                menubar: false,
                branding: false,
                autoresize_bottom_margin: 50,
                content_style: 'body { font-family: system-ui, sans-serif; font-size: 14px; line-height: 1.6; margin: 1rem; } img { max-width: 100%; height: auto; }',

                setup: function(editor) {
                    editor.on('init', function() {
                        isInitialized = true;
                        console.log('TinyMCE initialized');

                        // Set up resize observer for the editor container
                        if (window.createTinyMCEObserver) {
                            tinymceObserver = window.createTinyMCEObserver();
                            if (tinymceObserver) {
                                const editorContainer = editor.getContainer().closest('.editor-container');
                                if (editorContainer) {
                                    tinymceObserver.observe(editorContainer);
                                }

                                // Also observe the main content area
                                const mainContent = document.querySelector('main') || document.querySelector('.main-content') || document.body;
                                if (mainContent) {
                                    tinymceObserver.observe(mainContent);
                                }
                            }
                        }

                        // Initial sizing
                        setTimeout(() => {
                            const container = editor.getContainer();
                            if (container) {
                                container.style.width = '100%';
                                container.style.maxWidth = '100%';
                            }
                            editor.execCommand('mceRepaint');
                        }, 100);
                    });

                    editor.on('focus', function() {
                        // Ensure proper sizing when editor gains focus
                        setTimeout(() => {
                            if (window.handleTinyMCEResize) {
                                window.handleTinyMCEResize();
                            }
                        }, 50);
                    });
                },

                images_upload_handler: function (blobInfo, success, failure) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route("image.upload") }}');
                    xhr.setRequestHeader("X-CSRF-Token", '{{ csrf_token() }}');

                    xhr.onload = function () {
                        if (xhr.status !== 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }

                        let json;
                        try {
                            json = JSON.parse(xhr.responseText);
                        } catch(e) {
                            failure('Invalid JSON');
                            return;
                        }

                        if (!json.location) {
                            failure('No location in response');
                            return;
                        }

                        success(json.location);
                    };

                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                }
            });
        }

        // Initialize when ready
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initTinyMCE, 100);
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            setTimeout(() => {
                if (window.handleTinyMCEResize) {
                    window.handleTinyMCEResize();
                }
            }, 100);
        });

        // Handle sidebar toggle (if your app uses these events)
        document.addEventListener('sidebar:toggle', function() {
            setTimeout(() => {
                if (window.handleTinyMCEResize) {
                    window.handleTinyMCEResize();
                }
            }, 200);
        });

        // Listen for transition end events (sidebar animations)
        document.addEventListener('transitionend', function(e) {
            if (e.target.matches('.sidebar, [class*="sidebar"], main, [class*="main"]')) {
                setTimeout(() => {
                    if (window.handleTinyMCEResize) {
                        window.handleTinyMCEResize();
                    }
                }, 100);
            }
        });

        // Cleanup
        window.addEventListener('beforeunload', function() {
            if (tinymceObserver) {
                tinymceObserver.disconnect();
            }
        });
    </script>
</x-layouts.app>
