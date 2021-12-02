<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyItemBelowStockReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $items;
    public $branch;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($items, $branch)
    {
        $this->items = $items;
        $this->branch = $branch;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Report Barang Kurang Dari Stok Minimum')
            ->view('mailsTemplate.weeklyItemBelowStockTemplate')
            ->from('rafale766@gmail.com');
    }
}
