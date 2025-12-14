<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Order #{{ $order->id }}</title>
    <!-- Use Tailwind via CDN for simplicity in print view -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white text-gray-900 p-8" onload="window.print()">

    <!-- Header / Logo Area -->
    <div class="flex justify-between items-start border-b-2 border-gray-800 pb-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold uppercase tracking-wide">Work Order Report</h1>
            <p class="text-gray-500 mt-1">Order ID: #{{ $order->id }}</p>
        </div>
        <div class="text-right">
            <h2 class="font-bold text-lg">Company Name</h2> <!-- Change this -->
            <p class="text-sm text-gray-600">123 Business Road</p>
            <p class="text-sm text-gray-600">City, Country, 12345</p>
            <p class="text-sm text-gray-600">Date: {{ date('F d, Y') }}</p>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-2 gap-8 mb-8">
        <!-- Requester Info -->
        <div>
            <h3 class="text-sm font-bold uppercase text-gray-500 mb-2">Requester Details</h3>
            <div class="bg-gray-100 p-4 rounded">
                <p><strong>Name:</strong> {{ $order->user->name ?? 'Unknown' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                <p><strong>Request Date:</strong> {{ $order->created_at->format('M d, Y H:i A') }}</p>
            </div>
        </div>

        <!-- Order Status -->
        <div>
            <h3 class="text-sm font-bold uppercase text-gray-500 mb-2">Order Status</h3>
            <div class="bg-gray-100 p-4 rounded">
                <p><strong>Current Status:</strong> <span class="uppercase">{{ $order->status }}</span></p>
                <p><strong>Priority:</strong> {{ $order->priority }}</p>
                <p><strong>Assigned To:</strong> {{ $order->assignee->name ?? 'Unassigned' }}</p>
                <p><strong>Due Date:</strong> {{ $order->due_date ? \Carbon\Carbon::parse($order->due_date)->format('M d, Y') : 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Full Content -->
    <div class="mb-8">
        <h3 class="text-sm font-bold uppercase text-gray-500 mb-2">Request Title</h3>
        <div class="border p-4 rounded mb-4">
            {{ $order->title }}
        </div>

        <h3 class="text-sm font-bold uppercase text-gray-500 mb-2">Detailed Description</h3>
        <div class="border p-4 rounded min-h-[150px]">
            {{-- Preserves line breaks --}}
            {!! nl2br(e($order->description)) !!}
        </div>
    </div>

    <!-- Signatures (Optional for physical reports) -->
    <div class="mt-16 grid grid-cols-2 gap-8">
        <div class="text-center">
            <div class="border-b border-gray-400 w-3/4 mx-auto mb-2"></div>
            <p class="text-sm text-gray-600">Approved By (Admin)</p>
        </div>
        <div class="text-center">
            <div class="border-b border-gray-400 w-3/4 mx-auto mb-2"></div>
            <p class="text-sm text-gray-600">Employee Signature</p>
        </div>
    </div>

    <!-- Print Button (Hidden when printing) -->
    <div class="fixed bottom-5 right-5 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700 font-bold">
            Print / Save as PDF
        </button>
    </div>

</body>
</html>
