<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $wisata->nama_wisata }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js"></script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .leaflet-routing-container {
            display: none;
        }

    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-100 text-gray-800 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Hero Section -->
        <div class="bg-white border-2 border-blue-100 shadow-2xl rounded-2xl overflow-hidden mb-8 transform transition hover:scale-[1.01] hover:shadow-3xl duration-300">
            <div class="relative group">
                @if($wisata->images->first())
                    <img src="{{ asset('gambar-wisata/' . $wisata->images->first()->image_path[0]) }}"
                         alt="{{ $wisata->nama_wisata }}"
                         class="w-full h-96 object-cover filter brightness-75 group-hover:brightness-90 transition duration-300">
                @endif
                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/70 to-transparent">
                    <h1 class="text-4xl font-bold text-white mb-2 drop-shadow-lg">{{ $wisata->nama_wisata }}</h1>
                </div>
            </div>

            <!-- Description Section -->
            <div class="p-6">
                <p class="text-gray-600 text-lg leading-relaxed mb-4">
                    <i data-feather="map-pin" class="inline-block mr-2 text-blue-500"></i>
                    {{ $wisata->deskripsi }}
                </p>
            </div>
        </div>
        <div class="container mx-auto px-4 py-8 max-w-6xl">
            <div class="bg-white border-2 border-blue-100 shadow-xl rounded-2xl overflow-hidden">
                <div class="p-6 bg-blue-50">
                    <h2 class="text-3xl font-bold text-blue-800 mb-4">Lokasi Wisata</h2>
                </div>
                <div id="leaflet-map" style="height: 500px;"></div>
            </div>
        </div>
        <!-- Image Gallery -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            @foreach ($wisata->images as $image)
                @foreach ($image->image_path as $path)
                    <div class="bg-white border border-blue-100 rounded-lg overflow-hidden shadow-md transform transition hover:scale-105 hover:shadow-xl">
                        <img src="{{ asset('gambar-wisata/' . $path) }}"
                             alt="{{ $wisata->nama_wisata }}"
                             class="w-full h-48 md:h-64 object-cover">
                    </div>
                @endforeach
            @endforeach
        </div>

        <!-- Reviews Section -->
        <div class="bg-white border-2 border-blue-100 shadow-xl rounded-2xl p-6 mb-8">
            <div class="flex items-center mb-4">
                <i data-feather="message-circle" class="mr-2 text-blue-500"></i>
                <h2 class="text-2xl font-bold text-gray-800">Visitor Reviews</h2>
            </div>

            @if($wisata->reviews->count() > 0)
                @foreach ($wisata->reviews as $review)
                    <div class="border-b border-blue-100 py-4 last:border-b-0 hover:bg-blue-50 transition rounded-lg px-2">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i data-feather="user" class="mr-2 text-gray-500"></i>
                                <span class="font-semibold text-gray-700">
                                    {{ $review->nama_pengunjung ?: 'Anonymous' }}
                                </span>
                            </div>
                            <div class="flex items-center text-yellow-500">
                                <i data-feather="star" class="mr-1"></i>
                                <span>{{ number_format($review->rating, 1) }}</span>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "{{ $review->komentar }}"
                        </p>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-4">
                    No reviews yet. Be the first to share your experience!
                </p>
            @endif
        </div>

        <!-- Review Form Section -->
        <div class="bg-white border-2 border-blue-100 shadow-xl rounded-2xl p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <i data-feather="edit-3" class="mr-2 text-blue-500"></i>
                Leave a Review
            </h2>
            <form id="reviewForm" action="{{ route('reviews.store', $wisata->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama_pengunjung" class="block text-gray-700 mb-2">Your Name</label>
                    <input type="text" id="nama_pengunjung" name="nama_pengunjung"
                           class="mt-1 block w-full border-2 border-blue-100 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                           required placeholder="Enter your name">
                </div>
                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 mb-2">Rating</label>
                    <select id="rating" name="rating"
                            class="mt-1 block w-full border-2 border-blue-100 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                            required>
                        <option value="" disabled selected>Select a rating</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="komentar" class="block text-gray-700 mb-2">Your Review</label>
                    <textarea id="komentar" name="komentar" rows="4"
                              class="mt-1 block w-full border-2 border-blue-100 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                              required placeholder="Share your experience"></textarea>
                </div>
                <button type="submit"
                        class="bg-blue-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-[1.02] shadow-md hover:shadow-lg">
                    Submit Review
                </button>
            </form>
        </div>
    </div>

    <script>
        // Initialize Feather Icons
        feather.replace();

        // Handle form submission with SweetAlert
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Submitting Review',
                text: 'Please wait...',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Review Submitted!',
                    text: data.message || 'Thank you for your review!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Optional: Reload the page or update reviews dynamically
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Try Again'
                });
            });
        });
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi peta
        var map = L.map('leaflet-map').setView([{{ $wisata->latitude }}, {{ $wisata->longitude }}], 15);

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Marker destinasi wisata
        var destinationIcon = L.divIcon({
            className: 'custom-destination-icon',
            html: `
                <div style="
                    width: 30px;
                    height: 45px;
                    background-color: red;
                    clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
                    border: 2px solid white;
                    box-shadow: 0 0 10px rgba(255,0,0,0.5);
                "></div>
            `,
            iconSize: [30, 45],
            iconAnchor: [15, 45]
        });

        // Tambahkan marker wisata
        L.marker([{{ $wisata->latitude }}, {{ $wisata->longitude }}], {
            icon: destinationIcon
        }).addTo(map).bindPopup(`
            <div class="text-center">
                <h3 class="font-bold text-lg">{{ $wisata->nama_wisata }}</h3>
                <button onclick="calculateRoute({{ $wisata->latitude }}, {{ $wisata->longitude }})"
                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mt-2">
                    Dapatkan Rute
                </button>
            </div>
        `);

        // Fungsi mendapatkan lokasi pengguna
        function getUserLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    // Tambahkan marker lokasi pengguna
                    L.marker([userLat, userLng]).addTo(map)
                        .bindPopup("Lokasi Anda")
                        .openPopup();

                    window.userLocation = [userLat, userLng];
                });
            }
        }

        // Fungsi menghitung rute
        window.calculateRoute = function(destLat, destLng) {
            if (window.userLocation) {
                L.Routing.control({
                    waypoints: [
                        L.latLng(window.userLocation[0], window.userLocation[1]),
                        L.latLng(destLat, destLng)
                    ],
                    routeWhileDragging: true,
                    geocoder: L.Control.Geocoder.nominatim(),
                    createMarker: function() { return null; },
                    show: false,
                }).addTo(map);
            } else {
                alert("Aktifkan lokasi Anda terlebih dahulu!");
                getUserLocation();
            }
        }

        // Dapatkan lokasi pengguna saat halaman dimuat
        getUserLocation();
    });
    </script>
</body>
</html>
