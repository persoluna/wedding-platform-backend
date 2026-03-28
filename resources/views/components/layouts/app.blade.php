<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Nuptial | Luxe Wedding Marketplace' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 dark:bg-navy-950 text-stone-800 dark:text-stone-200 transition-colors duration-300 min-h-screen font-sans selection:bg-champagne-200 selection:text-stone-900">
    <x-layouts.navbar :transparent="$transparentNav ?? false" />
    
    <main>
        {{ $slot }}
    </main>

    <x-layouts.footer />
</body>
</html>
