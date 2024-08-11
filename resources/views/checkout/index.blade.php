@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16 min-h-[600px]">
    <form action="{{ route('checkout.process') }}" method="POST" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        @csrf
        <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
            <div class="min-w-0 flex-1 space-y-8">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Delivery Details</h2>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">


                        <div>
                            <div class="mb-2 flex items-center gap-2">
                                <label for="address_id"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Shipping
                                    Address</label>
                            </div>
                            <select name="address_id" id="address_id"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                @foreach($addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->full_address }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center gap-2">
                                <label for="shipping_method"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Shipping
                                    Method</label>
                            </div>
                            <select name="shipping_method" id="shipping_method"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500">
                                <option value="standard">Standard Shipping</option>
                                <option value="express">Express Shipping</option>
                            </select>
                        </div>



                        <div class="sm:col-span-2">
                            <div>
                                <label for="your_name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Notes for Seller</label>
                                <textarea name="notes" id="notes"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
                <div class="flow-root">
                    <div class="-my-3 divide-y divide-gray-200 dark:divide-gray-800">

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Product</dt>
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Name</dt>
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Quantity</dt>
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Subtotal</dt>
                        </dl>


                        @foreach($cartItems as $item)
                        <dl class="flex items-center justify-between gap-4 py-3">
                            <img src="/images/{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                class="w-16 h-16 rounded">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $item->product->name
                                }}</dt>
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $item->quantity }}
                            </dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-white">Rp.{{
                                number_format($item->product->price *
                                $item->quantity, 2) }}</dd>
                        </dl>
                        @endforeach



                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                            <dd class="text-base font-bold text-gray-900 dark:text-white">Rp.{{
                                number_format($cartItems->sum(fn($item) =>
                                $item->product->price * $item->quantity), 2) }}</dd>
                        </dl>
                    </div>
                </div>

                <div class="space-y-3">
                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Proceed
                        to Payment</button>


                </div>
            </div>
        </div>
    </form>
</section>

@endsection