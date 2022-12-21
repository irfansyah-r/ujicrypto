<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('images/icon-blue.png') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @livewireStyles

        @livewireScripts

        @powerGridStyles

        <!-- Chart Styles -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">

        <!-- Chart Script -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/amstock.js"></script>
        <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/exporting/amexport_combined.js"></script>
        <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>


        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}"></script>
    </head>
    <body>
        <div class="font-sans antialiased md:overflow-auto">
            <div class="min-h-screen bg-gray-100 flex md:flex-row flex-col" x-data="{ isOpen: true }"
                @resize.window="width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                if (width < 900) {
                    isOpen = false
                }else{
                    isOpen = true
                }"
            >

                <header class="md:bg-transparent bg-white w-full h-16 absolute flex flex-1 items-center">
                    <!-- <div class="max-w-7xl mx-6 rounded-full hover:bg-gray-300 transform transition duration-500 ease-in-out md:mx-72"> -->
                    <div class="max-w-7xl mx-6 rounded-full hover:bg-gray-300 transform transition duration-500 ease-in-out md:mx-28" :class="{ 'md:translate-x-36': isOpen }">
                        <button x-on:click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 text-gray-800 hover:text-black focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="inline-flex" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </header>

                @include('layouts.sidenav')

                <!-- Page Content -->
                <main class="mx-8 mt-20 mb-10 md:ml-56 transform transition duration-500 ease-in-out md:w-full md:-translate-x-0 overflow-hidden md:px-8" :class="{ 'md:-translate-x-56': !isOpen, 'md:-mr-56': !isOpen }">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @powerGridScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
        @livewire('livewire-ui-modal')

    </body>
</html>
