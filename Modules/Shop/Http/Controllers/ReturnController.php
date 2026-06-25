<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\ReturnClaim;

class ReturnController extends Controller
{
    public function create($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$this->canClaimReturn($order)) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Maaf, pengajuan retur hanya dapat dilakukan maksimal 3 hari setelah pesanan selesai.');
        }

        if ($order->returnClaim) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Anda sudah mengajukan retur untuk pesanan ini.');
        }

        $this->data['order'] = $order;
        return $this->loadTheme('returns.create', $this->data);
    }

    public function store(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$this->canClaimReturn($order)) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Batas waktu pengajuan retur telah habis.');
        }

        if ($order->returnClaim) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Anda sudah mengajukan retur untuk pesanan ini.');
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $request->file('proof_image')->store('returns', 'public');

        ReturnClaim::create([
            'id' => (string) Str::uuid(),
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'proof_image' => $imagePath,
            'status' => ReturnClaim::STATUS_PENDING,
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pengajuan retur berhasil dikirim. Admin akan memproses dalam waktu 1x24 jam.');
    }

    private function canClaimReturn(Order $order): bool
    {
        $completedStatuses = ['COMPLETED', 'RECEIVED'];

        if (!in_array(strtoupper($order->status), $completedStatuses)) {
            return false;
        }

        $deadline = $order->updated_at->addDays(3);
        return now()->lte($deadline);
    }
}
