<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\PromoBlastMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPromoBlastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject;
    public $message;
    public $voucherCode;
    public $targetAudience;

    /**
     * Create a new job instance.
     */
    public function __construct($subject, $message, $voucherCode = null, $targetAudience = 'all')
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->voucherCode = $voucherCode;
        $this->targetAudience = $targetAudience;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $query = User::query();

        if ($this->targetAudience === 'inactive_1_month') {
            $query->where('updated_at', '<', now()->subDays(30));
        }

        $users = $query->get();
        $count = 0;

        foreach ($users as $user) {
            if ($user->email) {
                Mail::to($user->email)->send(new PromoBlastMail($this->subject, $this->message, $this->voucherCode));
                $count++;
            }
        }

        Log::info("Promo Blast Job Completed. Sent to {$count} users.");
    }
}
