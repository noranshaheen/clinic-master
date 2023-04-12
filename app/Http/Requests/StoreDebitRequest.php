<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Http\Traits\RequestManipulators;

class StoreDebitRequest extends FormRequest
{
	use RequestManipulators;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
	
	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$data = $this->all();
		$data = $this->convertKeysToCamelCase($data);
		
		//calculcate tax totals
		$taxTotals = [];
		$taxTotals2 = [];
		foreach($data['invoiceLines'] as $item) {
			//credit note send taxableItems -> convert it to taxitems
			$item['taxItems'] = $item['taxableItems'];
			foreach($item['taxItems'] as $taxItem) {
				$key1 = '';
				$key1 = $taxItem['taxType'];
				$value = floatval($taxItem['amount']);
				if (array_key_exists($key1, $taxTotals)) {
					$taxTotals[$key1] = $taxTotals[$key1] + $value;
				} else {
					$taxTotals[$key1] = $value;
				}
			}
		}
		foreach($taxTotals as $key=>$val) {
			$taxTotals2=array_merge($taxTotals2, [['taxType'=>$key, 'amount'=>$val]]);
		}
		//add parameters again after finished adding missing information
		$this->merge($data);

		//add missing attributes
		$this->merge(["documentType"			=> "D",
						 "documentTypeVersion"	=> SETTINGS_VAL('application settings', 'invoiceVersion', '1.0'),
						 "issuer"				=> array_merge(["id" => $data['issuer']['issuerId']], $data['issuer']),
						 "receiver"				=> array_merge(["id" => $data['receiver']['receiverId']], $data['receiver']),
						 "taxTotals"			=> $taxTotals2
		]);
		
	}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		return [
			'issuer' 								=> ['required'],
			'issuer.type'  							=> ['required'],
			'issuer.id'  							=> ['required'],
			'issuer.name' 							=> ['required'],
			'receiver' 								=> ['required'],
			'receiver.type' 						=> ['required'],
			'receiver.id' 							=> ['required'],
			'receiver.name' 						=> ['required'],
			'documentType' 							=> ['required', Rule::in(['I', 'C', 'D'])],
			'documentTypeVersion' 					=> ['required', Rule::in(['0.9', '1.0'])],
			'dateTimeIssued' 						=> ['required', 'date'],
			'taxpayerActivityCode' 					=> ['required'],
			'internalID' 							=> ['required'],
			'purchaseOrderReference' 				=> ['nullable'],
			'purchaseOrderDescription' 				=> ['nullable'],
			'salesOrderReference' 					=> ['nullable'],
			'salesOrderDescription' 				=> ['nullable'],
			'proformaInvoiceNumber'					=> ['nullable'],
			'invoiceLines' 							=> ['required', 'array', 'min:1'],
			'invoiceLines.*.description' 			=> ['required'],
			'invoiceLines.*.itemType'				=> ['required', Rule::in(['EGS', 'GS1'])],
			'invoiceLines.*.itemCode'				=> ['required', 'regex:/[0-9]+|EG-[0-9]+-[A-Za-z0-9_]+/'],
			'invoiceLines.*.unitType'				=> ['required', 'string'],
			'invoiceLines.*.quantity'				=> ['required', 'numeric'],
			'invoiceLines.*.internalCode' 			=> ['required', 'string'],
			'invoiceLines.*.salesTotal' 			=> ['required', 'numeric'],
			'invoiceLines.*.total' 					=> ['required', 'numeric'],
			'invoiceLines.*.valueDifference' 		=> ['required', 'numeric'],
			'invoiceLines.*.totalTaxableFees' 		=> ['required', 'numeric'],
			'invoiceLines.*.netTotal' 				=> ['required', 'numeric'],
			'invoiceLines.*.itemsDiscount'			=> ['required', 'numeric'],
			'invoiceLines.*.unitValue' 				=> ['required'],
			'invoiceLines.*.unitValue.currencySold' => ['required', Rule::in(['EGP', 'USD', 'EUR', 'GBP'])],
			'invoiceLines.*.unitValue.amountEGP' 	=> ['required', 'numeric'],
			'invoiceLines.*.unitValue.amountSold' 	=> ['numeric'],
			'invoiceLines.*.itemsDiscount' 			=> ['required', 'numeric'],
			'invoiceLines.*.taxableItems' 			=> ['array', 'min:0'],
			'invoiceLines.*.taxableItems.*.taxType' => ['required'],
			'invoiceLines.*.taxableItems.*.amount' 	=> ['required', 'numeric'],
			'invoiceLines.*.taxableItems.*.subType' => ['required'],
			'invoiceLines.*.taxableItems.*.rate' 	=> ['required', 'numeric'],
			'totalDiscountAmount' 					=> ['required', 'numeric'],
			'totalSalesAmount' 						=> ['required', 'numeric'],
			'netAmount' 							=> ['required', 'numeric'],
			'taxTotals' 							=> ['array'],
			'taxTotals.*.taxType' 					=> ['required', Rule::in(['T1','T2','T3','T4','T5',
																			'T6','T7','T8','T9','T10','T11',
																			'T12','T13','T14','T15','T16','T17',
																			'T18', 'T19', 'T20'])],
			'taxTotals.*.amount' 					=> ['required', 'numeric'],
			'totalAmount' 							=> ['required', 'numeric'],
			'extraDiscountAmount' 					=> ['required', 'numeric'],
			'totalItemsDiscountAmount' 				=> ['required', 'numeric']
        ];
    }
}
