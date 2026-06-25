<?php

namespace App\Livewire\Admin\Voucher;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Shop\Entities\Voucher;

class VoucherIndex extends Component
{
    use WithPagination;

    public $search;
    
    // Pastikan min_order_count ada di sini
    public $voucher_id, $code, $description, $type = 'fixed', $value, $min_total = 0, $min_order_count = 0, $expired_at;
    public $is_first_order_only = false;
    public $is_active = true;
    public $isEditMode = false;

    protected $rules = [
        'code' => 'required|string|min:3',
        'description' => 'required|string|max:255',
        'type' => 'required|in:fixed',
        'value' => 'required|numeric|min:1',
        'min_total' => 'required|numeric|min:0',
        'min_order_count' => 'nullable|numeric|min:0', // Validasi angka
        'expired_at' => 'required|date',
    ];

    public function render()
    {
        $vouchers = Voucher::where('code', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.voucher.voucher-index', compact('vouchers'))
            ->layout('components.layouts.app');
    }

    public function resetFields()
    {
        $this->reset(['voucher_id', 'code', 'description', 'type', 'value', 'min_total', 'min_order_count', 'expired_at']);
        $this->is_first_order_only = false;
        $this->is_active = true;
        $this->isEditMode = false;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        if (!$this->isEditMode && Voucher::where('code', strtoupper($this->code))->exists()) {
            $this->addError('code', 'Kode voucher ini sudah digunakan!');
            return;
        }

        // Paksa min_order_count jadi 0 jika khusus pesanan pertama dicentang
        if ($this->is_first_order_only) {
            $this->min_order_count = 0;
        }

        Voucher::updateOrCreate(
            ['id' => $this->voucher_id],
            [
                'code' => strtoupper($this->code),
                'description' => $this->description,
                'type' => $this->type,
                'value' => $this->value,
                'min_total' => $this->min_total,
                'is_first_order_only' => $this->is_first_order_only,
                'min_order_count' => $this->min_order_count ?: 0, // Simpan ke database
                'expired_at' => $this->expired_at,
                'is_active' => $this->is_active,
            ]
        );

        session()->flash('success', $this->isEditMode ? 'Voucher berhasil diperbarui!' : 'Voucher berhasil ditambahkan!');
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $voucher = Voucher::findOrFail($id);
        
        $this->voucher_id = $voucher->id;
        $this->code = $voucher->code;
        $this->description = $voucher->description;
        $this->type = $voucher->type;
        $this->value = $voucher->value;
        $this->min_total = $voucher->min_total;
        $this->is_first_order_only = $voucher->is_first_order_only;
        $this->min_order_count = $voucher->min_order_count; // Ambil dari database
        $this->expired_at = $voucher->expired_at;
        $this->is_active = $voucher->is_active;
        
        $this->isEditMode = true;
    }

    public function delete($id)
    {
        Voucher::findOrFail($id)->delete();
        session()->flash('success', 'Voucher berhasil dihapus!');
    }
}