<?php

namespace App\Observers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Voucher;
use App\Mail\AfterSalesCareMail;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     *
     * Trigger: status berubah menjadi 'COMPLETED'.
     * Aksi  : (1) generate voucher purna-jual, (2) kirim AfterSalesCareMail via queue.
     */
    public function updated(Order $order): void
    {
        // Guard: hanya proses jika kolom 'status' yang berubah
        // dan nilai barunya adalah 'COMPLETED' atau 'RECEIVED' (keduanya "selesai" di sistem ini).
        if (! $order->isDirty('status')) {
            return;
        }

        $newStatus = strtoupper(trim($order->status));

        if ($newStatus !== 'COMPLETED' && $newStatus !== 'RECEIVED') {
            return;
        }

        try {
            // ==================================================================
            // LANGKAH 1: Generate Voucher Purna-Jual Unik
            // ==================================================================
            $prefix = \App\Models\Setting::getValue('after_sales_voucher_prefix', 'PUAN-THANKS-');
            $discount = (float) \App\Models\Setting::getValue('after_sales_voucher_discount', 10);
            $days = (int) \App\Models\Setting::getValue('after_sales_voucher_days', 30);

            $voucherCode = $prefix . strtoupper(Str::random(6));

            // Pastikan kode voucher benar-benar unik (loop jika tabrakan)
            while (Voucher::where('code', $voucherCode)->exists()) {
                $voucherCode = $prefix . strtoupper(Str::random(6));
            }

            $voucher = Voucher::create([
                'code'        => $voucherCode,
                'description' => 'Voucher apresiasi purna-jual untuk Order #' . $order->code,
                'type'        => 'percent',       // Diskon persentase
                'value'       => $discount,
                'is_active'   => true,
                'expired_at'  => now()->addDays($days)->toDateTimeString(),
            ]);

            // ==================================================================
            // LANGKAH 2: Kirim Email Purna-Jual via Queue (Non-Blocking)
            // ==================================================================
            Mail::to($order->customer_email)
                ->queue(new AfterSalesCareMail($order, $voucher));

            Log::info('[AfterSales] Voucher & email dikirim.', [
                'order_id'     => $order->id,
                'order_code'   => $order->code,
                'voucher_code' => $voucherCode,
                'email'        => $order->customer_email,
            ]);

        } catch (\Throwable $e) {
            // Fail silently — purna-jual tidak boleh merusak flow utama
            Log::error('[AfterSales] Gagal mengirim email/voucher purna-jual.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }
}
