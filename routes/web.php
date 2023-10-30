<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ETAController;
use App\Http\Controllers\ReceivedInvoiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ETAArchiveController;
use App\Http\Controllers\ETAInvoiceController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SalesBuzzController;
use App\Http\Controllers\MobisController;
use App\Http\Controllers\AccountingChartController;
use App\Http\Controllers\AccountingBookController;
use App\Http\Controllers\AccountingActivityController;
use App\Http\Controllers\AccountingReportController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReseptionistController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetailsController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\SetupDataController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PrescriptionItemsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\XRayController;
use App\Models\Appointment;
use App\Models\Item;
use App\Models\Patient;
use App\Models\XRay;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//Route::get('/generate/models', '\\Jimbolino\\Laravel\\ModelBuilder\\ModelGenerator5@start');

//Route::get('/', function () {
//    //return Inertia::render('Welcome', [
//    return Inertia::render('Auth/Login', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // first page to choose demo or actual
    Route::get('/setup/1', function () {
        return Inertia::render('Setup/Setup');
    })->name('setup');

    //demo
    Route::get('/setup/demo/step1', function () {
        return Inertia::render('Setup/Demo/Step1');
    })->name('setup.demo.step1');

    Route::get('/setup/demo/step2', function () {
        return Inertia::render('Setup/Demo/Step2');
    })->name('setup.demo.step2');

    Route::post('/setup/demo/step1/store', [SetupDataController::class,'demo_step1_store'])->name('setup.demo.step1.store');
    Route::post('/setup/demo/step2/store', [SetupDataController::class,'demo_step2_store'])->name('setup.demo.step2.store');

    // actual 
    Route::get('/setup/actual/step1', function () {
        return Inertia::render('Setup/Actual/Step1');
    })->name('setup.actual.step1');

    Route::get('/setup/actual/step2', function () {
        return Inertia::render('Setup/Actual/Step2');
    })->name('setup.actual.step2');

    Route::get('/setup/actual/step3', function () {
        return Inertia::render('Setup/Actual/Step3');
    })->name('setup.actual.step3');

    Route::post('/setup/actual/step1/store', [SetupDataController::class,'actual_step1_store'])->name('setup.actual.step1.store');
    Route::post('/setup/actual/step2/store', [SetupDataController::class,'actual_step2_store'])->name('setup.actual.step2.store');
    Route::post('/setup/actual/step3/store', [SetupDataController::class,'actual_step3_store'])->name('setup.actual.step3.store');


    //invoice-master setup
    Route::get('/setup/step1', function () {
        return Inertia::render('Setup/Step1');
    })->name('setup.step1');

    Route::get('/setup/step2', function () {
        return Inertia::render('Setup/Step2');
    })->name('setup.step2');

    Route::get('/setup/step3', function () {
        return Inertia::render('Setup/Step3');
    })->name('setup.step3');

    Route::post('/setup/ping_eta', [ETAController::class, 'pingETA'])->name('setup.ping_eta');
    Route::get('/json/settings', [SettingsController::class, 'index_json'])->name("settings.json");
    Route::post('/json/settings', [SettingsController::class, 'store'])->name("settings.store");
    Route::resources([
        'branches' => BranchController::class,
    ]);
    Route::get('/json/ActivityCodes.json', [SettingsController::class, 'indexActivityCodes_json'])->name("json.eta.activityCodes");
});

