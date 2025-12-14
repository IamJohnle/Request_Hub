<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; -webkit-print-color-adjust: exact; margin: 0; padding: 0; }
            /* Ensure table headers repeat on new pages for long lists */
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }
        }
        /* Hover effect for editable fields (only on screen) */
        .editable-field:hover { background-color: #f3f4f6; cursor: text; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 font-sans p-8 print:p-0">

    <!-- TOOLBAR (Hidden when printing) -->
    <div class="no-print fixed top-0 left-0 w-full bg-gray-800 text-white p-4 shadow-lg z-50 flex justify-between items-center">
        <div>
            <h1 class="font-bold text-lg">
                @if($reports->count() === 1)
                    Single Report Preview
                @else
                    Summary Report Preview
                @endif
            </h1>
            <p class="text-xs text-gray-400">{{ $reports->count() }} record(s) selected</p>
        </div>
        <div class="space-x-4">
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500 text-sm">Back</a>
            <button onclick="window.print()" class="px-6 py-2 bg-blue-600 rounded hover:bg-blue-500 font-bold shadow">
                Print
            </button>
        </div>
    </div>

    <!-- Spacer -->
    <div class="h-20 no-print"></div>

    <!-- MAIN CONTAINER -->
    <div class="max-w-5xl mx-auto bg-white shadow-lg min-h-screen p-8 print:shadow-none print:w-full">

        {{-- LOGIC: Check count to decide layout --}}

        @if($reports->count() === 1)

            {{-- ========================================== --}}
            {{--           LAYOUT A: SINGLE (DETAILED)      --}}
            {{-- ========================================== --}}
            @php $order = $reports->first(); @endphp

            <!-- Header -->
            <div class="flex justify-between items-start border-b-2 border-gray-800 pb-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold uppercase tracking-wide">Work Order Details</h1>
                    <p class="text-gray-500 mt-1">ID: #{{ $order->id }}</p>
                </div>
                <div class="text-right">
                    <h2 class="font-bold text-lg">Company Name</h2>
                    <p class="text-sm text-gray-600">Printed: {{ date('M d, Y') }}</p>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-xs font-bold uppercase text-gray-500 mb-1">Requester Info</h3>
                    <div class="bg-gray-50 p-4 rounded border">
                        <p><strong>Name:</strong> {{ $order->user->name ?? 'Unknown' }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                        <p><strong>Date Requested:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase text-gray-500 mb-1">Assignment Info</h3>
                    <div class="bg-gray-50 p-4 rounded border">
                        <p><strong>Assigned To:</strong> {{ $order->assignee->name ?? 'Unassigned' }}</p>
                        <p><strong>Category:</strong> {{ $order->category ?? 'General' }}</p>
                        <p><strong>Status:</strong> <span class="uppercase font-bold">{{ $order->status }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Full Content -->
            <div class="mb-8">
                <h3 class="text-xs font-bold uppercase text-gray-500 mb-1">Request Title</h3>
                <div class="border p-2 rounded mb-4 editable-field outline-none" contenteditable="true">
                    {{ $order->title }}
                </div>

                <h3 class="text-xs font-bold uppercase text-gray-500 mb-1">Full Description</h3>
                <div class="border p-4 rounded min-h-[200px] editable-field outline-none" contenteditable="true">
                    {!! nl2br(e($order->description)) !!}
                </div>
            </div>

            <!-- Signatures -->
            <div class="mt-20 grid grid-cols-2 gap-8">
                <div class="text-center">
                    <div class="border-b border-black w-3/4 mx-auto mb-2"></div>
                    <p class="text-xs text-gray-600">Admin Approval</p>
                </div>
                <div class="text-center">
                    <div class="border-b border-black w-3/4 mx-auto mb-2"></div>
                    <p class="text-xs text-gray-600">Recipient Signature</p>
                </div>
            </div>

        @else

            {{-- ========================================== --}}
            {{--           LAYOUT B: MULTIPLE (TABLE)       --}}
            {{-- ========================================== --}}

            <!-- Report Header -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold uppercase">Work Order Summary Report</h1>
                <p class="text-sm text-gray-600">Generated on: {{ date('F d, Y') }}</p>
            </div>

            <!-- The Table -->
            <table class="w-full text-sm text-left border-collapse border border-gray-300">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Title</th>
                        <th class="border border-gray-300 px-4 py-2">Requested By</th>
                        <th class="border border-gray-300 px-4 py-2">Date Requested</th>
                        <th class="border border-gray-300 px-4 py-2">Category</th>
                        <th class="border border-gray-300 px-4 py-2">Assigned To</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2 font-bold">#{{ $report->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div contenteditable="true" class="editable-field outline-none">{{ $report->title }}</div>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $report->user->name ?? 'Unknown' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $report->created_at->format('M d, Y') }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $report->category ?? 'N/A' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $report->assignee->name ?? 'Unassigned' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded
                                {{ $report->status == 'Resolved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $report->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary Footer -->
            <div class="mt-4 text-right text-sm font-bold text-gray-700">
                Total Records: {{ $reports->count() }}
            </div>

        @endif

    </div>

</body>
</html>
