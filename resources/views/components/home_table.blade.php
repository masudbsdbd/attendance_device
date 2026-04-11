<table class="min-w-full border-collapse block md:table">
    <thead class="block md:table-header-group">
        <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">uid</th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">User Id (custom)</th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Name</th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Role</th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Password</th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Card Number</th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Action</th>
        </tr>
    </thead>
    <tbody class="block md:table-row-group">
        @foreach($users as $user)
            @include('components.edit_modal', ['user' => $user])
            <tr class="md:border-none block md:table-row">
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    {{ $user['uid'] }}
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    {{ $user['userid'] }}
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    {{ $user['name'] }}
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    {{ empty($user['role']) ? 'n/a' : $user['role'] }}
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    {{ empty($user['password']) ? 'n/a' : $user['password'] }}
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    {{ $user['cardno'] }}
                </td>
                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
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