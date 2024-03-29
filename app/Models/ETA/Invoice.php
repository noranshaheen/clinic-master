<?php

namespace App\Models\ETA;

use App\Models\ETA\TaxTotal;
use Illuminate\Support\Facades\DB;

/**
 * Eloquent class to describe the Invoice table.
 *
 * automatically generated by ModelGenerator.php
 */
class Invoice extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'invoice';

    public $primaryKey = 'Id';

    public $timestamps = false;
    protected $casts = [
        'Id' => 'integer',
        'totalDiscountAmount' => 'decimal:5',
        'totalSalesAmount' => 'decimal:5',
        'netAmount' => 'decimal:5',
        'totalAmount' => 'decimal:5',
        'extraDiscountAmount' => 'decimal:5',
        'totalItemsDiscountAmount' => 'decimal:5',
    ];

    protected $fillable = ['issuer_id', 'receiver_id', 'documentType', 'documentTypeVersion', 'dateTimeIssued', 'taxpayerActivityCode',
        'internalID', 'purchaseOrderReference', 'purchaseOrderDescription', 'salesOrderReference', 'salesOrderDescription',
        'proformaInvoiceNumber', 'totalDiscountAmount', 'totalSalesAmount', 'netAmount', 'totalAmount', 'extraDiscountAmount',
        'totalItemsDiscountAmount', 'uuid', 'submissionUUID', 'longId', 'createdByUserId', 'status', 'statusReason', 'upload_id',
        'cancelRequestDate', 'rejectRequestDate', 'cancelRequestDelayedDate', 'rejectRequestDelayedDate', 'declineCancelRequestDate',
        'declineRejectRequestDate',
    ];

    public function getDates()
    {
        return ['dateTimeIssued'];
    }

    public function normalize()
    {
        $salesTotal = 0;
        $total = 0;
        $totalItemsDiscountAmount = 0;
        foreach ($this->invoiceLines as $line) {
            $salesTotal += $line->salesTotal;
            $total += $line->total;
            $totalItemsDiscountAmount += $line->itemsDiscount;
        }
        $this->netAmount = round($salesTotal, 5);
        $this->totalSalesAmount = round($salesTotal, 5);
        $this->totalAmount = round($total, 5);
        $this->totalItemsDiscountAmount = round($totalItemsDiscountAmount, 5);
    }

    public function updateTaxTotals()
    {
        $this->taxTotals()->delete();
        $taxTotals = array();
        foreach ($this->invoiceLines as $line) {
            foreach ($line->taxableItems as $item) {
                if (isset($taxTotals[$item->taxType])) {
                    $taxTotals[$item->taxType] += $item->amount;
                } else {
                    $taxTotals[$item->taxType] = $item->amount;
                }

            }
        }
        foreach ($taxTotals as $key => $item) {
            $totalTax = new TaxTotal();
            $totalTax->taxType = $key;
            $totalTax->amount = $item;
            $totalTax->invoice_id = $this->Id;
            $totalTax->save();
        }
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\ETA\Delivery', 'delivery_id', 'Id');
    }

    public function issuer()
    {
        return $this->belongsTo('App\Models\ETA\Issuer', 'issuer_id', 'Id');
    }

    public function payment()
    {
        return $this->belongsTo('App\Models\ETA\Payment', 'payment_id', 'Id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\ETA\Receiver', 'receiver_id', 'Id');
    }

    public function invoiceLines()
    {
        return $this->hasMany('App\Models\ETA\InvoiceLine', 'invoice_id', 'Id');
    }

    public function taxTotals()
    {
        return $this->hasMany('App\Models\ETA\TaxTotal', 'invoice_id', 'Id');
    }

    public function getDashboardStatisticsByDate($from, $to)
    {

        return DB::select("SELECT
		count(*) as invoicesCount,
		sum(totalSalesAmount) totalSalesAmount,
		sum(totalAmount) totalAmount,
		ifnull(sum(t2.amount), 0) taxTotal,
		ifnull(Status, 'pending') as Status
	from
		invoice t1
		left outer join (
			select
				invoice_id,
				sum( case when taxType = 'T4' then -amount else amount end) as amount
			from
                taxtotal
			group by
				invoice_id
		) t2 on t1.Id = t2.invoice_id
	WHERE
		DATE(t1.dateTimeIssued) >= :from
		AND DATE(t1.dateTimeIssued) <= :to
	group by
		Status", ['from' => $from, 'to' => $to]);
    }

}
