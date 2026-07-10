<?php

namespace App\Mail;

use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TiketPemesanan extends Mailable
{
    use Queueable, SerializesModels;

    public Pemesanan $pesanan;

    public function __construct(Pemesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pemesanan.tiket-pdf', ['pesanan' => $this->pesanan]);

        return $this->subject('E-Tiket Velozza - ' . $this->pesanan->kode_booking)
            ->view('emails.tiket')
            ->attachData($pdf->output(), 'e-tiket-' . $this->pesanan->kode_booking . '.pdf');
    }
}