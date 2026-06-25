<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeCustomerMail;
use App\Models\Admin;
use App\Notifications\AdminNotification;

class SendWelcomeEmail
{
    public function __construct()
    {
        //
    }

    public function handle(Registered $event): void
    {
        Mail::to($event->user->email)->send(new WelcomeCustomerMail($event->user));

        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new AdminNotification(
                'Pelanggan Baru Mendaftar',
                $event->user->name . ' baru saja mendaftar sebagai pelanggan.',
                '/admin/customers/' . $event->user->id
            ));
        }
    }
}
