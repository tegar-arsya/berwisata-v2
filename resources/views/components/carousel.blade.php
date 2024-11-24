<section class="relative h-screen">
    <div class="absolute inset-0 carousel-gradient">
        <div id="animation-carousel" class="h-full" data-carousel="static">
            <div class="relative h-full overflow-hidden">
                <!-- Carousel items with overlay text -->
                @foreach(['Item 1', 'Item 2', 'Item 3'] as $item)
                <div class="hidden duration-700 ease-in-out h-full" data-carousel-item>
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRi2x8RiCqcGmMiQn455B9Jxup0QTcobH7bw&s"
                         class="absolute block w-full h-full object-cover"
                         alt="...">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h1 class="text-5xl font-bold mb-4">Discover Beautiful Places</h1>
                            <p class="text-xl mb-8">Explore the hidden gems of our region</p>
                            <a href="#destinations"
                               class="bg-blue-600 text-white px-8 py-3 rounded-full hover:bg-blue-700 transition-colors text-lg font-medium">
                                Start Exploring
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
