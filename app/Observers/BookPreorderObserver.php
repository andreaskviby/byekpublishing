<?php

namespace App\Observers;

use App\Models\BookPreorder;

class BookPreorderObserver
{
    /**
     * Handle the BookPreorder "created" event.
     */
    public function created(BookPreorder $bookPreorder): void
    {
        //
    }

    /**
     * Handle the BookPreorder "updated" event.
     */
    public function updated(BookPreorder $bookPreorder): void
    {
        if ($bookPreorder->isDirty('payment_status')) {
            $oldStatus = $bookPreorder->getOriginal('payment_status');
            $newStatus = $bookPreorder->payment_status;

            // Send payment confirmation email when status changes to 'paid'
            if ($oldStatus !== 'paid' && $newStatus === 'paid') {
                $bookPreorder->sendPaymentConfirmationEmail();
            }

            // Send shipping confirmation email when status changes to 'sent'
            if ($oldStatus !== 'sent' && $newStatus === 'sent') {
                $bookPreorder->sendShippingConfirmationEmail();
            }
        }
    }

    /**
     * Handle the BookPreorder "deleted" event.
     */
    public function deleted(BookPreorder $bookPreorder): void
    {
        //
    }

    /**
     * Handle the BookPreorder "restored" event.
     */
    public function restored(BookPreorder $bookPreorder): void
    {
        //
    }

    /**
     * Handle the BookPreorder "force deleted" event.
     */
    public function forceDeleted(BookPreorder $bookPreorder): void
    {
        //
    }
}
