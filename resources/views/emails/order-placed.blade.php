<!DOCTYPE html>
<html>

<head>
    <title>Order Placed - ircStore</title>
</head>

<body>
    <h1>New Order Received</h1>

    <h3>Customer Details</h3>
    <p><strong>Name:</strong> {{ $order->user->name }}</p>
    <p><strong>Email:</strong> {{ $order->user->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
    <p><strong>Address:</strong> {{ $order->address->full_address }}, {{ $order->address->city }}, {{
        $order->address->state }}, {{ $order->address->country }}, {{ $order->address->postal_code }}</p>
    <br>
    <br>
    <h3>Order Details</h3>
    <p><strong>Order ID Midtrans:</strong> {{ $order->order_id_midtrans }}</p>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Total Payment:</strong>Rp.{{ number_format($order->total, 0, ',', '.') }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Created At:</strong> {{ $order->created_at }}</p>
    <p><strong>Notes:</strong> {{ $order->notes }}</p>
    <p><strong>Items:</strong></p>
    <ul>
        @foreach($order->items as $item)
        <li>{{ $item->product->name }} - {{ $item->quantity }} x Rp.{{ number_format($item->price, 0, ',', '.') }} =
            Rp.{{ number_format($item->price * $item->quantity, 0, ',', '.')
            }}</li>
        @endforeach
    </ul>

</body>

</html>