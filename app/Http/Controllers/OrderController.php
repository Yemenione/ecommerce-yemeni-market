<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function invoice(Order $order)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', ['order' => $order]);
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}
