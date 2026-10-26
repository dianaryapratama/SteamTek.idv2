<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <linkpreconnect href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-zinc-100 antialiased bg-zinc-950 selection:bg-indigo-500 selection:text-white">
        
        <div class="fixed inset-0 z-0 opacity-[0.03]" style="background-image: radial-gradient(#6366f1 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4 relative z-10">
            
            <div class="mb-8">
                <a href="/" class="text-3xl font-bold tracking-tight text-white hover:text-indigo-400 transition duration-300">
                    SteamTek<span class="text-indigo-500">.</span>
                </a>
            </div>

            <div class="w-full sm:max-w-[400px] bg-zinc-900 border border-zinc-800 shadow-xl rounded-xl overflow-hidden">
                <div class="px-6 py-8 md:px-8">
                    {{ $slot }}
                </div>
            </div>

            <div class="mt-6 text-center text-xs text-zinc-600 font-medium">
                &copy; {{ date('Y') }} SteamTek Digital.
            </div>
        </div>
    </body>
</html>