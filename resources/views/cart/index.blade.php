@extends('layouts.app')

@section('content')
<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16 min-h-[600px]">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">

        @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif

        <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shopping Cart</h2>

        @if(count($items) == 0)
        <div class="h-[500px] text-gray-900 dark:text-white my-10">Your cart is empty! <a href="{{ route('search')}}"
                class="underline text-blue-500 hover:text-blue-600">click
                here</a> to add product.</div>
        @else

        <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
            <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">

                @foreach($items as $item)
                <div class="space-y-6">
                    <div
                        class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                        <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">

                            <a href="{{ route('product.show', $item->product->id) }}" class="shrink-0 md:order-1">
                                <img class="hidden h-20 w-20 dark:block"
                                    src="/images/products/{{ $item->product->image }}"
                                    alt="{{ $item->product->name }}" />
                            </a>

                            <label for="counter-input" class="sr-only">Choose quantity:</label>
                            <div class="flex items-center justify-between md:order-3 md:justify-end">
                                <div class="flex items-center">

                                    {{-- decrement --}}
                                    <button type="button" data-id="{{ $item->id }}"
                                        class="decrement-button inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 1h16" />
                                        </svg>
                                    </button>
                                    <input type="text" data-id="{{ $item->id }}"
                                        class="quantity-input w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
                                        value="{{ $item->quantity }}" required />

                                    {{-- increment --}}
                                    <button type="button" data-id="{{ $item->id }}"
                                        class="increment-button inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 1v16M1 9h16" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-end md:order-4 md:w-32">
                                    <p class="text-base font-bold text-gray-900 dark:text-white total-price"
                                        data-id="{{ $item->id }}" data-price="{{ $item->product->price }}">Rp.{{
                                        number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                <a href="{{ route('product.show', $item->product->id) }}"
                                    class="text-base font-medium text-gray-900 hover:underline dark:text-white">{{
                                    $item->product->name }}</a>

                                <div class="flex items-center gap-4">

                                    <form action="#" method="POST" class="flex items-center">
                                        @csrf
                                        <button type="button"
                                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline dark:text-gray-400 dark:hover:text-white">
                                            <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                            </svg>
                                            Add to Favorites
                                        </button>
                                    </form>

                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                        class="flex items-center">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                            <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18 17.94 6M18 18 6.06 6" />
                                            </svg>
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                <div
                    class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">

                    <a href="{{ route('checkout.index') }}"
                        class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Proceed
                        to Checkout</a>

                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center justify-center rounded-lg bg-red-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Clear Cart</button>
                    </form>

                    <div class="flex items-center justify-center gap-2">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> or </span>
                        <a href="{{ route('search') }}" title=""
                            class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                            Continue Shopping
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>
</section>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.increment-button').click(function() {
            let itemId = $(this).data('id');
            let quantityInput = $(`.quantity-input[data-id=${itemId}]`);
            let currentQuantity = parseInt(quantityInput.val());
            let price = parseFloat($(`.price[data-id=${itemId}]`).data('price'));
            quantityInput.val(currentQuantity + 1);
            updateCart(itemId, currentQuantity + 1, price);
        });

        $('.decrement-button').click(function() {
            let itemId = $(this).data('id');
            let quantityInput = $(`.quantity-input[data-id=${itemId}]`);
            let currentQuantity = parseInt(quantityInput.val());

            if (currentQuantity > 1) {
                let price = parseFloat($(`.price[data-id=${itemId}]`).data('price'));
                quantityInput.val(currentQuantity - 1);
                updateCart(itemId, currentQuantity - 1, price);
            }
        });

        function updateCart(itemId, quantity, price) {
            $.ajax({
                url: `/cart/update/${itemId}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        let totalPrice = response.totalPrice;
                        var formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalPrice);
                        $(`.total-price[data-id=${itemId}]`).text(formattedPrice);
                    } else {
                        alert('Error updating cart.');
                    }
                },
                error: function(error) {
                    console.error('Error updating cart:', error);
                }
            });
        }
    });
</script>

@endsection