Route::middleware(['auth:sanctum', 'verified', 'ETASettings'])->group(function () {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(['complete.data','guest']);

    Route::resources([
        'invoices' => InvoiceController::class,
        'customers' => CustomerController::class,
        'items' => ItemController::class,
        'users' => UserController::class,
        'pos' => POSController::class,
        'doctors' => DoctorController::class,
        'patients' => PatientController::class,
        'clinics' => ClinicController::class,
        'rooms' => RoomController::class,
        'drugs' => DrugController::class,
        'prescriptions' => PrescriptionController::class,
        'appointments' => AppointmentController::class,
        'specialties' => SpecialtyController::class,
        'reseptionists' => ReseptionistController::class,
        'diagnosis' => DiagnosisController::class,
        'analysis' => AnalysisController::class,
        'xray' => XRayController::class,
        'bills' => BillController::class,
        'billDetails' => BillDetailsController::class,
        'inventories' => InventoryController::class,
        'services' => ServiceController::class,
    ]);


    Route::get('/incoms/export/', [BillController::class, 'export']);


    Route::get('/clinic/all', [ClinicController::class, 'all'])->name("clinic.all");
    Route::get('/doctor/all', [DoctorController::class, 'all'])->name("doctor.all");
    Route::get('/room/all', [RoomController::class, 'all'])->name("room.all");
    Route::get('/patient/all', [PatientController::class, 'all'])->name("patient.all");
    Route::get('/drug/all', [DrugController::class, 'all'])->name("drug.all");
    Route::get('/diagnosi/all', [DiagnosisController::class, 'all'])->name("diagnosi.all");
    Route::get('/diagnosi/allSpeciatlyDiagnosis', [DiagnosisController::class, 'allSpeciatlyDiagnosis'])->name("diagnosi.allSpeciatlyDiagnosis");
    Route::get('/analysi/allSpeciatlyAnalysis', [AnalysisController::class, 'allSpeciatlyAnalysis'])->name("analysi.allSpeciatlyAnalysis");
    Route::get('/xrays/allSpeciatlyRays', [XRayController::class, 'allSpeciatlyRays'])->name("xray.allSpeciatlyRays");
    Route::get('/reseptionist/all', [ReseptionistController::class, 'all'])->name("reseptionist.all");

    Route::get('patient/history/{patient_id}', [PatientController::class, 'getHistory'])->name("patient.getHistory");

    Route::post('/appointment/searchData', [AppointmentController::class, 'searchData'])->name("appointment.searchData");
    Route::post('/appointment/reserve', [AppointmentController::class, 'reserve'])->name("appointment.reserve");
    Route::post('/appointment/reserveNewPatient', [AppointmentController::class, 'reserveNewPatient'])->name("appointment.reserveNewPatient");
    Route::post('/appointment/pay', [AppointmentController::class, 'pay'])->name("appointment.pay");
    Route::post('/appointment/cancelUnreserved', [AppointmentController::class, 'cancelUnreserved'])->name("appointment.cancel.unreserved");
    Route::post('/appointment/cancelAll', [AppointmentController::class, 'cancelAll'])->name("appointment.cancel.all");
    Route::get('/appointment/showHistory/{patient_id}', [AppointmentController::class, 'showHistory'])->name("appointment.showHistory");

    Route::get('/item/show', [ItemController::class, 'showAll'])->name("items.showAll");

    Route::get('/inventory/items',[InventoryController::class,'showItems'])->name('inventories.show.items');
    Route::get('/inventory/{clinic_id}',[InventoryController::class,'getAllInventories'])->name('inventory.all');
    Route::get('/inventory-ins',[InventoryController::class,'showIns'])->name('inventory.show.ins');
    Route::get('/inventory-ins/create',[InventoryController::class,'createIns'])->name('inventory.create.ins');
    Route::post('/inventory-ins/store',[InventoryController::class,'storeIns'])->name('inventory.store.ins');
    Route::get('/inventory-outs',[InventoryController::class,'showOuts'])->name('inventory.show.outs');
    Route::get('/inventory-outs/create',[InventoryController::class,'createOUTs'])->name('inventory.create.outs');
    Route::post('/inventory-outs/store',[InventoryController::class,'storeOUTs'])->name('inventory.store.outs');
    Route::get('/inventory/items/balance', [InventoryController::class, 'getItemsBalance'])->name("inventory.items.balance");
    Route::post('/inventory/items/searchBalance', [InventoryController::class, 'searchItemsBalance'])->name("inventory.search.balance");
    Route::post('/inventory/items/searchBalance/export', [InventoryController::class, 'exportItemsBalance'])->name("inventory.export.balance");

    Route::get('/bill/show', [BillController::class, 'showAll'])->name("bills.showAll");
    Route::get('/bill/incomes/search', [BillController::class, 'searchIncomes'])->name("bills.incomes.search");
    Route::get('/bill/incomes/search/total', [BillController::class, 'searchTotalIncomes'])->name("bills.incomes.search.total");
    Route::post('/bill/searchIncomeData', [BillController::class, 'searchIncomeData'])->name("bills.income.searchData");
    Route::post('/bill/searchIncomeData/total', [BillController::class, 'searchTotalIncomeData'])->name("bills.income.searchData.total");
    Route::post('/bill/searchIncomeData/export', [BillController::class, 'exportIncomeData'])->name("bills.income.exportData");
    Route::get('/bill/expenses/search', [BillController::class, 'searchExpenses'])->name("bills.expenses.search");
    Route::post('/bill/searchExpensesData', [BillController::class, 'searchExpensesData'])->name("bills.expenses.searchData");
    Route::post('/bill/searchExpensesData/export', [BillController::class, 'exportExpensesData'])->name("bills.expenses.exportData");
    
    
    Route::post('/bill/administrative/store', [BillController::class, 'storeAdministrativeBill'])->name("bills.administrative.store");
    Route::post('/bill/purchase/store', [BillController::class, 'storePurchaseBill'])->name("bills.purchase.store");
    Route::get('/bill/administrative/create', [BillController::class, 'createAdministrativeBill'])->name("bills.administrative.create");
    Route::get('/bill/puschase/create', [BillController::class, 'createPurchaseBill'])->name("bills.purchase.create");

    Route::get('/invoice/search', [InvoiceController::class, 'search'])->name("invoices.search");
    Route::post('/invoice/searchData', [InvoiceController::class, 'searchData'])->name("invoices.searchData");

    Route::get('/getBranchesImages/{ids}', [BranchController::class, 'getBranchesimages'])->name('branches.getImages');

    Route::get('/json/Diagnosis', [PrescriptionController::class, 'indexDiagnosis_json'])->name("json.Diagnosis");
    Route::get('/json/analysis', [PrescriptionController::class, 'indexAnalysis_json'])->name("json.analysis");
    Route::get('/json/rays', [PrescriptionController::class, 'indexRays_json'])->name("json.rays");
    Route::get('/doses', [PrescriptionController::class, 'index_doses'])->name("doses");
    Route::get('/durations', [PrescriptionController::class, 'index_duration'])->name("durations");
    Route::get('/history/{patient_id}', [PrescriptionController::class, 'getHistory'])->name("patient.history");
    Route::get('/prescription/itemsFees/{appointment_id}', [PrescriptionController::class, 'getItemsFees'])->name("prescription.serviceFees");

    Route::get('/appointment/today/{clinic_id}', [PrescriptionController::class, 'getTodaysPatients'])->name("appointment.today");

    Route::get('/prescription/items/{prescription_id}', [PrescriptionItemsController::class, 'getItems'])->name("prescriptionItems.details");

    Route::post('payment/serviceFees', [PaymentController::class, 'payServiceFees'])->name('payments.payServiceFees');

    Route::get('/json/branches', [BranchController::class, 'index_json'])->name("json.branches");
    Route::get('/json/customers', [CustomerController::class, 'index_json'])->name("json.customers");
    Route::get('/json/eta/items', [ETAController::class, 'indexItems_json'])->name("json.eta.items");
    Route::get('/json/eta/vendors', [ETAController::class, 'indexVendors_json'])->name("json.eta.vendors");

    Route::post('/ETA/customers/Upload', [ETAController::class, 'UploadCustomer'])->name("eta.customer.upload");
    Route::post('/drugs/Upload', [DrugController::class, 'UploadDrugs'])->name("drug.upload");
    Route::post('/patients/Upload', [PatientController::class, 'UploadPatients'])->name("patient.upload");
    Route::post('/rays/Upload', [XRayController::class, 'UploadRays'])->name("rays.upload");
    Route::post('/analysiss/Upload', [AnalysisController::class, 'UploadAnalysis'])->name("analysis.upload");

    Route::post('/invoice/copy', [ETAController::class, 'saveCopy'])->name('invoices.copy');
    Route::post('/ETA/Items/Upload', [ETAController::class, 'UploadItem'])->name("eta.items.upload");
    Route::post('/ETA/Items/Sync', [ETAController::class, 'SyncItems'])->name("eta.items.sync");
    Route::post('/ETA/Items/Requests/Sync', [ETAController::class, 'SyncItemsRequests'])->name("eta.items.requests.sync");
    Route::post('/ETA/Items/Add', [ETAController::class, 'AddItem'])->name("eta.items.store");
    Route::get('/ETA/Items', [ETAController::class, 'indexItems'])->name("eta.items.index");

    Route::post('/ETA/Invoices/Sync/Received', [ETAController::class, 'SyncReceivedInvoices'])->name("eta.invoices.sync.received");
    Route::post('/ETA/Invoices/Sync/Issued', [ETAController::class, 'SyncIssuedInvoices'])->name("eta.invoices.sync.issued");
    Route::post('/ETA/Invoices/Sync/Invoices', [ETAController::class, 'SyncInvoices'])->name("eta.invoices.sync.all");

    Route::post('/ETA/Invoices/Add', [ETAController::class, 'AddInvoice'])->name("eta.invoices.store");
    Route::post('/ETA/Invoices/Credit/Add', [ETAController::class, 'AddCredit'])->name("eta.invoices.credit.store");
    Route::post('/ETA/Invoices/Debit/Add', [ETAController::class, 'AddDebit'])->name("eta.invoices.debit.store");
    Route::post('/ETA/Invoices/Cancel', [ETAController::class, 'CancelInvoice'])->name("eta.invoices.cancel");
    Route::post('/ETA/Invoices/Delete', [ETAController::class, 'DeleteInvoice'])->name("eta.invoices.delete");
    Route::post('/ETA/Invoices/Delay', [ETAController::class, 'DelayInvoice'])->name("eta.invoices.delay");
    Route::post('/ETA/Invoices/FixDate', [ETAController::class, 'FixInvoiceDate'])->name("eta.invoices.fixDate");
    Route::post('/ETA/Invoices/Approve', [ETAController::class, 'ApproveInvoice'])->name("eta.invoices.approve");
    Route::post('/ETA/Invoices/Upload', [ETAController::class, 'UploadInvoice'])->name("eta.invoices.upload");
    Route::post('/ETA/Invoices/Upload/Cancel', [ETAController::class, 'CancelUpload'])->name("eta.invoices.upload.cancel");
    Route::get('/ETA/Invoices/Excel/Review', [ETAController::class, 'indexExcel'])->name("invoices.excel.review");

    #Receipt Controller
    Route::get('/ETA/Receipts/Index', [ReceiptController::class, 'Index'])->name("eta.receipts.index");
    Route::post('/ETA/Receipts/Upload', [ReceiptController::class, 'UploadReceipts'])->name("eta.receipts.upload");
    Route::post('/ETA/Receipts/Send', [ReceiptController::class, 'SignAndSendReceipt'])->name("eta.receipts.send");
    Route::post('/ETA/Receipts/SendAll', [ReceiptController::class, 'SignAndSendReceipts'])->name("eta.receipts.send.all");

    Route::get('/ETA/Invoice/Print', [ETAInvoiceController::class, 'downloadPDF'])->name('eta.invoice.download');
    #todo mfayez change the controller method and implement it later
    Route::get('/ETA/Invoices/Issued/Index/{upload_id?}', [ETAController::class, 'indexIssued'])->name("eta.invoices.sent.index");

    #recieved invoices (purchases)
    Route::get('/ETA/Invoices/Received/Index', [ReceivedInvoiceController::class, 'indexInvoices'])->name("eta.invoices.received.index");
    Route::post('/ETA/Invoices/Received/Index', [ReceivedInvoiceController::class, 'updateDetails'])->name("eta.invoices.received.update_details");

    #reports, each report should have 3 functions
    Route::get('/reports/summary', [ReportsController::class, 'summary'])->name("reports.summary.details");
    Route::post('/reports/summary/data', [ReportsController::class, 'summaryData'])->name("reports.summary.details.data");
    Route::post('/reports/summary/download1', [ReportsController::class, 'summaryDownload'])->name("reports.summary.details.download");
    Route::post('/reports/summary/download2', [ReportsController::class, 'summaryDownloadNew'])->name("reports.summary.details.download.new");
    Route::post('/reports/summary/compact', [ReportsController::class, 'summaryDownloadCompact'])->name("reports.summary.details.download.compact");
    Route::post('/reports/summaryOnly/download', [ReportsController::class, 'summaryOnlyData'])->name("reports.summary.summaryOnlyData.download");

    Route::get('/reports/purchase', [ReportsController::class, 'purchase'])->name("reports.summary.purchase");
    Route::post('/reports/purchase/data', [ReportsController::class, 'purchaseData'])->name("reports.summary.purchase.data");
    Route::post('/reports/purchase/download1', [ReportsController::class, 'purchaseDownload'])->name("reports.summary.purchase.download");
    Route::post('/reports/purchase/download2', [ReportsController::class, 'purchaseDownloadSummary'])->name("reports.summary.purchase.download2");

    Route::get('/reports/branches/sales', [ReportsController::class, 'branchesSales'])->name("reports.branches.sales");
    Route::post('/reports/branches/sales/data', [ReportsController::class, 'branchesSalesData'])->name("reports.branches.sales.data");
    Route::post('/reports/branches/sales/download', [ReportsController::class, 'branchesSalesDownload'])->name("reports.branches.sales.download");

    Route::get('/reports/customers/sales', [ReportsController::class, 'customersSales'])->name("reports.customers.sales");
    Route::post('/reports/customers/sales/data', [ReportsController::class, 'customersSalesData'])->name("reports.customers.sales.data");
    Route::post('/reports/customers/sales/download', [ReportsController::class, 'customersSalesDownload'])->name("reports.customers.sales.download");

    Route::get('/reports/invoices/statuses', [ReportsController::class, 'getInvoiceStatus'])->name("reports.invoices.statuses");

    #excel exports
    // Route::get('/excel/items', function () {
    //     return App\Models\ETAItem::get()
    //         ->downloadExcel("items.xlsx", $writerType = null, $headings = true);
    // })->name('excel.items');
    Route::get('/excel/customers', [CustomerController::class, 'downloadExcel'])->name('excel.customers');

    #ETA Archives
    Route::get('/ETA/Archives',        [ETAArchiveController::class, 'getArchiveRequests'])->name("archive.getArchiveRequests");
    Route::post('/ETA/Archives/Add',   [ETAArchiveController::class, 'store'])->name("archive.store");
    Route::get('/ETA/Archives/import', [ETAArchiveController::class, 'importArchive'])->name("archive.import");
    #Local Archives
    Route::get('/Archives',         [ArchiveController::class, 'index'])->name("archive.index");
    Route::post('/Archives/Add',    [ArchiveController::class, 'store'])->name("archive.request.store");
    Route::get('/Archives/download/{Id}', [ArchiveController::class, 'downloadArchives'])->name("archive.download");

    #charts data
    Route::post('/json/top/items', [ChartsController::class, 'topItems'])->name("json.top.items");
    Route::post('/json/top/receivers', [ChartsController::class, 'topReceivers'])->name("json.top.receivers");
    #pdf stuff
    Route::get('/pdf/payment/{id}', [PDFController::class, 'previewPayment'])->name('pdf.payment.preview');
    Route::get('/pdf/prescription/{id}', [PDFController::class, 'previewPrescription'])->name('pdf.prescription.preview');
    Route::get('/pdf/invoice/{Id}', [PDFController::class, 'previewInvoice'])->name('pdf.invoice.preview');
    Route::get('/pdf/invoices/{Ids}', [PDFController::class, 'previewInvoices'])->name('pdf.invoices.preview');
    Route::get('/pdf/payment/download/{id}', [PDFController::class, 'downloadPayment'])->name('pdf.payment.download');
    Route::get('/pdf/invoice/download/{id}', [PDFController::class, 'downloadInvoice'])->name('pdf.invoice.download');

    Route::get('/reports/branches/purchases/{Ids}', [ETAInvoiceController::class, 'branchesPurchases'])->name("pdf.purchases");
    Route::get('/reports/zip/invoices/{Ids}', [ETAInvoiceController::class, 'archiveInvoices'])->name("zip.invoices");

    #salesbuzz stuff
    Route::get('/sb/branches/map', [SalesBuzzController::class, 'indexBranchesMap'])->name("sb.branches.map.index");
    Route::get('/sb/items/map', [SalesBuzzController::class, 'indexItemsMap'])->name("sb.items.map.index");
    Route::post('/sb/items/map/upload', [SalesBuzzController::class, 'UploadItemsMap'])->name("sb.items.map.upload");
    Route::get('/sb/items/map/download', [SalesBuzzController::class, 'DownloadItemsMap'])->name("sb.items.map.download");
    Route::post('/sb/items/map/update', [SalesBuzzController::class, 'updateItem'])->name("sb.items.map.update");
    Route::post('/sb/items/map/delete', [SalesBuzzController::class, 'deleteItem'])->name("sb.items.map.delete");

    Route::post('/sb/sync_orders', [SalesBuzzController::class, 'syncSalesOrders'])->name("sb.sync_orders");
    Route::post('/sb/branches/map', [SalesBuzzController::class, 'updateBranchesMap'])->name("sb.branches.map.update");

    #mobis(Ulker) stuff
    //Branches Map
    //Route::get('/ms/branches/map', [MobisController::class, 'indexBranchesMap'])->name("ms.branches.map.index");
    //Route::post('/ms/branches/map', [MobisController::class, 'updateBranchesMap'])->name("ms.branches.map.update");

    //Items Map
    Route::get('/ms/items/map', [MobisController::class, 'indexItemsMap'])->name("ms.items.map.index");
    Route::post('/ms/items/map/upload', [MobisController::class, 'UploadItemsMap'])->name("ms.items.map.upload");
    Route::get('/ms/items/map/download', [MobisController::class, 'DownloadItemsMap'])->name("ms.items.map.download");
    Route::post('/ms/items/map/update', [MobisController::class, 'updateItem'])->name("ms.items.map.update");
    Route::post('/ms/items/map/delete', [MobisController::class, 'deleteItem'])->name("ms.items.map.delete");

    //Invoices Upload
    Route::post('/ms/upload', [MobisController::class, 'uploadInvoices'])->name("ms.invoices.upload");

    #Accounting Master Routes
    Route::get("/accounting/chart/index", [AccountingChartController::class, 'index'])->name("accounting.chart.index");
    Route::get("/accounting/chart/json", [AccountingChartController::class, 'index_json'])->name("accounting.chart.json");
    Route::get("/accounting/chart/download", [AccountingChartController::class, 'download'])->name("accounting.chart.download");
    Route::post("/accounting/chart/upload", [AccountingChartController::class, 'upload'])->name("accounting.chart.upload");
    Route::post("/accounting/chart/store", [AccountingChartController::class, 'store'])->name("accounting.chart.store");
    Route::post("/accounting/chart/delete", [AccountingChartController::class, 'delete'])->name("accounting.chart.delete");

    Route::get("/accounting/book/index", [AccountingBookController::class, 'index'])->name("accounting.book.index");
    Route::get("/accounting/book/json", [AccountingBookController::class, 'index_json'])->name("accounting.book.json");
    Route::post("/accounting/book/store", [AccountingBookController::class, 'store'])->name("accounting.book.store");
    Route::post("/accounting/book/delete", [AccountingBookController::class, 'delete'])->name("accounting.book.delete");

    Route::get("/accounting/book/{book}/index", [AccountingBookController::class, 'index_item'])->name("accounting.book.item.index")->whereNumber('id');
    Route::get("/accounting/book/{book}/json", [AccountingBookController::class, 'index_item_json'])->name("accounting.book.item.json")->whereNumber('id');
    Route::post("/accounting/book/{book}/store", [AccountingBookController::class, 'store_item'])->name("accounting.book.item.store")->whereNumber('id');
    Route::post("/accounting/book/{book}/delete", [AccountingBookController::class, 'delete_item'])->name("accounting.book.item.delete")->whereNumber('id');
    Route::get("/accounting/book/{book}/print/{book_data}", [AccountingBookController::class, 'print_book_item'])
        ->name("accounting.book.item.print")
        ->whereNumber('id')
        ->whereNumber('book_data');
    Route::get("/accounting/book/{book}/download/{book_data}", [AccountingBookController::class, 'download_item_attachment'])
        ->name("accounting.book.item.download")
        ->whereNumber('id')
        ->whereNumber('book_data');



    Route::get("/accounting/activity/index", [AccountingactivityController::class, 'index'])->name("accounting.activity.index");
    Route::get("/accounting/activity/json", [AccountingactivityController::class, 'index_json'])->name("accounting.activity.json");
    Route::post("/accounting/activity/store", [AccountingactivityController::class, 'store'])->name("accounting.activity.store");
    Route::post("/accounting/activity/delete", [AccountingactivityController::class, 'delete'])->name("accounting.activity.delete");

    Route::get("accounting/review/index", [AccountingReportController::class, 'review_index'])->name("accounting.review.index");
    Route::get("accounting/balance/index", [AccountingReportController::class, 'balance_index'])->name("accounting.balance.sheet");
    Route::get("accounting/income_statement/index", [AccountingReportController::class, 'income_statement_index'])->name("accounting.income.statement");
});

Route::middleware(['web'])->group(function () {
    Route::get('/language/{language}', function ($language) {
        header("Refresh:0");
        Session()->put('locale', $language);
        return redirect()->back();
    })->name('language');
});

