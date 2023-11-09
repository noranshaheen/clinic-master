<?php

namespace App\Http\Controllers;

use App\Models\ETA\Invoice;
use App\Models\Payment;
use App\Models\Prescription;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class PDFController extends Controller
{
    public function previewInvoice($id)
    {
        $data = Invoice::with('issuer')
            ->with("receiver")
            ->with("invoiceLines")
            ->with("invoiceLines.unitValue")
            ->with("taxTotals")
            ->with("invoiceLines.taxableItems")
            ->with('receiver.address')
            ->find($id);
        return view('pdf.bill', compact('data'));
    }

    public function previewPayment($id)
    {
        // $data = Payment::with('doctor')
        //     ->with('appointment')
        //     ->with('patient')
        //     ->with('appointment.prescription')
        //     ->with('appointment.prescription.prescriptionItems')
        //     ->with('appointment.prescription.prescriptionItems.drugs')
        //     ->find($id);

            $data = Payment::where('appointment_id', '=', $id)
            ->with('patient')
            ->with('appointment')
            ->with('appointment.prescription')
            ->with('appointment.fees')
            ->with('doctor')
            ->get();
            // ->groupBy('date');

            // dd($data);
        return view('pdf.paymentBill', compact('data'));
    }

    public function previewPrescription($id)
    {
        $data = Prescription::with('doctor')
            ->with('doctor.specialties')
            ->with('prescriptionItems')
            ->with('prescriptionItems.drug')
            ->with('prescriptionItems.service')
            ->with('appointment')
            ->with('appointment.payments')
            ->with('patient')
            ->find($id);
            // dd($data);
        return view('pdf.prescription', compact('data'));
    }

    public function previewInvoices($ids)
    {
        $ids = explode(',', $ids);
        $invoices = Invoice::with('issuer')
            ->with("receiver")
            ->with("invoiceLines")
            ->with("invoiceLines.unitValue")
            ->with("taxTotals")
            ->with("invoiceLines.taxableItems")
            ->with('receiver.address')
            ->whereIn('id', $ids)
            ->get();
        return view('pdf.bills', compact('invoices'));
    }

    public function downloadInvoice(int $id, PDF $pdf)
    {
        $data = Invoice::with('issuer')
            ->with("receiver")
            ->with("invoiceLines")
            ->with("invoiceLines.unitValue")
            ->with("taxTotals")
            ->with("invoiceLines.taxableItems")
            ->with('receiver.address')
            ->find($id);
        //return view('pdf.saveInvoice', compact('data'));
        return PDF::loadView('pdf.saveInvoice', [
            'data' => $data
        ])->download("{$id}.pdf");
    }
    public function downloadPayment(int $id)
    {
        $data = Payment::where('appointment_id', '=', $id)
        ->with('patient')
        ->with('appointment')
        ->with('appointment.prescription')
        ->with('appointment.fees')
        ->with('doctor')
        ->get();
        //return view('pdf.saveInvoice', compact('data'));
        $pdf = PDF::loadView('pdf.savePayment', [
            'data' => $data
        ])->download("{$id}.pdf");
        return $pdf;
    }
}
