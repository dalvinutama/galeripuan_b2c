<x-mail::message>
# Halo, {{ $order->customer_first_name }}! 🚚

Kabar baik! Pesanan Anda dengan nomor **#{{ $order->code }}** telah diserahkan ke pihak kurir dan sedang dalam perjalanan menuju alamat Anda.

Berikut adalah detail pengiriman Anda:

<x-mail::panel>
**Nomor Resi:** {{ $order->shipping_number }}
</x-mail::panel>

Anda dapat melacak status pengiriman pesanan Anda melalui website kami atau langsung di situs web kurir terkait.

<x-mail::button :url="'https://cekresi.com/?noresi=' . $order->shipping_number">
Lacak Pesanan Saya
</x-mail::button>

Terima kasih telah berbelanja di **Gallery Puan**! Kami berharap pesanan Anda tiba dengan selamat dan memuaskan.

Salam hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>
