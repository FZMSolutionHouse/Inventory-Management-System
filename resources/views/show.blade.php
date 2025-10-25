<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Shotcut - User Agreement</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold text-center mb-4">User Details</h1>
        <p><strong>Name:</strong> {{ $digitalSign->name }}</p>
        <p><strong>Email:</strong> {{ $digitalSign->email }}</p>
        <h2 class="mt-4 mb-2 text-lg font-medium">Signature</h2>
        @if ($digitalSign->signature)
            <img src="{{ asset('storage/' . $digitalSign->signature->filename) }}" alt="User Signature" class="w-full h-auto">
        @else
            <p>No signature available.</p>
        @endif
    </div>
</body>
</html>