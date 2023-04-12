<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\ETAItem;
use App\Models\ETA\Invoice;
use App\Models\ETA\InvoiceLine;
use App\Models\ETA\TaxableItem;
use App\Models\ETA\TaxTotal;
use App\Models\ETA\Value;
use App\Models\Discount;
use App\Http\Requests\StoreInvoiceRequest;

class APIController extends Controller
{
	public function updateInvoices(Request $request)
	{
		$data = $request->all();
		foreach($data["acceptedDocuments"] as $document) {
			$invoice = Invoice::where('internalID', '=', $document["internalId"])
						->where(function ($query) {
							$query->where('status', '=', 'approved')
							      ->orWhereNull('status');
					    })->first();
			if (!$invoice) continue;
			$invoice->status = 'processing';
			$invoice->statusreason = 'Sent to ETA for Processing';
			$invoice->uuid = $document["uuid"];
			$invoice->submissionUUID = $data["submissionId"];
			$invoice->longId = $document["longId"];
			$invoice->save();
		}
		foreach($data["rejectedDocuments"] as $document) {
			$invoice = Invoice::where('internalID', '=', $document["internalId"])
						->where(function ($query) {
							$query->where('status', '=', 'approved')
							      ->orWhereNull('status');
					    })->first();
			if (!$invoice) continue;
			$invoice->status = 'rejected';
			$invoice->statusreason = "";
			if (isset($document["error"]["details"])){
				foreach($document["error"]["details"] as $error)
					$invoice->statusreason = $invoice->statusreason . $error["message"] . ",";
			}else{
				$invoice->statusreason = json_encode($document["error"]);
			}
			$invoice->save();
		}
		return response()->json(["status" => "ok"]);
	}
}
