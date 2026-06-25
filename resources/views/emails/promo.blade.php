<x-mail::message>
# Halo! 👋

{!! nl2br(e($message_content)) !!}

@if($voucher_code)
Jangan lewatkan kesempatan ini! Gunakan kode voucher di bawah ini saat checkout:

<x-mail::panel>
**{{ $voucher_code }}**
</x-mail::panel>
@endif

<x-mail::button :url="url('/products')">
Belanja Sekarang
</x-mail::button>

Terima kasih telah menjadi bagian dari **Gallery Puan**.

Salam hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>
