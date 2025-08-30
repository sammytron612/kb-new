<div class="container mx-auto py-8 px-4 md:px-8">
    <!-- Alert Messages -->
    @if (session()->has('success'))
        <div class="mb-6 border border-green-400 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 border border-red-400 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header Section -->
    <div class="text-center mb-4">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
        </div>
    </div>
    <div class="flex items-center justify-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">User Management</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage user roles and account status</p>
            <div class="font-semibold text-center mt-4 md:mt-0 text-sm text-gray-500 dark:text-gray-400">
                Total Users: {{ $users->total() }}
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-gray-200 dark:border-zinc-700 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Users</label>
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search by name or email..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Role Filter -->
            <div>
                <label for="role-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Role</label>
                <select wire:model.live="selectedRole"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Roles</option>
                    <option value="1">Admin</option>
                    <option value="2">Editor</option>
                    <option value="3">Viewer</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Status</label>
                <select wire:model.live="selectedStatus"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Disabled</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-gray-200 dark:border-zinc-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-zinc-700">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <button wire:click="sortBy('name')"
                                    class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hover:text-gray-700 dark:hover:text-gray-100">
                                User
                                @if($sortBy === 'name')
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <button wire:click="sortBy('role')"
                                    class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hover:text-gray-700 dark:hover:text-gray-100">
                                Role
                                @if($sortBy === 'role')
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left">
                            <button wire:click="sortBy('created_at')"
                                    class="flex items-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hover:text-gray-700 dark:hover:text-gray-100">
                                Joined
                                @if($sortBy === 'created_at')
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="ml-2 text-xs text-blue-600 dark:text-blue-400">(You)</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $this->roleColors[$user->role] }}">
                                    {{ $this->roleName[$user->role] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->id !== auth()->id())
                                    <button wire:click="toggleStatus({{ $user->id }})"
                                            class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" {{ $user->status ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    </button>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $this->statusColors[$user->status ? 1 : 0] }}">
                                        {{ $user->status ? 'Active' : 'Disabled' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    @if($user->id !== auth()->id())
                                        <button wire:click="editUser({{ $user->id }})"
                                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition">
                                            Edit
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Current User</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No users found</p>
                                    <p class="text-sm">Try adjusting your search or filter criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Edit User Modal -->
    @if($showEditModal && $editingUser)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeEditModal">
            <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 w-full max-w-md mx-4" wire:click.stop>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Edit User</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">User Information</label>
                        <div class="bg-gray-50 dark:bg-zinc-700 p-3 rounded-md">
                            <div class="font-medium text-gray-900 dark:text-white">{{ $editingUser->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $editingUser->email }}</div>
                        </div>
                    </div>

                    <div>
                        <label for="editRole" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                        <select wire:model.live="editRole"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            <option value="1">Admin</option>
                            <option value="2">Editor</option>
                            <option value="3">Viewer</option>
                        </select>
                        @error('editRole') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="editStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select wire:model.live="editStatus"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            <option value="1">Active</option>
                            <option value="0">Disabled</option>
                        </select>
                        @error('editStatus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="closeEditModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-500">
                        Cancel
                    </button>
                    <button wire:click="updateUser"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Update User
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
