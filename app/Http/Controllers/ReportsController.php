<?php

namespace App\Http\Controllers;

use App\Exports\ReportSummaryExport;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\ETA\Address;
use App\Models\ETAItem;
use App\Models\ETAInvoice;
use App\Models\ETA\Invoice;
use App\Models\ETA\InvoiceLine;
use App\Models\ETA\TaxableItem;
use App\Models\ETA\TaxTotal;
use App\Models\ETA\Value;
use App\Models\Discount;
use App\Models\ETA\Receiver;
use App\Models\ETA\Issuer;
use App\Models\General\Upload;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Traits\ExcelWrapper;

class ReportsController extends Controller
{
	use ExcelWrapper;
	
	private $mValue;
	public function summary()
	{
        return Inertia::render('Reports/Summary', [
        ]);
	}

	public function summaryData(Request $request)
	{
		$branchId   = $request->input('issuer')['Id'];
		$customerId = $request->input('receiver')['Id'];
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$status		= $request->input('status');

		$strSqlStmt1 = "select t1.internalID as Id, month(t1.dateTimeIssued) as Month, CAST(t1.dateTimeIssued as date) as Date, 
							sum(t5.amount) as TaxTotal, t4.name as Client, t1.totalAmount as Total, 
							t1.Id as LID
						from Invoice t1 inner join InvoiceLine t2 on t1.Id = t2.invoice_id
							inner join Issuer t3 on t3.Id = t1.issuer_id
							inner join Receiver t4 on t4.Id = t1.receiver_id
						    left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where (t1.issuer_id = ? or ? = -1)
							and   (t1.receiver_id = ? or ? = -1)
							and CAST(t1.dateTimeIssued as date) between ? and ? and (t1.status = ? or ? = 'all')
						group by t1.internalID, month(t1.dateTimeIssued), CAST(t1.dateTimeIssued as date), t4.name, t1.totalAmount, t1.Id";
		$data = DB::select($strSqlStmt1, [$branchId, $branchId, $customerId, $customerId, $startDate, $endDate, $status, $status]);
		return $data;
	}
	
