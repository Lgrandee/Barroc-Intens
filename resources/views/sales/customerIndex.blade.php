<x-layouts.app>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klantenoverzicht — Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f3f4f6] text-gray-800">

    <!-- Topbar -->
    <header class="p-6">
        <h1 class="text-2xl font-semibold">Klantenoverzicht</h1>
        <p class="text-gray-500">Beheer en zoek door alle klanten</p>
    </header>

    <!-- Nav -->
    <nav class="bg-white border-y border-gray-200">
        <ul class="p-4">
            <li>
                <a href="#" class="text-blue-600 hover:underline">← Terug naar Index</a>
            </li>
        </ul>
    </nav>

    <main class="p-6">
        @livewire('customer-index')
    </main>

</body>
</html>
</x-layouts.app>
