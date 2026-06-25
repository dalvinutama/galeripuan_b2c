<?php

namespace App\Livewire\Admin\Marketing;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PromoBlastMail;
use Modules\Shop\Entities\voucher;

class PromoBlast extends Component
{
    public $subject = '';
    public $message = '';
    public $voucher_code = '';
    public $target_audience = 'all'; // all, inactive_1_month, etc.

    protected $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'voucher_code' => 'nullable|string|max:50',
        'target_audience' => 'required|string',
    ];

    public function getActiveVouchersProperty()
    {
        return voucher::where('is_active', true)
                     ->where(function($q) {
                         $q->whereNull('expired_at')
                           ->orWhere('expired_at', '>=', now());
                     })
                     ->get();
    }

    public function render()
    {
        return view('livewire.admin.marketing.promo-blast', [
            'vouchers' => $this->active_vouchers
        ])->layout('components.layouts.app');
    }

    public function sendPromo()
    {
        $this->validate();

        dispatch(new \App\Jobs\SendPromoBlastJob($this->subject, $this->message, $this->voucher_code, $this->target_audience));

        session()->flash('success', "Promo sedang dikirim ke pelanggan secara *background*.");
        
        $this->reset(['subject', 'message', 'voucher_code', 'target_audience']);
    }
}
