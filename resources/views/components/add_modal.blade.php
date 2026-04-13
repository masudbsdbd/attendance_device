<el-dialog>
    <dialog id="dialog" aria-labelledby="dialog-title" 
            class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
        
        <el-dialog-backdrop class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

        <div tabindex="0" class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <el-dialog-panel class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all 
                                 data-closed:translate-y-8 data-closed:opacity-0 
                                 data-enter:duration-300 data-enter:ease-out 
                                 data-leave:duration-200 data-leave:ease-in 
                                 sm:my-8 sm:w-full sm:max-w-md w-full">

                <!-- Header -->
                    <div class="bg-gradient-to-r from-green-700 to-green-700 px-6 py-5 text-white flex items-center justify-between">
                        <h2 class="text-2xl font-semibold flex items-center gap-3">
                            Create New User
                        </h2>
                        
                        <!-- Cross Button -->
                        <button onclick="this.closest('dialog').close()" 
                                class="cursor-pointer text-white hover:bg-white/20 p-2 rounded-full transition-all focus:outline-none">
                            <i class="fa-solid fa-rectangle-xmark"></i>
                        </button>
                    </div>

                <div class="p-6 sm:p-8">
                    <form action="{{ route("adduser", $current_device_id) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- UID -->
                        <div>
                            <label for="uid" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Device Serial (UID)
                            </label>
                            <div class="relative">
                                <input id="uid" type="text" name="uid" 
                                       placeholder="Enter device serial number"
                                       class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 
                                              focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                            </div>
                            @error('uid')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- User ID -->
                        <div>
                            <label for="userid" class="block text-sm font-medium text-gray-700 mb-1.5">
                                User ID
                            </label>
                            <input id="userid" type="text" name="userid" 
                                   placeholder="Enter username"
                                   class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 
                                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                            @error('userid')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Full Name
                            </label>
                            <input id="name" type="text" name="name" 
                                   placeholder="Enter full name"
                                   class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 
                                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                            @error('name')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Password
                            </label>
                            <input id="password" type="password" name="password" 
                                   placeholder="Enter secure password"
                                   class="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 
                                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- User Role Dropdown -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">
                                User Role
                            </label>
                            <div class="relative">
                                <select id="role" name="role" 
                                        class="block w-full appearance-none rounded-xl border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 
                                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all">
                                    <option value="">Select Role</option>
                                    {{-- <option value="0">Normal User</option>
                                    <option value="14">Super Admin</option>
                                    <option value="4">Hr</option>
                                    <option value="8">Employee</option>
                                    <option value="10">Accounts</option> --}}

                                    @foreach($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('role')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full flex justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-green-600 
                                           px-6 py-3.5 text-base font-semibold text-white shadow-lg hover:from-green-700 hover:to-green-700 
                                           focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-500 
                                           transition-all active:scale-[0.985]">
                                <span>Create User</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M5 12h14" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </el-dialog-panel>
        </div>
    </dialog>
</el-dialog>


<script>
     function closeCreateModal(element) {
        const dialog = element.closest('dialog');
        if (dialog) {
            dialog.close();
        }
    }
</script>