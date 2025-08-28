<!-- Hamburger Button (shown when sidebar is closed) -->
<button
    x-data="{ sidebarOpen: false }"
    @click="sidebarOpen = !sidebarOpen; $dispatch('toggle-sidebar')"
    x-show="!sidebarOpen"
    @sidebar-opened.window="sidebarOpen = true"
    @sidebar-closed.window="sidebarOpen = false"
    class="fixed top-4 left-4 z-50 p-2 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors"
>
    <flux:icon.bars-3 class="h-6 w-6 text-gray-600 dark:text-gray-300" />
</button>

<!-- Sidebar -->
<div
    x-data="{
        open: false,
        toggle() {
            this.open = !this.open;
            this.$dispatch(this.open ? 'sidebar-opened' : 'sidebar-closed');
        }
    }"
    @toggle-sidebar.window="toggle()"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform -translate-x-full"
    x-transition:enter-end="transform translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="transform translate-x-0"
    x-transition:leave-end="transform -translate-x-full"
    class="w-64 h-screen flex flex-col border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 z-40 fixed top-0 left-0 shadow-xl"
>
    <!-- Close Button -->
    <button @click="toggle()" class="self-end p-4 focus:outline-none hover:cursor-pointer">
        <flux:icon.x-mark class="h-6 w-6 text-gray-600 dark:text-gray-300" />
    </button>

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-6 py-4" wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" class="w-10 h-10">
                <rect x="2" y="2" width="36" height="36" rx="8" fill="#2563eb"/>
                <text x="50%" y="54%" text-anchor="middle" fill="white" font-size="18" font-family="Arial, Helvetica, sans-serif" font-weight="bold" dy=".3em">KB</text>
            </svg>
            <span class="font-bold text-blue-700 text-sm">Knowledge Base</span>
        </a>

        <!-- Navigation with Flux Icons -->
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="text-sm flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 text-gray-900 dark:text-white" wire:navigate>
                <flux:icon.home class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                <span class="text-sm">Dashboard</span>
            </a>
            <a href="{{ route('search') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 text-gray-900 dark:text-white" wire:navigate>
                <flux:icon.magnifying-glass class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                <span class="text-sm">Search</span>
            </a>
            @can('canCreate')
            <a href="{{ route('article.create') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 text-gray-900 dark:text-white">
                <flux:icon.plus class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                <span class="text-sm">Create</span>
            </a>
            @endcan
            @can('canCreate')
            <a href="{{ route('sections.index') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 text-gray-900 dark:text-white" wire:navigate>
                <flux:icon.archive-box class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                <span class="text-sm">Sections</span>
            </a>
            @endcan
            @can('isAdmin')
            <a href="{{ route('admin') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 text-gray-900 dark:text-white" wire:navigate>
                <flux:icon.cog-6-tooth class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                <span class="text-sm">Admin</span>
            </a>
            @endcan
            @can('canCreate')
            <a href="{{ route('drafts') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 text-gray-900 dark:text-white" wire:navigate>
                <flux:icon.document-text class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                <span class="text-sm">My Drafts</span>
            </a>
            @endcan
            <a href="{{ route('stats') }}" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900 text-gray-900 dark:text-white">
                <flux:icon.chart-bar class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" />
                <span class="text-sm">Stats</span>
            </a>
        </nav>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <!-- User Profile Dropdown -->
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
            <div x-data="{ show: false }" class="relative">
                <button @click="show = !show" class="hover:cursor-pointer flex items-center w-full text-left focus:outline-none">
                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg bg-neutral-200 hover:bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white items-center justify-center">
                        {{ auth()->user()->initials() }}
                    </span>
                    <span class="ml-3 flex-1">
                        <span class="block font-semibold text-sm">{{ auth()->user()->name }}</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</span>
                    </span>
                    <flux:icon.chevron-down class="w-4 h-4 ml-2 text-gray-400" />
                </button>
                <div x-show="show" @click.away="show = false" class="absolute left-0 bottom-full mb-2 w-48 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 z-50">
                    <a href="{{ route('settings.profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-900">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-900">Log Out</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Credit Text -->
        <div class="text-xs text-zinc-500 dark:text-zinc-400 text-center px-4 py-2 mt-2">
            Designed and coded by Kevin Wilson 2025
        </div>
    </div>
</div>

<!-- Backdrop - Makes main content opaque -->
<div
    x-data="{ sidebarOpen: false }"
    @sidebar-opened.window="sidebarOpen = true"
    @sidebar-closed.window="sidebarOpen = false"
    x-show="sidebarOpen"
    @click="$dispatch('toggle-sidebar')"
    x-transition:enter="transition-opacity ease-linear duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-white/50 dark:bg-black/30 z-30"
></div>
