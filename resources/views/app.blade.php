<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'مارلیک افزار') }}</title>
{{--        <script>--}}
{{--            (function() {--}}
{{--                const appearance = '{{ $appearance ?? "light" }}';--}}

{{--                if (appearance === 'system') {--}}
{{--                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;--}}

{{--                    if (prefersDark) {--}}
{{--                        document.documentElement.classList.add('dark');--}}
{{--                    }--}}
{{--                }--}}
{{--            })();--}}
{{--        </script>--}}

        @routes
        @vite(['resources/js/app.ts'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
