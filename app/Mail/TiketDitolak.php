<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TiketDitolak extends Mailable
{
    use Queueable, SerializesModels;

    public Pemesanan $pesanan;

    public function __construct(Pemesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function build()
    {
        return $this->subject('Pembayaran Ditolak - ' . $this->pesanan->kode_booking)
            ->view('emails.ditolak');
    }
}