<x-layouts.app.main :title="__('Sections Management')">
   <div class="container mx-auto py-8 px-4">
    <!-- Header Section -->

    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white mb-3">Sections Management</h1>
        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Organize your knowledge base with hierarchical sections</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sections Tree -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-gray-200 dark:border-zinc-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V5a2 2 0 012-2h14a2 2 0 012 2v2"></path>
                        </svg>
                        All Sections
                    </h3>
                    <p class="text-blue-100 text-sm mt-1">Click to expand sections and select a parent</p>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <div class="space-y-3">
                        @foreach($sections->where('parent', 0) as $rootSection)
                            <div class="section-item">
                                <div class="flex items-center p-3 rounded-lg transition-all duration-200 {{ $sections->where('parent', $rootSection->id)->count() > 0 ? 'cursor-pointer hover:bg-blue-50 dark:hover:bg-zinc-700' : 'hover:bg-gray-50 dark:hover:bg-zinc-700' }}"
                                     @if($sections->where('parent', $rootSection->id)->count() > 0) onclick="toggleSection({{ $rootSection->id }})" @endif>
                                    @if($sections->where('parent', $rootSection->id)->count() > 0)
                                        <span class="expand-icon mr-3 text-blue-500 transition-transform duration-200" id="icon-{{ $rootSection->id }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="mr-7"></span>
                                    @endif
                                    <input type="checkbox" name="selected_sections[]" value="{{ $rootSection->id }}" class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="clearOtherCheckboxes(this)" data-section-id="{{ $rootSection->id }}" data-section-name="{{ $rootSection->section }}" data-depth="0">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $rootSection->section }}</span>
                                </div>

                                @if($sections->where('parent', $rootSection->id)->count() > 0)
                                    <div class="children ml-10 hidden transition-all duration-300" id="children-{{ $rootSection->id }}">
                                        @foreach($sections->where('parent', $rootSection->id) as $childSection)
                                            <div class="section-item mt-2">
                                                <div class="flex items-center p-2 rounded-lg border-l-4 border-blue-200 pl-4 transition-all duration-200 {{ $sections->where('parent', $childSection->id)->count() > 0 ? 'cursor-pointer hover:bg-blue-50 dark:hover:bg-zinc-700' : 'hover:bg-gray-50 dark:hover:bg-zinc-700' }}"
                                                     @if($sections->where('parent', $childSection->id)->count() > 0) onclick="toggleSection({{ $childSection->id }})" @endif>
                                                    @if($sections->where('parent', $childSection->id)->count() > 0)
                                                        <span class="expand-icon mr-3 text-blue-400" id="icon-{{ $childSection->id }}">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </span>
                                                    @else
                                                        <span class="mr-7"></span>
                                                    @endif
                                                    <input type="checkbox" name="selected_sections[]" value="{{ $childSection->id }}" class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="clearOtherCheckboxes(this)" data-section-id="{{ $childSection->id }}" data-section-name="{{ $childSection->section }}" data-depth="1">
                                                    <span class="text-gray-800 dark:text-gray-200">{{ $childSection->section }}</span>
                                                </div>

                                                @if($sections->where('parent', $childSection->id)->count() > 0)
                                                    <div class="children ml-8 hidden transition-all duration-300" id="children-{{ $childSection->id }}">
                                                        @foreach($sections->where('parent', $childSection->id) as $grandChildSection)
                                                            <div class="section-item mt-2">
                                                                <div class="flex items-center p-2 rounded-lg border-l-4 border-green-200 pl-6 ml-4 transition-all duration-200 {{ $sections->where('parent', $grandChildSection->id)->count() > 0 ? 'cursor-pointer hover:bg-green-50 dark:hover:bg-zinc-700' : 'hover:bg-gray-50 dark:hover:bg-zinc-700' }}"
                                                                     @if($sections->where('parent', $grandChildSection->id)->count() > 0) onclick="toggleSection({{ $grandChildSection->id }})" @endif>
                                                                    @if($sections->where('parent', $grandChildSection->id)->count() > 0)
                                                                        <span class="expand-icon mr-3 text-green-500" id="icon-{{ $grandChildSection->id }}">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                            </svg>
                                                                        </span>
                                                                    @else
                                                                        <span class="mr-7"></span>
                                                                    @endif
                                                                    <input type="checkbox" name="selected_sections[]" value="{{ $grandChildSection->id }}" class="mr-3 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" onchange="clearOtherCheckboxes(this)" data-section-id="{{ $grandChildSection->id }}" data-section-name="{{ $grandChildSection->section }}" data-depth="2">
                                                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $grandChildSection->section }}</span>
                                                                </div>

                                                                @if($sections->where('parent', $grandChildSection->id)->count() > 0)
                                                                    <div class="children ml-8 hidden transition-all duration-300" id="children-{{ $grandChildSection->id }}">
                                                                        @foreach($sections->where('parent', $grandChildSection->id) as $greatGrandChildSection)
                                                                            <div class="flex items-center p-2 rounded-lg border-l-4 border-yellow-200 pl-8 ml-6 bg-yellow-50 dark:bg-zinc-700">
                                                                                <span class="mr-7"></span>
                                                                                <input type="checkbox" name="selected_sections[]" value="{{ $greatGrandChildSection->id }}" class="mr-3 h-4 w-4 cursor-not-allowed opacity-50" disabled data-section-id="{{ $greatGrandChildSection->id }}" data-section-name="{{ $greatGrandChildSection->section }}" data-depth="3" title="Maximum depth reached - cannot add children to this level">
                                                                                <span class="text-xs text-yellow-700 dark:text-yellow-300 flex items-center">
                                                                                    {{ $greatGrandChildSection->section }}
                                                                                    <span class="ml-2 px-2 py-1 bg-yellow-200 dark:bg-yellow-600 text-yellow-800 dark:text-yellow-200 rounded-full text-xs font-medium">Max depth</span>
                                                                                </span>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Section Form -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-gray-200 dark:border-zinc-700 overflow-hidden sticky top-8">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Section
                    </h2>
                    <p class="text-green-100 text-sm mt-1">Create a new section or subsection</p>
                </div>

                <div class="p-6">
                    <!-- Error Message -->
                    <div id="error-message" class="mb-4 p-3 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg shadow hidden flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
                        </svg>
                        <span></span>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg shadow flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg shadow flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('sections.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="parent_id" id="parent_id" value="0">
                        <input type="hidden" name="depth" id="depth" value="0">

                        <div>
                            <label for="parent" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Parent Section
                            </label>
                            <div class="relative">
                                <input type="text" name="parent" id="parent"
                                       class="text-xs w-full px-4 py-3 bg-gray-50 dark:bg-zinc-700 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent dark:text-white"
                                       value="{{ old('parent') }}"
                                       placeholder="Select a parent section from the tree"
                                       readonly>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10l-5 8-5-8z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty to create a root section</p>
                        </div>

                        <div>
                            <label for="section" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Section Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="section" id="section"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-700 dark:text-white"
                                   value="{{ old('section') }}"
                                   placeholder="Enter section name..."
                                   required>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.02] flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Section
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSection(sectionId) {
    const children = document.getElementById('children-' + sectionId);
    const icon = document.getElementById('icon-' + sectionId);

    if (children.classList.contains('hidden')) {
        children.classList.remove('hidden');
        icon.style.transform = 'rotate(90deg)';
    } else {
        children.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

function showError(message) {
    const errorDiv = document.getElementById('error-message');
    const messageSpan = errorDiv.querySelector('span');
    messageSpan.textContent = message;
    errorDiv.classList.remove('hidden');

    // Hide error after 5 seconds
    setTimeout(() => {
        errorDiv.classList.add('hidden');
    }, 5000);
}

function clearOtherCheckboxes(currentCheckbox) {
    if (currentCheckbox.checked) {
        const depth = parseInt(currentCheckbox.getAttribute('data-depth'));

        // Check if depth is 3 (great grandchild level)
        if (depth >= 3) {
            currentCheckbox.checked = false;
            showError('Cannot create sections deeper than 4 levels. Great grandchildren are the maximum depth allowed.');
            return;
        }

        // Get all checkboxes with the same name
        const allCheckboxes = document.querySelectorAll('input[name="selected_sections[]"]');

        // Uncheck all other checkboxes
        allCheckboxes.forEach(function(checkbox) {
            if (checkbox !== currentCheckbox) {
                checkbox.checked = false;
            }
        });

        // Set the parent input field value to the selected section name
        const parentInput = document.getElementById('parent');
        const sectionName = currentCheckbox.getAttribute('data-section-name');
        parentInput.value = sectionName;

        // Set the hidden parent_id field to the selected section ID
        const parentIdInput = document.getElementById('parent_id');
        const sectionId = currentCheckbox.getAttribute('data-section-id');
        parentIdInput.value = sectionId;

        // Set the depth field to track hierarchy level
        const depthInput = document.getElementById('depth');
        depthInput.value = depth;
    } else {
        // If checkbox is unchecked, revert to defaults
        const parentInput = document.getElementById('parent');
        const parentIdInput = document.getElementById('parent_id');
        const depthInput = document.getElementById('depth');

        parentInput.value = '';
        parentIdInput.value = '0';
        depthInput.value = '0';
    }
}
</script>
</x-layouts.app>
