<nav class="bg-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('images/icon-map.png') }}" class="h-10 w-auto" alt="Logo">
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Wanderlust</span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Home</a>
                <a href="#destinations" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Destinations</a>
                <a href="#map" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Map</a>
                <a href="{{ url('/admin/login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-colors font-medium">Login</a>
            </div>
        </div>
    </div>
</nav>
