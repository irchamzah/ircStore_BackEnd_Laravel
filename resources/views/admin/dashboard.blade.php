@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- CONTENT --}}
<div class="bg-white p-6 rounded-lg shadow-lg my-10">
    <p>Selamat datang, {{ Auth::user()->name }}</p>

    <!-- Overview Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <div class="bg-blue-100 p-4 rounded-lg shadow-md">
            <h3 class="text-xl font-bold">Total Pengguna</h3>
            <p class="text-3xl">{{ $totalUsers }}</p>
        </div>
        <div class="bg-green-100 p-4 rounded-lg shadow-md">
            <h3 class="text-xl font-bold">Pesanan Baru</h3>
            <p class="text-3xl">{{ $newOrders }}</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
            <h3 class="text-xl font-bold">Pendapatan</h3>
            <p class="text-3xl">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-100 p-4 rounded-lg shadow-md">
            <h3 class="text-xl font-bold">Produk Terlaris</h3>
            <p class="text-3xl">{{ $topSellingProductName }}</p>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold">Aktivitas Terbaru</h2>
        <ul class="mt-4">
            <li>Pesanan Terbaru:
                @if($recentOrder)
                <a class="text-blue-600 underline hover:text-blue-800"
                    href="{{ route('admin.orders.show', $recentOrder->id) }}">
                    ID:{{ $recentOrder->id }} oleh {{ $recentOrder->user->name }}
                </a>
                @else
                Tidak ada pesanan terbaru.
                @endif
            </li>
            <li>Ulasan Terbaru:
                @if($recentReview)
                <a class="text-blue-600 underline hover:text-blue-800"
                    href="{{ route('admin.products.show', $recentReview->product->id) }}">
                    {{ $recentReview->rating }} bintang oleh {{ $recentReview->user->name }} untuk produk {{
                    $recentReview->product->name }}
                </a>
                @else
                Tidak ada ulasan terbaru.
                @endif
            </li>
            <li>Pengguna Baru:
                @if($recentUser)
                {{ $recentUser->name }} ({{ $recentUser->created_at->format('d M Y') }})
                @else
                Tidak ada pengguna baru.
                @endif
            </li>
        </ul>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <a href="{{ route('admin.products.create') }}"
                class="bg-blue-500 text-white p-4 rounded-lg text-center hover:bg-blue-600">Tambah Produk Baru</a>
            <a href="{{ route('admin.categories.index') }}"
                class="bg-green-500 text-white p-4 rounded-lg text-center hover:bg-green-600">Manajemen Kategori</a>
            <a href="{{ route('admin.orders.index') }}"
                class="bg-yellow-500 text-white p-4 rounded-lg text-center hover:bg-yellow-600">Lihat Pesanan</a>
            <a href="{{ route('admin.users.index') }}"
                class="bg-red-500 text-white p-4 rounded-lg text-center hover:bg-red-600">Manajemen Pengguna</a>
            <a href="#" class="bg-purple-500 text-white p-4 rounded-lg text-center hover:bg-purple-600">Laporan
                Keuangan</a>
            <a href="#" class="bg-orange-500 text-white p-4 rounded-lg text-center hover:bg-orange-600">Statistik
                Penjualan</a>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold">Notifikasi</h2>
        <ul class="mt-4">
            <li>Pesanan yang Perlu Diproses: {{ $ordersToProcess }}</li>
            <li>Produk dengan Stok Rendah: {{ $lowStockProducts }}</li>
            <li>Ulasan dengan rating kurang dari 3: <strong>{{ $reviewsToReview }} reviews</strong></li>
        </ul>
    </div>

    <!-- Charts & Graphs -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold">Grafik & Diagram</h2>
        <div id="salesChart" class="mt-4">[Grafik Penjualan]</div>
        <div id="visitorChart" class="mt-4">[Grafik Tren Pengunjung]</div>
        <div id="productCategoryChart" class="mt-4">[Diagram Kategori Produk Terlaris]</div>
    </div>

    <!-- User Feedback -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold">Feedback Pengguna</h2>
        <ul class="mt-4 list-disc list-inside">
            @if($latestFeedback->isNotEmpty())
            @foreach($latestFeedback as $feedback)
            <li>
                {{ $feedback->user->name }} memberikan rating {{ $feedback->rating }} bintang untuk
                <a class="text-blue-600 underline hover:text-blue-800"
                    href="{{ route('admin.products.show', $feedback->product->id) }}">{{ $feedback->product->name }}</a>
            </li>
            @endforeach
            @else
            <li>Tidak ada feedback terbaru.</li>
            @endif
            <br>
            <div>
                Rangkuman Rating Produk:
                <ul class="list-disc list-inside">
                    @foreach($productRatingsSummary as $summary)
                    <li>{{ $summary->name }}: Rata-rata <strong>{{ number_format($summary->avg_rating, 1) }}</strong>
                        bintang</li>
                    @endforeach
                </ul>
            </div>
        </ul>
    </div>

    <!-- System Status -->
    <div class="bg-white p-6 mt-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold">Status Sistem</h2>
        <ul class="mt-4">
            <li>Status Server: {{ $serverStatus }}</li>
            <li>Log Error: {{ $errorLogs }}</li>
        </ul>
    </div>
</div>


{{-- TODO --}}

