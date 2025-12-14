<x-app-layout>
    {{-- Main Content Wrapper: Added sm:ml-64 to push content right of the sidebar --}}
    <div class="p-4 ">
        <div class="p-4 mt-14">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Alerts Center</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Manage overdue items and high-priority requests. Click a row to notify the assignee.
                    </p>
                </div>
            </div>

            {{-- STATS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Card 1: Overdue -->
                <div class="flex items-center p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-4 rounded-full bg-red-50 text-red-600 dark:bg-red-900/50 dark:text-red-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $overdueRequests->count() }}</h2>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Overdue Requests</p>
                    </div>
                </div>

                <!-- Card 2: High Priority -->
                <div class="flex items-center p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-4 rounded-full bg-orange-50 text-orange-600 dark:bg-orange-900/50 dark:text-orange-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path></svg>
                    </div>
                    <div class="ml-5">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $highPriorityRequests->count() }}</h2>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">High Priority Tasks</p>
                    </div>
                </div>
            </div>

            {{-- TABS NAVIGATION --}}
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="alertTab" data-tabs-toggle="#alertTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg transition-colors duration-200" id="overdue-tab" data-tabs-target="#overdue" type="button" role="tab" aria-controls="overdue" aria-selected="false">Overdue Items</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 transition-colors duration-200" id="priority-tab" data-tabs-target="#priority" type="button" role="tab" aria-controls="priority" aria-selected="false">High Priority</button>
                    </li>
                </ul>
            </div>

            {{-- TABS CONTENT --}}
            <div id="alertTabContent">

                {{-- TAB 1: OVERDUE --}}
                <div class="hidden" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Work Request Title</th>
                                    <th scope="col" class="px-6 py-4">Assigned Employee</th>
                                    <th scope="col" class="px-6 py-4">Due Date</th>
                                    <th scope="col" class="px-6 py-4"><span class="sr-only">Action</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($overdueRequests as $req)
                                    @php $hasAssignee = $req->assignee != null; @endphp
                                    <tr class="bg-white dark:bg-gray-800 transition duration-150 ease-in-out group
                                               {{ $hasAssignee ? 'cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700/50' : 'opacity-60 bg-gray-50 cursor-not-allowed' }}"
                                        @if($hasAssignee)
                                            data-modal-target="message-modal"
                                            data-modal-toggle="message-modal"
                                            onclick="prepareModal('{{ $req->assignee->id }}', '{{ $req->assignee->name }}', '{{ $req->id }}', '{{ $req->title }}')"
                                        @endif
                                    >
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex flex-col">
                                                <span>{{ $req->title }}</span>
                                                <span class="mt-1 w-fit bg-red-100 text-red-700 text-[10px] font-bold uppercase px-2 py-0.5 rounded dark:bg-red-900/30 dark:text-red-400">Late</span>
                                            </div>
                                        </th>
                                        <td class="px-6 py-4">
                                            @if($hasAssignee)
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3 dark:bg-blue-900 dark:text-blue-300">
                                                        {{ substr($req->assignee->name, 0, 1) }}
                                                    </div>
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ $req->assignee->name }}</span>
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                    Unassigned
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-red-600 font-medium">
                                            {{ \Carbon\Carbon::parse($req->due_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($hasAssignee)
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <p>No overdue requests found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB 2: HIGH PRIORITY --}}
                <div class="hidden" id="priority" role="tabpanel" aria-labelledby="priority-tab">
                    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Work Request Title</th>
                                    <th scope="col" class="px-6 py-4">Assigned Employee</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4"><span class="sr-only">Action</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($highPriorityRequests as $req)
                                    @php $hasAssignee = $req->assignee != null; @endphp
                                    <tr class="bg-white dark:bg-gray-800 transition duration-150 ease-in-out group
                                               {{ $hasAssignee ? 'cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700/50' : 'opacity-60 bg-gray-50 cursor-not-allowed' }}"
                                        @if($hasAssignee)
                                            data-modal-target="message-modal"
                                            data-modal-toggle="message-modal"
                                            onclick="prepareModal('{{ $req->assignee->id }}', '{{ $req->assignee->name }}', '{{ $req->id }}', '{{ $req->title }}')"
                                        @endif
                                    >
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex flex-col">
                                                <span>{{ $req->title }}</span>
                                                <span class="mt-1 w-fit bg-orange-100 text-orange-700 text-[10px] font-bold uppercase px-2 py-0.5 rounded dark:bg-orange-900/30 dark:text-orange-400">High Priority</span>
                                            </div>
                                        </th>
                                        <td class="px-6 py-4">
                                            @if($hasAssignee)
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3 dark:bg-blue-900 dark:text-blue-300">
                                                        {{ substr($req->assignee->name, 0, 1) }}
                                                    </div>
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ $req->assignee->name }}</span>
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                    Unassigned
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $req->status == 'Pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' }}">
                                                {{ $req->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($hasAssignee)
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <p>No high priority requests found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{--                MESSAGE MODAL                    --}}
    {{-- =============================================== --}}
    <div id="message-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-xl shadow-2xl dark:bg-gray-800 border dark:border-gray-700">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Notify Employee
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="message-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6">
                    <form class="space-y-5" action="{{ route('admin.notifications.send') }}" method="POST">
                        @csrf
                        {{-- Hidden IDs --}}
                        <input type="hidden" name="user_id" id="modal-user-id">
                        <input type="hidden" name="work_order_id" id="modal-work-order-id">

                        {{-- 1. Context: Recipient --}}
                        <div class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-blue-600 dark:text-blue-300 uppercase">Send Message To</p>
                                <p id="modal-user-name" class="text-sm font-bold text-gray-900 dark:text-white"></p>
                            </div>
                        </div>

                        {{-- 2. Context: Request Title --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Regarding Request</label>
                            <div class="relative">
                                <input type="text" id="modal-work-order-title" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400" disabled readonly>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Message Input --}}
                        <div>
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Admin Message</label>
                            <textarea name="message" id="message" rows="4" class="block p-3 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Write your message here..." required></textarea>
                        </div>

                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 shadow-md">
                            Send Notification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT TO HANDLE DATA POPULATION --}}
    <script>
        function prepareModal(userId, userName, workOrderId, workOrderTitle) {
            // Fill Hidden Inputs
            document.getElementById('modal-user-id').value = userId;
            document.getElementById('modal-work-order-id').value = workOrderId;

            // Fill Visible Fields
            document.getElementById('modal-user-name').innerText = userName;
            document.getElementById('modal-work-order-title').value = workOrderTitle;

            // Clear previous message
            document.getElementById('message').value = '';
        }
    </script>
</x-app-layout>
