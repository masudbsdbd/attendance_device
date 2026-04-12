    <div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10">
        <table class="w-full table-fixed">
            <thead>
                <tr class="bg-gray-100">
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">uid</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">User Id (custom)</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Name</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Role</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Password</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Card Number</th>
                    <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($users as $user)
                    @include('components.edit_modal', ['user' => $user])
                    <tr>
                        <td class="py-4 px-6 border-b border-gray-200">
                             {{ $user['uid'] }}
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200 truncate">
                            {{ $user['userid'] }}
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200">
                            {{ $user['name'] }}
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200">
                            <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">
                                {{ empty($user['role']) ? 'n/a' : $user['role'] }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200">
                            <span class="bg-gray-500 text-white py-1 px-2 rounded-full text-xs">
                                {{ empty($user['password']) ? 'n/a' : $user['password'] }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200">
                            {{ $user['cardno'] }}
                        </td>
                        <td class="py-4 px-6 border-b border-gray-200">
                            <button command="show-modal" commandfor="dialog_new_{{ $user['uid'] }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Edit</button>
                            <form action="/deleteUser/{{ $user['uid'] }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>