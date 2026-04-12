    <el-dialog>
        <dialog id="dialog_new_{{ $user['uid'] }}" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
            <el-dialog-backdrop class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

            <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h1 class="text-2xl pl-5 font-bold">Create User</h1>
                        {{-- start --}}
                            <div class="flex min-h-full flex-col justify-center px-6 lg:px-8 pb-10">
                                <form action="{{ route("edituser") }}" method="POST" class="space-y-6">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mt-2">
                                        <label for="uid" class="block text-sm/6 font-medium text-gray-900">uid (device serial)</label>
                                        <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                            <input id="uid" type="text" name="uid" placeholder="device serial" class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" value="{{ $user['uid'] }}" />
                                        </div>
                                        
                                        @error('uid')
                                            <p class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mt-2">
                                        <label for="userid" class="block text-sm/6 font-medium text-gray-900">User Id</label>
                                        <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                            <input id="userid" type="text" name="userid" placeholder="User Name" class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" value="{{ $user['userid'] }}" />
                                        </div>
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-2">
                                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
                                        <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                            <input id="name" type="text" name="name" placeholder="Name" class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" value="{{ $user['name'] }}" />
                                        </div>
                                        
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-2">
                                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                                        <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                            <input id="password" type="text" name="password" placeholder="Password" class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" value="{{ $user['password'] }}" />
                                        </div>
                                        
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-2">
                                        <label for="cardno" class="block text-sm/6 font-medium text-gray-900">Card No</label>
                                        <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                            <input id="cardno" type="text" name="cardno" placeholder="Card No" class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" value="{{ $user['cardno'] }}" />
                                        </div>
                                        
                                        @error('cardno')
                                            <p class="mt-2 text-sm text-red-600" role="alert">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <button type="submit" class="cursor-pointer flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Submit</button>
                                    </div>
                                </form>
                            </div>

                        {{-- end --}}
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>