<?php

namespace App\Livewire\Admin\ReturnRequest;

use App\Notifications\OrderStatusNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Shop\Entities\ReturnClaim;

class ReturnRequestIndex extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $filterStatus = 'PENDING';
    public $selectedClaim;
    public $showDetailModal = false;
    public $showImageModal = false;
    public $previewImageUrl = '';

    public function detail($id)
    {
        $this->selectedClaim = ReturnClaim::with(['order', 'user', 'approver', 'rejecter'])->find($id);
        $this->showDetailModal = true;
    }

    public function previewImage($url)
    {
        $this->previewImageUrl = $url;
        $this->showImageModal = true;
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->showImageModal = false;
        $this->selectedClaim = null;
    }

    public function approve($id)
    {
        $claim = ReturnClaim::with('order', 'user')->findOrFail($id);
        $claim->update([
            'status' => ReturnClaim::STATUS_APPROVED,
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
        ]);

        $claim->user->notify(new OrderStatusNotification(
            $claim->order,
            'Retur Disetujui',
            'Pengajuan retur untuk pesanan #' . $claim->order->code . ' telah disetujui. Tim kami akan menghubungi Anda untuk proses selanjutnya.',
            '/orders/' . $claim->order->id
        ));

        $this->closeModal();
        session()->flash('success', 'Retur pesanan ' . $claim->order->code . ' telah disetujui.');
    }

    public function reject($id)
    {
        $claim = ReturnClaim::with('order', 'user')->findOrFail($id);
        $claim->update([
            'status' => ReturnClaim::STATUS_REJECTED,
            'rejected_by' => auth('admin')->id(),
            'rejected_at' => now(),
        ]);

        $claim->user->notify(new OrderStatusNotification(
            $claim->order,
            'Retur Ditolak',
            'Pengajuan retur untuk pesanan #' . $claim->order->code . ' ditolak. Silakan hubungi admin untuk informasi lebih lanjut.',
            '/orders/' . $claim->order->id
        ));

        $this->closeModal();
        session()->flash('success', 'Retur pesanan ' . $claim->order->code . ' telah ditolak.');
    }

    public function render()
    {
        $query = ReturnClaim::with(['order', 'user'])->latest();

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.return-request.return-request-index', [
            'claims' => $query->paginate($this->perPage),
        ])->layout('components.layouts.app');
    }
}