	public function summaryDownload(Request $request)
	{
		$branchId   = $request->input('issuer')['Id'];
		$customerId = $request->input('receiver')['Id'];
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$status		= $request->input('status');
		//$branchId   = -1;
		//$customerId = -1;
		//$startDate  = "2019-10-10";
		//$endDate    = "2030-10-10";
		
		$strSqlStmt1 = "select t1.Id as InvKey, t1.internalID as Id, month(t1.dateTimeIssued) as Month, date_format(t1.dateTimeIssued, '%d/%m/%Y') as Date, 
							sum(t5.amount) as TaxTotal, t4.name as Client, t1.totalSalesAmount as Total, t4.code as Code,
							t1.documentType as docType, t3.name as BranchName
						from Invoice t1  
							inner join Receiver t4 on t4.Id = t1.receiver_id
							inner join Issuer t3 on t3.Id = t1.issuer_id
						    left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where (t1.issuer_id = ? or ? = -1)
							and   (t1.receiver_id = ? or ? = -1)
							and CAST(t1.dateTimeIssued as date) between ? and ? and (t1.status = ? or ? = 'all')
						group by t1.Id, t1.internalID, month(t1.dateTimeIssued), CAST(t1.dateTimeIssued as date), t4.name, t1.totalAmount, 
						t4.code, t1.totalSalesAmount, t1.documentType, t1.dateTimeIssued, t3.name";
		$data1 = DB::select($strSqlStmt1, [$branchId, $branchId, $customerId, $customerId, $startDate, $endDate, $status, $status]);
		$strSqlStmt2 = "select t1.Id as InvKey, trim(t2.description) as 'Desc', t2.itemCode as Code, round(sum(t2.quantity), 5) as Quantity,
							round(sum(t2.salesTotal), 5) as Total, round(sum(t7.amountEGP), 5) as UnitValue, round(sum(t2.itemsDiscount),5) as Discount
						from Invoice t1 inner join InvoiceLine t2 on t1.Id = t2.invoice_id
						    inner join Value t7 on t7.Id = t2.unitValue_id
						where (t1.issuer_id = ? or ? = -1)
							and   (t1.receiver_id = ? or ? = -1)
							and CAST(t1.dateTimeIssued as date) between ? and ? and (t1.status = ? or ? = 'all')
						group by t1.Id, trim(t2.description), t2.itemCode";
		$data2 = DB::select($strSqlStmt2, [$branchId, $branchId, $customerId, $customerId, $startDate, $endDate, $status, $status]);
		$items = array();
		foreach($data2 as $invLine)
			array_push($items, array('Code' => $invLine->Code, 'Desc' => $invLine->Desc));
		//remvoe duplicates from $items
		$items = array_map("unserialize", array_unique(array_map("serialize", $items)));
		
		foreach($data1 as $key=>$val)
		{
			$this->mValue = $val->InvKey;
			$invLines = array_filter($data2, function($v, $k) {
							    return  $v->InvKey == $this->mValue;
						}, ARRAY_FILTER_USE_BOTH);
			$data1[$key]->lines = array();
			foreach($invLines as $invLine)
				$data1[$key]->lines[$invLine->Code] = $invLine;

		}
		//render excel file now
		$reader = IOFactory::createReader('Xlsx');
		$file = $reader->load('./ExcelTemplates/SalesReport.xlsx');
		
		//prepare the headers
		$colIdx = 10;
		$itemIdx = 1;
		foreach($items as $col){
			//merge cells
			$file->getActiveSheet()->mergeCells($this->index($colIdx,1).':'.$this->index($colIdx+4,1));
			$file->getActiveSheet()->mergeCells($this->index($colIdx,2).':'.$this->index($colIdx+4,2));

			$file->getActiveSheet()->setCellValue($this->index($colIdx,1), $col["Code"]);
			$file->getActiveSheet()->setCellValue($this->index($colIdx,2), $col["Desc"]);
			
			$file->getActiveSheet()->setCellValue($this->index($colIdx+0,3), "قيمة");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+1,3), "كميه");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+2,3), "خصم");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+3,3), "ضريبة");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+4,3), "سعر");

			$file->getActiveSheet()->setCellValue($this->index($colIdx+0,4), "قيمة".$itemIdx);
			$file->getActiveSheet()->setCellValue($this->index($colIdx+1,4), "كميه".$itemIdx);
			$file->getActiveSheet()->setCellValue($this->index($colIdx+2,4), "خصم".$itemIdx);
			$file->getActiveSheet()->setCellValue($this->index($colIdx+3,4), "ضريبة".$itemIdx);
			$file->getActiveSheet()->setCellValue($this->index($colIdx+4,4), "سعر".$itemIdx);
			
			$itemIdx +=1 ;
			$colIdx += 5;
		}
		//copy cell format
		$cellStyle = $file->getActiveSheet()->getStyle($this->index(10,2));
		$file->getActiveSheet()->duplicateStyle($cellStyle, $this->index(11,2).':'.$this->index(count($items)*5+9,2));

		$cellStyle = $file->getActiveSheet()->getStyle($this->index(2,3));
		$file->getActiveSheet()->duplicateStyle($cellStyle, $this->index(3,3).':'.$this->index(9+count($items)*5,3));
		
		$cellStyle = $file->getActiveSheet()->getStyle($this->index(2,3));
		$file->getActiveSheet()->duplicateStyle($cellStyle, $this->index(3,3).':'.$this->index(9+count($items)*5,3));
		
		//fill the data
		$rowIdx = 5;
		foreach($data1 as $row){
			$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), $row->Id);
			$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), $row->Month);
			$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $row->Date);
			$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $row->BranchName);
			$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $row->TaxTotal);
			$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), $row->Code);
			$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), $row->Client);
			$file->getActiveSheet()->setCellValue($this->index(9,$rowIdx), $row->Total);

			if (strtolower($row->docType) == 'i'){
				//set row color to green
				$file->getActiveSheet()
					->getStyle($this->index(2,$rowIdx).':'.$this->index(9+count($items)*5,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('FFFFFF');
			}else{
				//set row color to orange
				$file->getActiveSheet()->getStyle($this->index(2,$rowIdx).':'.$this->index(9+count($items)*5,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()->setARGB('F4B084');
			}
			
			
			$colIdx = 10;
			foreach($items as $col){
				if (array_key_exists($col["Code"], $row->lines)){
					if ($col["Desc"] ==  $row->lines[$col["Code"]]->Desc){
						//$file->getActiveSheet()->setCellValue($this->index($colIdx+0,$rowIdx), $row->lines[$col["Code"]]->UnitValue);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+0,$rowIdx), round($row->lines[$col["Code"]]->Total / $row->lines[$col["Code"]]->Quantity, 5));
						$file->getActiveSheet()->setCellValue($this->index($colIdx+1,$rowIdx), $row->lines[$col["Code"]]->Quantity);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+2,$rowIdx), $row->lines[$col["Code"]]->Discount);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+3,$rowIdx), 0);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+4,$rowIdx), $row->lines[$col["Code"]]->Total);
					}
				}
				$colIdx += 5;
			}
			$rowIdx++;
		}
		//set bordres for all cells in active worksheet
		$file->getActiveSheet()->getStyle($this->index(2,3).':'.$this->index(9+count($items)*5,$rowIdx-1))
			->getBorders()
			->getAllBorders()
			->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//set auto filter
		$file->getActiveSheet()->setAutoFilter($this->index(2,4).':'.$this->index(9+count($items)*5,$rowIdx));
		//set column width
		//TODO MFayez
		//$file->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	
		$writer = IOFactory::createWriter($file, 'Xlsx');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Sales_ExportedData.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');		
	}

	public function summaryDownloadNew(Request $request)
	{
		$branchId   = $request->input('issuer')['Id'];
		$customerId = $request->input('receiver')['Id'];
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$status		= $request->input('status');
		//$branchId   = -1;
		//$customerId = -1;
		//$startDate  = "2019-10-10";
		//$endDate    = "2030-10-10";
		
		$strSqlStmt1 = "select t1.Id as InvKey, t1.internalID as Id, month(t1.dateTimeIssued) as Month, date_format(t1.dateTimeIssued, '%d/%m/%Y') as Date, 
							ifnull(sum(case when t5.taxType = 'T4' then 0 else t5.amount end), 0) as TaxTotal, t4.name as Client,
							ifnull(sum(case when t5.taxType = 'T4' then t5.amount else 0 end), 0) as TaxT4,
							t1.totalSalesAmount as Total, t4.code as Code, t4.receiver_id as RTaxID, t1.totalAmount as TotalAmount,
							t1.documentType as docType, t3.name as BranchName
						from Invoice t1  
							inner join Receiver t4 on t4.Id = t1.receiver_id
							inner join Issuer t3 on t3.Id = t1.issuer_id
						    left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where (t1.issuer_id = ? or ? = -1)
							and   (t1.receiver_id = ? or ? = -1)
							and CAST(t1.dateTimeIssued as date) between ? and ? and (t1.status = ? or ? = 'all')
						group by t1.Id, t1.internalID, month(t1.dateTimeIssued), CAST(t1.dateTimeIssued as date), t4.name, t1.totalAmount, 
						t4.code, t4.receiver_id, t1.totalSalesAmount, t1.documentType, t1.dateTimeIssued, t3.name";
		$data1 = DB::select($strSqlStmt1, [$branchId, $branchId, $customerId, $customerId, $startDate, $endDate, $status, $status]);
		$strSqlStmt2 = "select t1.Id as InvKey, trim(t2.description) as 'Desc', t2.itemCode as Code, round(sum(t2.quantity), 5) as Quantity,
							round(sum(t2.salesTotal), 5) as Total, round(sum(t7.amountEGP), 5) as UnitValue, round(sum(t2.itemsDiscount),5) as Discount
						from Invoice t1 inner join InvoiceLine t2 on t1.Id = t2.invoice_id
						    inner join Value t7 on t7.Id = t2.unitValue_id
						where (t1.issuer_id = ? or ? = -1)
							and   (t1.receiver_id = ? or ? = -1)
							and CAST(t1.dateTimeIssued as date) between ? and ? and (t1.status = ? or ? = 'all')
						group by t1.Id, trim(t2.description), t2.itemCode";
		$data2 = DB::select($strSqlStmt2, [$branchId, $branchId, $customerId, $customerId, $startDate, $endDate, $status, $status]);
		$items = array();
		foreach($data2 as $invLine)
			array_push($items, array('Code' => $invLine->Code, 'Desc' => $invLine->Desc));
		//remvoe duplicates from $items
		$items = array_map("unserialize", array_unique(array_map("serialize", $items)));
		
		foreach($data1 as $key=>$val)
		{
			$this->mValue = $val->InvKey;
			$invLines = array_filter($data2, function($v, $k) {
							    return  $v->InvKey == $this->mValue;
						}, ARRAY_FILTER_USE_BOTH);
			$data1[$key]->lines = array();
			foreach($invLines as $invLine)
				$data1[$key]->lines[$invLine->Code] = $invLine;

		}
		//render excel file now
		$reader = IOFactory::createReader('Xlsx');
		$file = $reader->load('./ExcelTemplates/SalesReportNew.xlsx');
		
		//prepare the headers
		$colIdx = 13;
		foreach($items as $col){
			//merge cells
			$file->getActiveSheet()->mergeCells($this->index($colIdx,1).':'.$this->index($colIdx+2,1));
			$file->getActiveSheet()->mergeCells($this->index($colIdx,2).':'.$this->index($colIdx+2,2));

			$file->getActiveSheet()->setCellValue($this->index($colIdx,1), $col["Code"]);
			$file->getActiveSheet()->setCellValue($this->index($colIdx,2), $col["Desc"]);
			
			$file->getActiveSheet()->setCellValue($this->index($colIdx+0,3), "سعر");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+1,3), "كميه");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+2,3), "القيمة");
			
			$colIdx += 3;
		}
		//copy cell format
		$cellStyle = $file->getActiveSheet()->getStyle($this->index(13,2));
		$file->getActiveSheet()->duplicateStyle($cellStyle, $this->index(13,2).':'.$this->index(count($items)*3+5,2));

		$cellStyle = $file->getActiveSheet()->getStyle($this->index(2,3));
		$file->getActiveSheet()->duplicateStyle($cellStyle, $this->index(3,3).':'.$this->index(9+count($items)*5,3));
		
		//fill the data
		$rowIdx = 4;
		$serial = 1;
		foreach($data1 as $row){
			$file->getActiveSheet()->setCellValue($this->index(1,$rowIdx), $serial++);
			$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), $row->Id);
			$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), $row->Month);
			$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $row->Date);
			$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $row->BranchName);
			$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $row->Code);
			$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), $row->RTaxID);
			$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), $row->Client);
			$file->getActiveSheet()->setCellValue($this->index(9,$rowIdx), $row->TotalAmount);
			$file->getActiveSheet()->setCellValue($this->index(10,$rowIdx), $row->TaxT4);
			$file->getActiveSheet()->setCellValue($this->index(11,$rowIdx), $row->TaxTotal);
			$file->getActiveSheet()->setCellValue($this->index(12,$rowIdx), $row->Total);


			if (strtolower($row->docType) == 'i'){
				//set row color to green
				$file->getActiveSheet()
					->getStyle($this->index(1,$rowIdx).':'.$this->index(12+count($items)*3,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('FFFFFF');
			}else if (strtolower($row->docType) == 'c'){
				//set row color to orange
				$file->getActiveSheet()->getStyle($this->index(1,$rowIdx).':'.$this->index(12+count($items)*3,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()->setARGB('FF5555');
			} else {
				//set row color to red
				$file->getActiveSheet()->getStyle($this->index(1,$rowIdx).':'.$this->index(12+count($items)*3,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()->setARGB('55FF55');
			}
			
			
			$colIdx = 13;
			foreach($items as $col){
				if (array_key_exists($col["Code"], $row->lines)){
					if ($col["Desc"] ==  $row->lines[$col["Code"]]->Desc){
						//$file->getActiveSheet()->setCellValue($this->index($colIdx+0,$rowIdx), $row->lines[$col["Code"]]->UnitValue);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+0,$rowIdx), round($row->lines[$col["Code"]]->Total / $row->lines[$col["Code"]]->Quantity, 5));
						$file->getActiveSheet()->setCellValue($this->index($colIdx+1,$rowIdx), $row->lines[$col["Code"]]->Quantity);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+2,$rowIdx), $row->lines[$col["Code"]]->Total);
					}
				}
				$colIdx += 3;
			}
			$rowIdx++;
		}
		//set bordres for all cells in active worksheet
		$file->getActiveSheet()->getStyle($this->index(2,3).':'.$this->index(12+count($items)*3,$rowIdx-1))
			->getBorders()
			->getAllBorders()
			->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//set auto filter
		$file->getActiveSheet()->setAutoFilter($this->index(1,3).':'.$this->index(12+count($items)*3,$rowIdx));
		//set column width
		//TODO MFayez
		//$file->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	
		$writer = IOFactory::createWriter($file, 'Xlsx');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Sales_ExportedData.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');		
	}

	public function summaryDownloadCompact(Request $request)
	{
		$branchId   = $request->input('issuer')['Id'];
		$customerId = $request->input('receiver')['Id'];
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$status		= $request->input('status');
		//$branchId   = -1;
		//$customerId = -1;
		//$startDate  = "2019-10-10";
		//$endDate    = "2030-10-10";
		
		$strSqlStmt1 = "select t1.Id as InvKey, t1.internalID as Id, month(t1.dateTimeIssued) as Month, date_format(t1.dateTimeIssued, '%d/%m/%Y') as Date, 
							sum(t5.amount) as TaxTotal, t4.name as Client, t1.totalSalesAmount as Total, t4.code as Code,
							t1.documentType as docType, t3.name as BranchName
						from Invoice t1  
							inner join Receiver t4 on t4.Id = t1.receiver_id
							inner join Issuer t3 on t3.Id = t1.issuer_id
						    left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where (t1.issuer_id = ? or ? = -1)
							and   (t1.receiver_id = ? or ? = -1)
							and CAST(t1.dateTimeIssued as date) between ? and ? and (t1.status = ? or ? = 'all')
						group by t1.Id, t1.internalID, month(t1.dateTimeIssued), CAST(t1.dateTimeIssued as date), t4.name, t1.totalAmount, 
						t4.code, t1.totalSalesAmount, t1.documentType, t1.dateTimeIssued, t3.name";
		$data1 = DB::select($strSqlStmt1, [$branchId, $branchId, $customerId, $customerId, $startDate, $endDate, $status, $status]);
		$strSqlStmt2 = "select t1.Id as InvKey, trim(t2.description) as 'Desc', t2.itemCode as Code, t2.quantity as Quantity,
							t2.salesTotal as SalesTotal, t7.amountEGP as UnitValue, t2.itemsDiscount as Discount, t2.total as Total,
							t2.itemsDiscount as Discount
						from Invoice t1 inner join InvoiceLine t2 on t1.Id = t2.invoice_id
						    inner join Value t7 on t7.Id = t2.unitValue_id
						where (t1.issuer_id = ? or ? = -1)
							and   (t1.receiver_id = ? or ? = -1)
							and CAST(t1.dateTimeIssued as date) between ? and ? and (t1.status = ? or ? = 'all')";
		$data2 = DB::select($strSqlStmt2, [$branchId, $branchId, $customerId, $customerId, $startDate, $endDate, $status, $status]);
		$items = array();
		foreach($data2 as $invLine)
			array_push($items, array('Code' => $invLine->Code, 'Desc' => $invLine->Desc));
		//remvoe duplicates from $items
		$items = array_map("unserialize", array_unique(array_map("serialize", $items)));
		
		foreach($data1 as $key=>$val)
		{
			$this->mValue = $val->InvKey;
			$data1[$key]->lines = array_filter($data2, function($v, $k) {
							    return  $v->InvKey == $this->mValue;
						}, ARRAY_FILTER_USE_BOTH);
		}
		//render excel file now
		$reader = IOFactory::createReader('Xlsx');
		$file = $reader->load('./ExcelTemplates/SalesReportCompact.xlsx');
		
		//fill the data
		$rowIdx = 2;
		$serial = 1;
		foreach($data1 as $row){
			foreach($row->lines as $line){
				$file->getActiveSheet()->setCellValue($this->index(1,$rowIdx), $serial);
				$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), $row->Id);
				$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), $row->Month);
				$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $row->Date);
				$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $row->BranchName);
				$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $row->Code);
				$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), $row->Client);
				$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), $line->Code);
				$file->getActiveSheet()->setCellValue($this->index(9,$rowIdx), $line->Desc);
				$file->getActiveSheet()->setCellValue($this->index(10,$rowIdx), $line->UnitValue);
				$file->getActiveSheet()->setCellValue($this->index(11,$rowIdx), $line->Quantity);
				$file->getActiveSheet()->setCellValue($this->index(12,$rowIdx), $line->SalesTotal);
				$file->getActiveSheet()->setCellValue($this->index(13,$rowIdx), $line->Discount);
				$file->getActiveSheet()->setCellValue($this->index(14,$rowIdx), round($line->SalesTotal - $line->Discount, 5));
				$file->getActiveSheet()->setCellValue($this->index(15,$rowIdx), round($line->Total - $line->SalesTotal + $line->Discount, 5));
				$file->getActiveSheet()->setCellValue($this->index(16,$rowIdx), $line->Total);
				
				$serial = $serial + 1;
				
				if (strtolower($row->docType) == 'i'){
					//set row color to green
					$file->getActiveSheet()->getStyle($this->index(1,$rowIdx).':'.$this->index(16,$rowIdx))
						->getfill()
						->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('FFFFFF');
				}else{
					//set row color to orange
					$file->getActiveSheet()->getStyle($this->index(1,$rowIdx).':'.$this->index(16,$rowIdx))
						->getfill()
						->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
						->getStartColor()->setARGB('F4B084');
				}
				
				$rowIdx++;
			}
		}
		//set bordres for all cells in active worksheet
		$file->getActiveSheet()->getStyle($this->index(1,1).':'.$this->index(16,$rowIdx-1))
			->getBorders()
			->getAllBorders()
			->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//set auto filter
		$file->getActiveSheet()->setAutoFilter($this->index(1,1).':'.$this->index(16,$rowIdx-1));
		
		$writer = IOFactory::createWriter($file, 'Xlsx');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Sales_ExportedData.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');		
	}

	public function purchase()
	{
        return Inertia::render('Reports/Purchase', [
        ]);
	}

	public function purchaseData(Request $request)
	{
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$vendorId	= $request->input('vendor')['id'];
		$strSqlStmt1 = "select t1.internalID as Id, month(t1.dateTimeIssued) as Month, CAST(t1.dateTimeIssued as date) as Date, 
							t1.issuerName as Seller, t1.issuerId as SellerTaxId, t1.totalSales as Sales, t1.netAmount as Net, t1.total as Total,
							t1.Id as LID
						from ETAInvoices t1 
						where (issuerId = ? or ? = -1) 
						and CAST(t1.dateTimeIssued as date) between ? and ? 
						and t1.status = 'Valid'";
		$data = DB::select($strSqlStmt1, [$vendorId, $vendorId, $startDate, $endDate]);
		return $data;
	}
	
	public function purchaseDownload(Request $request)
	{
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$vendorId	= $request->input('vendor')['id'];
		$strSqlStmt1 = "select t1.internalID as Id, month(t1.dateTimeIssued) as Month, CAST(t1.dateTimeIssued as date) as Date, 
							t1.issuerName as Seller, t1.issuerId as SellerTaxId, t1.totalSales as Sales, t1.netAmount as Net, t1.total as Total
						from ETAInvoices t1 
						where (issuerId = ? or ? = -1) 
						and CAST(t1.dateTimeIssued as date) between ? and ? 
						and t1.status = 'Valid'";
		$data = DB::select($strSqlStmt1, [$vendorId, $vendorId, $startDate, $endDate]);
		
		//render excel file now
		$reader = IOFactory::createReader('Xlsx');
		$file = $reader->load('./ExcelTemplates/PurchaseReport.xlsx');
		$rowIdx = 4;
		foreach($data as $row){
			$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), $row->Id);
			$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), $row->Month);
			$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $row->Date);
			$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), round($row->Total - $row->Net, 2));
			$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $row->SellerTaxId);
			$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), $row->Seller);
			$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), $row->Total);
			$rowIdx++;
		}
		$writer = IOFactory::createWriter($file, 'Xlsx');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Purchase_ExportedData.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function purchaseDownloadSummary(Request $request)
	{
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$vendorId	= $request->input('vendor')['id'];
		$strSqlStmt1 = "select t1.Id as InvKey, t1.internalID as Id, month(t1.dateTimeIssued) as Month, date_format(t1.dateTimeIssued, '%d/%m/%Y') as Date, 
							t1.issuerName as Seller, t1.issuerId as SellerTaxId, t1.totalSales as Total, t1.total as TotalAmount, t1.typeName as docType,
							t1.document as Document
						from ETAInvoices t1 
						where (issuerId = ? or ? = -1) 
						and CAST(t1.dateTimeIssued as date) between ? and ? 
						and t1.status = 'Valid'";

		$data = DB::select($strSqlStmt1, [$vendorId, $vendorId, $startDate, $endDate]);
		$data2 = array();
		foreach($data as $key=>$row){
			$data[$key]->T4 = 0;
			$data[$key]->TX = 0;
			if(strlen($row->Document) < 10) {
				continue;
			}
			
			$original_doc = json_decode($row->Document);
			if (!$original_doc || !property_exists($original_doc, 'invoiceLines')){
				//try parse xml
				$original_doc = simplexml_load_string($row->Document);
				if (!$original_doc){
				continue;
				}
			}
			
			//find tax types and add it to the array
			if(property_exists($original_doc, 'taxTotals')) {
				$taxItems = $original_doc->taxTotals;
				foreach($taxItems as $taxItem){
					if($taxItem->taxType == 'T4')
					$data[$key]->T4 += $taxItem->amount;
					else
					$data[$key]->TX += $taxItem->amount;
				}
			}

			//explode invoice lines and add them to data2
			if(property_exists($original_doc, 'invoiceLines')) {
				if (is_array($original_doc->invoiceLines))
					$invoice_lines = $original_doc->invoiceLines;
				else
					$invoice_lines = $original_doc->invoiceLines->invoiceLine;
				foreach($invoice_lines as $line){
					array_push($data2, array("InvKey" => $row->InvKey,
								"Desc" => (string) $line->description,
								"Code" => (string) $line->itemCode,
								"Quantity" => floatval($line->quantity),
								"Total" => floatval($line->salesTotal),
								"UnitValue" => floatval($line->unitValue->amountEGP),
								"Discount" => 0));//$line->discount ? $line->discount->amount : 0));
								//todo mfayez fix discount
				}
			}
		}

		$items = array();
		foreach($data2 as $invLine)
			array_push($items, array('Code' => $invLine['Code'], 'Desc' => $invLine['Desc']));
		//remvoe duplicates from $items
		$items = array_map("unserialize", array_unique(array_map("serialize", $items)));

		foreach($data as $key=>$val)
		{
			$this->mValue = $val->InvKey;
			$invLines = array_filter($data2, function($v, $k) {
							    return  $v['InvKey'] == $this->mValue;
						}, ARRAY_FILTER_USE_BOTH);
			$data[$key]->lines = array();
			foreach($invLines as $invLine) {
				if (isset($data[$key]->lines[$invLine['Code']])) {
					$data[$key]->lines[$invLine['Code']]['Quantity'] += $invLine['Quantity'];
					$data[$key]->lines[$invLine['Code']]['Total'] += $invLine['Total'];
					$data[$key]->lines[$invLine['Code']]['UnitValue'] = $data[$key]->lines[$invLine['Code']]['Total'] / $data[$key]->lines[$invLine['Code']]['Quantity'];
					$data[$key]->lines[$invLine['Code']]['Discount'] += $invLine['Discount'];
				}
				else
					$data[$key]->lines[$invLine['Code']] = $invLine;
			}
		}
		
		//render excel file now
		$reader = IOFactory::createReader('Xlsx');
		$file = $reader->load('./ExcelTemplates/PurchasesReportNew.xlsx');
		$colIdx = 11;
		foreach($items as $col){
			//merge cells
			$file->getActiveSheet()->mergeCells($this->index($colIdx,1).':'.$this->index($colIdx+2,1));
			$file->getActiveSheet()->mergeCells($this->index($colIdx,2).':'.$this->index($colIdx+2,2));

			$file->getActiveSheet()->setCellValue($this->index($colIdx,1), $col["Code"]);
			$file->getActiveSheet()->setCellValue($this->index($colIdx,2), $col["Desc"]);
			
			$file->getActiveSheet()->setCellValue($this->index($colIdx+0,3), "سعر");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+1,3), "كميه");
			$file->getActiveSheet()->setCellValue($this->index($colIdx+2,3), "القيمة");
			
			$colIdx += 3;
		}
		//copy cell format
		$cellStyle = $file->getActiveSheet()->getStyle($this->index(11,2));
		$file->getActiveSheet()->duplicateStyle($cellStyle, $this->index(12,2).':'.$this->index(count($items)*3+5,2));

		$cellStyle = $file->getActiveSheet()->getStyle($this->index(2,3));
		$file->getActiveSheet()->duplicateStyle($cellStyle, $this->index(3,3).':'.$this->index(8+count($items)*5,3));
		
		//fill the data
		$rowIdx = 4;
		$serial = 1;
		foreach($data as $row){
			$file->getActiveSheet()->setCellValue($this->index(1,$rowIdx), $serial++);
			$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), $row->Id);
			$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), $row->Month);
			$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $row->Date);
			$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $row->SellerTaxId);
			$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $row->Seller);
			$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), $row->TotalAmount);
			$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), $row->T4);
			$file->getActiveSheet()->setCellValue($this->index(9,$rowIdx), $row->TX);
			$file->getActiveSheet()->setCellValue($this->index(10,$rowIdx), $row->Total);

			if (strtolower($row->docType) == 'i'){
				//set row color to green
				$file->getActiveSheet()
					->getStyle($this->index(1,$rowIdx).':'.$this->index(10+count($items)*3,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('FFFFFF');
			}else if (strtolower($row->docType) == 'c'){
				//set row color to orange
				$file->getActiveSheet()->getStyle($this->index(1,$rowIdx).':'.$this->index(10+count($items)*3,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()->setARGB('FF5555');
			} else {
				//set row color to red
				$file->getActiveSheet()->getStyle($this->index(1,$rowIdx).':'.$this->index(10+count($items)*3,$rowIdx))
					->getfill()
					->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
					->getStartColor()->setARGB('55FF55');
			}

			$colIdx = 11;
			foreach($items as $col){
				if (array_key_exists($col["Code"], $row->lines)){
					if ($col["Desc"] ==  $row->lines[$col["Code"]]['Desc']){
						$file->getActiveSheet()->setCellValue($this->index($colIdx+0,$rowIdx), $row->lines[$col["Code"]]['UnitValue']);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+1,$rowIdx), $row->lines[$col["Code"]]['Quantity']);
						$file->getActiveSheet()->setCellValue($this->index($colIdx+2,$rowIdx), $row->lines[$col["Code"]]['Total']);
					}
				}
				$colIdx += 3;
			}
			$rowIdx++;

		}
		//set bordres for all cells in active worksheet
		$file->getActiveSheet()->getStyle($this->index(2,3).':'.$this->index(10+count($items)*3,$rowIdx-1))
			->getBorders()
			->getAllBorders()
			->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		//set auto filter
		$file->getActiveSheet()->setAutoFilter($this->index(1,3).':'.$this->index(10+count($items)*3,$rowIdx));
		//set column width
		//TODO MFayez
		//$file->getActiveSheet()->getColumnDimension('A')->setWidth(5);

		$writer = IOFactory::createWriter($file, 'Xlsx');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Purchase_ExportedData.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function summaryOnlyData(Request $request) {

		return Excel::download(new ReportSummaryExport($this->summaryData($request)) , 'Report.xlsx');

	}

	public function branchesSales()
	{
        return Inertia::render('Reports/BranchesSales', [
        ]);
	}

	public function branchesSalesData(Request $request)
	{
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$strSqlStmt1 = "select t3.Id as Id, t3.name as Name,  
							sum(t5.amount) as TaxTotal, sum(t1.totalSalesAmount) as SalesTotal, sum(t1.totalAmount) as Total
						from Invoice t1 inner join Issuer t3 on t3.Id = t1.issuer_id
							left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where CAST(t1.dateTimeIssued as date) between ? and ? and t1.status = 'Valid'
						group by t3.Id, t3.name";
		$data = DB::select($strSqlStmt1, [$startDate, $endDate]);
		return $data;
	}
	
	public function branchesSalesDownload(Request $request)
	{
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$strSqlStmt1 = "select t3.Id as Id, t3.name as Name,  
							sum(t5.amount) as TaxTotal, sum(t1.totalSalesAmount) as SalesTotal, sum(t1.totalAmount) as Total
						from Invoice t1 inner join Issuer t3 on t3.Id = t1.issuer_id
							left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where CAST(t1.dateTimeIssued as date) between ? and ? and t1.status = 'Valid'
						group by t3.Id, t3.name";
		$data = DB::select($strSqlStmt1, [$startDate, $endDate]);
		
		//render excel file now
		$reader = IOFactory::createReader('Xlsx');
		$file = $reader->load('./ExcelTemplates/BranchesSales.xlsx');
		$rowIdx = 4;
		foreach($data as $row){
			$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), $row->Id);
			$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), $row->Name);
			$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $startDate);
			$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $endDate);
			$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $row->TaxTotal);
			$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), $row->SalesTotal);
			$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), $row->Total);
			$rowIdx++;
		}
		$last = $rowIdx - 1;
		$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), "***");
		$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), "الأجمالي");
		$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $startDate);
		$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $endDate);
		$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), "=SUM(F4:F".$last.")");
		$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), "=SUM(G4:G".$last.")");
		$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), "=SUM(H4:H".$last.")");
		$writer = IOFactory::createWriter($file, 'Xlsx');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Purchase_ExportedData.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	public function customersSales()
	{
        return Inertia::render('Reports/CustomersSales', [
        ]);
	}

	public function customersSalesData(Request $request)
	{
		$branchId   = $request->input('issuer')['Id'];
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$strSqlStmt1 = "select t4.receiver_id as Id, t4.name as Name,  
							sum(t5.amount) as TaxTotal, sum(t1.totalSalesAmount) as SalesTotal, sum(t1.totalAmount) as Total
						from Invoice t1 inner join Receiver t4 on t4.Id = t1.receiver_id
							left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where (t1.issuer_id = ? or ? = -1)
						and CAST(t1.dateTimeIssued as date) between ? and ? and t1.status = 'Valid'
						group by t4.receiver_id, t4.name";
		$data = DB::select($strSqlStmt1, [$branchId, $branchId, $startDate, $endDate]);
		return $data;
	}
	
	public function customersSalesDownload(Request $request)
	{
		$branchId   = $request->input('issuer')['Id'];
		$startDate  = $request->input('startDate');
		$endDate    = $request->input('endDate');
		$strSqlStmt1 = "select t4.receiver_id as Id, t4.code as Code, t4.name as Name,  
							sum(t5.amount) as TaxTotal, sum(t1.totalSalesAmount) as SalesTotal, sum(t1.totalAmount) as Total
						from Invoice t1 inner join Receiver t4 on t4.Id = t1.receiver_id
							left outer join TaxTotal t5 on t5.invoice_id = t1.Id
						where (t1.issuer_id = ? or ? = -1)
						and CAST(t1.dateTimeIssued as date) between ? and ? and t1.status = 'Valid'
						group by t4.receiver_id, t4.name, t4.code";
		$data = DB::select($strSqlStmt1, [$branchId, $branchId, $startDate, $endDate]);
		
		//render excel file now
		$reader = IOFactory::createReader('Xlsx');
		$file = $reader->load('./ExcelTemplates/CustomersSales.xlsx');
		$rowIdx = 4;
		foreach($data as $row){
			$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), $row->Code);
			$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), $row->Name);
			$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), $row->Id);
			$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $startDate);
			$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $endDate);
			$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), $row->TaxTotal);
			$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), $row->SalesTotal);
			$file->getActiveSheet()->setCellValue($this->index(9,$rowIdx), $row->Total);
			$rowIdx++;
		}
		$last = $rowIdx - 1;
		$file->getActiveSheet()->setCellValue($this->index(2,$rowIdx), "***");
		$file->getActiveSheet()->setCellValue($this->index(3,$rowIdx), "الأجمالي");
		$file->getActiveSheet()->setCellValue($this->index(4,$rowIdx), "***");
		$file->getActiveSheet()->setCellValue($this->index(5,$rowIdx), $startDate);
		$file->getActiveSheet()->setCellValue($this->index(6,$rowIdx), $endDate);
		$file->getActiveSheet()->setCellValue($this->index(7,$rowIdx), "=SUM(G4:G".$last.")");
		$file->getActiveSheet()->setCellValue($this->index(8,$rowIdx), "=SUM(H4:H".$last.")");
		$file->getActiveSheet()->setCellValue($this->index(9,$rowIdx), "=SUM(I4:I".$last.")");
		$writer = IOFactory::createWriter($file, 'Xlsx');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Purchase_ExportedData.xls"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}


	#helpers
	public function getInvoiceStatus()
	{
		$data = Invoice::select('status')->distinct()->get();
		$result = [];
		$result[] = ['value' => 'all', 'name' => __('All')];
		foreach($data as $row){
			$result[] = ["name" => __($row->status),
						 "value" => $row->status];
		}
		return $result;
	}
}