<div class="bg-white p-6 rounded-lg shadow-lg grid grid-cols-3">
    <div>
        <h2 class="text-2xl font-semibold mb-4">TODO DASHBOARD PAGE:</h2>
        <p class="font-semibold">1. Overview Statistis:</p>
        <ul class="list-disc list-inside">
            <li>Jumlah total pengguna.</li>
            <li>Jumlah pesanan yang baru masuk atau pesanan total.</li>
            <li>Pendapatan keseluruhan dalam periode tertentu (hari ini, minggu ini, bulan ini).</li>
            <li>Produk dengan penjualan tertinggi atau produk paling populer.</li>
        </ul>
        <br>
        <p class="font-semibold">2. Recent Activities:</p>
        <ul class="list-disc list-inside">
            <li>Daftar pesanan terbaru.</li>
            <li>Ulasan terbaru dari pelanggan.</li>
            <li>Aktivitas terbaru pengguna, seperti pengguna baru yang mendaftar.</li>
        </ul>
        <br>
        <p class="font-semibold">3. Quick Actions:</p>
        <ul class="list-disc list-inside">
            <li>Tombol untuk menambahkan produk baru.</li>
            <li>Akses cepat ke manajemen kategori, produk, pesanan, atau pengguna.</li>
            <li>Shortcut untuk melihat laporan keuangan atau statistik penjualan.</li>
        </ul>
        <br>
        <p class="font-semibold">4. Notifications:</p>
        <ul class="list-disc list-inside">
            <li>Notifikasi untuk pesanan yang perlu diproses.</li>
            <li>Pengingat untuk produk yang stoknya hampir habis.</li>
            <li>Notifikasi untuk ulasan yang perlu ditinjau.</li>
        </ul>
        <br>
        <p class="font-semibold">5. Charts & Graphs:</p>
        <ul class="list-disc list-inside">
            <li>Grafik penjualan harian, mingguan, atau bulanan.</li>
            <li>Grafik tren pengunjung website.</li>
            <li>Diagram kategori produk terlaris.</li>
        </ul>
        <br>
        <p class="font-semibold">6. User Feedback:</p>
        <ul class="list-disc list-inside">
            <li>Menampilkan ulasan atau pertanyaan terbaru dari pengguna.</li>
            <li>Rangkuman rating produk.</li>
        </ul>
        <br>
        <p class="font-semibold">7. System Status:</p>
        <ul class="list-disc list-inside">
            <li>Status server atau aplikasi (uptime, performa).</li>
            <li>Log error atau isu penting yang terjadi di sistem.</li>
        </ul>
        <br>
    </div>
    <div>
        <h2 class="text-2xl font-semibold mb-4">TODO:</h2>
        <p class="font-semibold">1. Home Page:</p>
        <ul class="list-disc list-inside">
            <li>Tambahkan promosi, dan penawaran khusus.</li>
        </ul>
        <br>
        <p class="font-semibold">2. Products Page:</p>
        <ul class="list-disc list-inside">
            <li>Filter berdasarkan rating.</li>
        </ul>
        <br>
        <p class="font-semibold">3. Detail Product:</p>
        <ul class="list-disc list-inside">
            <li>Buat agar dapat menyimpan beberapa foto sekaligus.</li>
            <li>Buat agar dapat berdiskusi antar pembeli di produk tertentu.</li>
            <li>Buat agar dapat menyimpan produk favorit atau wishlist.</li>
            <li>Tambahkan variasi dan ketika klik variasi lain maka akan mempengaruhi harganya.</li>
            <li>Buat agar review juga bisa mengirim foto.</li>
        </ul>
        <br>
        <p class="font-semibold">4. Checkout:</p>
        <ul class="list-disc list-inside">
            <li>Buat agar shipping method mempengaruhi harga total.</li>
            <li>Buat agar user tidak dapat checkout kalau informasi pribadinya belum lengkap.</li>
        </ul>
        <br>
        <p class="font-semibold">5. Notifikasi:</p>
        <ul class="list-disc list-inside">
            <li>Buat agar jika ada pesanan atau perubahan yang terjadi maka akan ada notifikasi atau email di akun
                masing-masing.
            </li>
            <li>Buat agar jika ada pesanan atau perubahan yang terjadi maka akan ada notifikasi atau email masuk ke
                admin.</li>
        </ul>
        <br>
        <p class="font-semibold">6. Promosi dan Diskon:</p>
        <ul class="list-disc list-inside">
            <li>Membuat agar promosi dan diskon bekerja.</li>
        </ul>
        <br>
        <p class="font-semibold">7. Manajemen Pengiriman:</p>
        <ul class="list-disc list-inside">
            <li>Integrasi dengan layanan pengiriman untuk melacak status pengiriman.</li>
        </ul>
        <br>
        <p class="font-semibold">8. Chat Page:</p>
        <ul class="list-disc list-inside">
            <li>Buat halaman yang mana user bisa menghubungi user lainnya.</li>
            <li>Di halaman chat teratas, terdapat akun admin yang akan menerima pesan dari user.</li>
        </ul>
        <br>
        <p class="font-semibold">9. About Us Page:</p>
        <ul class="list-disc list-inside">
            <li>Buat halaman tentang kami.</li>
        </ul>
        <br>
        <p class="font-semibold">10. Tambah Sesuatu yang bisa dijual:</p>
        <ul class="list-disc list-inside">
            <li>Tambahkan halaman memesan jasa.</li>
            <li>Tambahkan halaman membeli template tailwind.</li>
        </ul>
        <br>
    </div>
    <div>
        <h2 class="text-2xl font-semibold mb-4"><br></h2>
        <p class="font-semibold">11. Detail Profile:</p>
        <ul class="list-disc list-inside">
            <li>Tampilkan wishlist di halaman detail profile.</li>
            <li>Tampilkan riwayat aktivitas, seperti Audit log.</li>
        </ul>
        <br>
        <p class="font-semibold">12. Admin:</p>
        <ul class="list-disc list-inside">
            <li>Admin bisa mengirim notifikasi ke user atau ke semua user.</li>
            <li>Buat agar admin bisa bulk action (membuat perubahan sekaligus secara bersamaan).</li>
        </ul>
        <br>
    </div>
</div>
@endsection