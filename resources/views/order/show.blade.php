@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto px-6 py-8">

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('account.orders') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">View All Orders</a>
    </div>

    <!-- Order Details -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4">Order #{{ $order->id }}</h3>

        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-2">Shipping Recipient</h4>
            <span class="font-semibold">{{ $order->user->name }}</span>,
            <span class="text-gray-600">{{$order->user->phone_number }}</span>


        </div>

        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-2">Shipping Information</h4>
            <p>{{ $order->address->full_address }}</p>
            <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}</p>
        </div>

        <div class="mb-6">
            <h4 class="text-lg font-semibold mb-2">Order Details</h4>
            <p class="font-semibold">Order Status: <span class="font-normal">{{ $order->status }}</span></p>
            <p class="font-semibold">Order Date: <span class="font-normal">{{ $order->created_at->format('d M Y, H:i')
                    }}</span></p>
            <p class="font-semibold">Shipping Method: <span class="font-normal">{{ $order->shipping_method }}</span></p>
            <p class="font-semibold">Notes: <span class="font-normal">{{ $order->notes }}</span></p>
            <p class="font-semibold">Order ID Midtrans: <span class="font-normal">{{ $order->order_id_midtrans }}</span>
            </p>
            <p class="font-semibold">Snap Token: <span class="font-normal">{{ $order->snap_token }}</span></p>
        </div>

        <!-- Order Items -->
        <h4 class="text-lg font-semibold mb-2">Order Items</h4>
        <table class="w-full bg-gray-100 border border-gray-300 rounded-lg">
            <thead>
                <tr class="text-left">
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="px-4 py-2">
                        <img src="/images/products/{{ $item->product->image }}" alt="{{ $item->product->name }}"
                            class="w-16 h-16 rounded">
                        <span>{{ $item->product->name }}</span>
                    </td>
                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                    <td class="px-4 py-2">Rp.{{ number_format($item->product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">Rp.{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2">
                        <!-- Tombol Lihat Product -->
                        <a href="{{ route('product.show', $item->product->id) }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Lihat Product
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Order Total -->
        <div class="mt-6 text-right">
            <h3 class="text-xl font-bold">Order Total: Rp.{{ number_format($order->total, 0, ',', '.') }}</h3>
        </div>


        <!-- Action Button -->
        <div class="mt-8 flex justify-center">
            @if ($order->status == 'waiting')
            <!-- Tombol Generate Snap Token dan Delete Order -->
            <form action="{{ route('order.generateSnapToken') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <input type="hidden" name="order_id_midtrans" value="{{ $order->order_id_midtrans }}">
                <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 mr-4">
                    Generate Snap Token
                </button>
            </form>

            <form action="{{ route('order.delete') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">
                    Delete Order
                </button>
            </form>
            <!-- Tombol Lanjutkan Pembayaran -->
            @elseif ($order->status == 'pending')
            <button type="button"
                class="px-6 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 mr-4 pay-button"
                data-snap-token="{{ $order->snap_token }}" data-id="{{ $order->id }}">
                Pay
            </button>
            <!-- Tombol Pay, Cancel Order, dan Sync Status -->
            @elseif ($order->status == 'waiting_payment')
            <button type="button"
                class="px-6 py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 mr-4 pay-button"
                data-snap-token="{{ $order->snap_token }}" data-id="{{ $order->id }}">
                Pay
            </button>

            <button type="button"
                class="bg-red-500 px-6 py-3 text-white rounded-lg shadow hover:bg-red-600 mr-4 cancel-order-button"
                data-snap-token="{{ $order->snap_token }}" data-id="{{ $order->id }}"
                data-order-id-midtrans="{{ $order->order_id_midtrans }}">
                Cancel Order
            </button>

            <button type="button"
                class="bg-sky-500 px-6 py-3 text-white rounded-lg shadow hover:bg-sky-600 mr-4 sync-status-button"
                data-order-id-midtrans="{{ $order->order_id_midtrans }}">
                Sync Status
            </button>
            @else
            {{-- tampilkan jika ingin bisa menghapus order --}}
            {{-- <form action="{{ route('order.delete') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">
                    Delete Order
                </button>
            </form> --}}
            @endif
        </div>

        @if($order->status == 'success')
        @foreach($order->items as $item)
        @if(!$item->is_reviewed)
        <h3 class="text-2xl font-bold mb-4 mt-6">Leave a Review for {{ $item->product->name }}</h3>
        <img src="/images/products/{{ $item->product->image }}" alt="" class="w-16 h-16 rounded">
        <form action="{{ route('reviews.store', $item->product_id) }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="mb-4">
                <label for="rating_{{ $item->product_id }}" class="block text-gray-700">Rating:</label>
                <select name="rating" id="rating_{{ $item->product_id }}"
                    class="block w-full mt-1 rounded-md bg-gray-200 text-gray-800">
                    <option value="5">★★★★★</option>
                    <option value="4">★★★★☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="1">★☆☆☆☆</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="review_{{ $item->product_id }}" class="block text-gray-700">Review:</label>
                <textarea name="review" id="review_{{ $item->product_id }}" rows="4"
                    class="block w-full mt-1 rounded-md bg-gray-200 text-gray-800"></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
                Submit Review
            </button>
        </form>
        @endif
        @endforeach
        @endif



    </div>
</div>
@endsection

@section('scripts')
<script
    src="{{ env('MIDTRANS_IS_PRODUCTION', false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
    $(document).ready(function() {
        // Function untuk Tombol "Lanjutkan Pembayaran"
        $('.pay-button').on('click', function() {
            var snapToken = $(this).data('snap-token');
            var id = $(this).data('id');
            var orderIdMidtrans = $(this).data('order-id-midtrans');
            // Menjalankan snap midtrans
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    // Jika pembayaran transaksi sukses, ubah status menjadi Selesai
                    $.ajax({
                        url: '{{ route("order.updateStatus") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id: id,
                            order_id_midtrans: orderIdMidtrans,
                            status: 'success'
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to update order status: ' + xhr.responseJSON.message);
                        }
                    });
                },
                onPending: function(result) {
                    // Jika Order pending, ubah status menjadi Menunggu Pembayaran
                    $.ajax({
                        url: '{{ route("order.updateStatus") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id: id,
                            status: 'waiting_payment'
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to update order status: ' + xhr.responseJSON.message);
                        }
                    });
                },
                onError: function(result) {
                    alert('Failed to continue payment: ' + result.error_messages);
                }
            });
        });

            // Function untuk Tombol Batalkan Pesanan
        $('.cancel-order-button').on('click', function() {
            var id = $(this).data('id');
            var orderIdMidtrans = $(this).data('order-id-midtrans');
            if (!confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) return;
            $.ajax({
                url: '{{ route("order.cancel") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: id,
                    order_id_midtrans: orderIdMidtrans,
                },
                // jika berhasil akan reload.
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Failed to cancel order: ' + xhr.responseJSON.message);
                    // Jika gagal, coba jalankan sync status
                    $.ajax({
                        url: '{{ route("order.syncStatus") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_id_midtrans: orderIdMidtrans,
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to sync order status: ' + xhr.responseJSON.message);
                        }
                    });
                    
                }
            });
        });

        $('.sync-status-button').on('click', function() {
            var orderIdMidtrans = $(this).data('order-id-midtrans');
            $.ajax({
                url: '{{ route("order.syncStatus") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id_midtrans: orderIdMidtrans,
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Failed to sync order status: ' + xhr.responseJSON.message);
                }
            });
        });
        
    });
</script>

@endsection