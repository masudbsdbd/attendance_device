<div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10">
    <table class="w-full table-fixed">
        <thead>
            <tr class="bg-gray-100">
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">uid</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">User Id (custom)</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">User Name</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">State</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">type</th>
                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Date</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($attendanceRecords as $attendance)
                <tr>
                    <td class="py-4 px-6 border-b border-gray-200">
                            {{ $attendance['uid'] }}
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200 truncate">
                        {{ $attendance['id'] }}
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200 truncate">
                        {{getName($attendance['id'])}}
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200">
                        {{ $attendance['state'] }}
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200">
                        {{ $attendance['type'] }}
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200">
                        {{ dateTimeConverter($attendance['timestamp']) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>