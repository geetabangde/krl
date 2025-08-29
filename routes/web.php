<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\GST\GstEwayController;
use App\Http\Controllers\Frontend\White\EraahiWhiteController;
use App\Http\Controllers\Frontend\EraahiController;
use App\Http\Controllers\Frontend\TrasporterauthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\EwayBillGeberateController;
use App\Http\Controllers\Frontend\MultiVehicleController;
use App\Http\Controllers\Frontend\MultipleVehicleAddController;
use App\Http\Controllers\Frontend\MultipleVehicleChangeController;
use App\Http\Controllers\Frontend\EwayBillDetailController;
use App\Http\Controllers\Frontend\EwayConsolidatedController;
use App\Http\Controllers\Frontend\TransporterBillController;
use App\Http\Controllers\Frontend\EwayBillGstinController;
use App\Http\Controllers\Frontend\EwayVehicleDetailController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\Auth\RegisterController as FrontendRegisterController;
use App\Http\Controllers\Frontend\Auth\LoginController as FrontendLoginController;
use App\Http\Controllers\Backend\Auth\LoginController as BackendLoginController;
use App\Http\Controllers\Backend\{
    EmployeeController, PayrollController, AdminDashboardController, DestinationController,
    UserController, TyreController, WarehouseController, OrderController, PackageTypeController,
    ConsignmentNoteController, FreightBillController, StockTransferController, DriverController,
    AttendanceController, MaintenanceController, VehicleController, TaskManagmentController, ContractController,
    SettingsController, VehicleTypeController,RoleController,PermissionController,TestController,GroupController,ledgerMasterController,ledgerController,AccountsReceivableController,AccountsPayableController,
    ProfitLossController,BalanceSheetController,CashFlowController,VoucherController,GstController
};
   //   whitebox eway_bill
   Route::get('/ewaybill/whitebox/auth', [EraahiWhiteController::class, 'getAccessToken']);
   Route::get('/ewaybill/whitebox/generate', [EraahiWhiteController::class, 'generateEwayBill']);
   Route::get('/ewaybill/whitebox/update-partb', [EraahiWhiteController::class, 'updatePartB']);
   Route::get('/ewaybill/whitebox/details', [EraahiWhiteController::class, 'getEwayBillDetails']);
   Route::get('/ewaybill/whitebox/report-by-transporter-date', [EraahiWhiteController::class, 'getEwayBillReportByTransporterDate']);
   
    //alkit  Eway-Bill api
    Route::get('/ewaybill/auth', [EraahiController::class, 'getAccessToken']);
    Route::get('/ewaybill/Trasporter/auth', [TrasporterauthController::class, 'getTrasporterAuth']);
    Route::get('/ewaybill/generate', [EwayBillGeberateController::class, 'generateEwayBill']);
    Route::get('/ewaybill/transporter/list', [TransporterBillController::class, 'getEwayBillsForTransporter']);
    Route::get('/ewaybill/{ewbNo}', [EwayBillDetailController::class, 'getEwayBillDetail']);
    Route::get('/ewaybill/update/vehicle/number', [EwayVehicleDetailController::class, 'getVehicleNumber']);
    Route::get('/ewaybill/consolidated/generate', [EwayConsolidatedController::class, 'generateConsolidatedEwaybill']);
    Route::get('/ewaybill/transporter/gstin', [EwayBillGstinController::class, 'getEwayGstin']);
    Route::get('/ewaybill/multivehicle/initiate', [MultiVehicleController::class, 'initiateMultiVehicle']);
    Route::get('/ewaybill/multivehicle/add', [MultipleVehicleAddController::class, 'addMultiVehicle']);
    Route::get('/ewaybill/multivehicle/chnage', [MultipleVehicleChangeController::class, 'ChnageMultiVehicle']);
    
    // GST Eway Bill Api
    Route::get('/gst/request-otp', [GstEwayController::class, 'requestOtp']);
    Route::post('/gst/verify-otp', [GstEwayController::class, 'verifyOtp']);
    
    

    // 🌐 Frontend Routes Group (user side)
    Route::prefix('user')->name('user.')->group(function () {
    // 👤 Register
        Route::get('/register', [FrontendRegisterController::class, 'showRegisterForm'])->middleware('guest.user')->name('register');
        Route::post('/register', [FrontendRegisterController::class, 'register']);

        // 🔐 Login
        Route::get('/login', [FrontendLoginController::class, 'showLoginForm'])->middleware('guest.user')->name('login');
        Route::post('/login', [FrontendLoginController::class, 'login']);

        // 🚪 Logout
        Route::post('/logout', [FrontendLoginController::class, 'logout'])->name('logout');

        // 📊 Protected Routes (Login Required)
        Route::middleware(['auth'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
            Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
            Route::post('/update', [DashboardController::class, 'updateProfile'])->name('update');
            Route::get('/order-details/{order_id}', [DashboardController::class, 'OrderDetails'])->name('order-details');
        
        });
            Route::get('/lr-details/{lr_number}', [DashboardController::class, 'lrDetails'])->name('lr_details');
            Route::get('/fb-details/{order_id}/{id}', [DashboardController::class, 'fbDetails'])->name('fb_details');
            Route::get('/invoice-details/{id}', [DashboardController::class, 'invDetails'])->name('inv_details');
    });

    Route::get('/', [HomeController::class, 'index'])->middleware('guest.user')->name('front.index');
    Route::get('/about', [HomeController::class, 'about'])->name('front.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('front.contact');
    Route::get('/terms', [HomeController::class, 'terms'])->name('front.terms');
    Route::get('/privacy', [HomeController::class, 'privacy'])->name('front.privacy');
    Route::post('/save-order', [HomeController::class, 'saveOrder'])->name('order.save');
    Route::post('/request', [HomeController::class, 'requestStatus'])->name('order.requests');
    
    // Authentication Routes
    Route::prefix('admin')->group(function () {

    // Login & Logout Routes
    Route::get('/login', [BackendLoginController::class, 'showLoginForm'])->middleware('admin.guest')->name('admin.login');
    Route::post('/login', [BackendLoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [BackendLoginController::class, 'logout'])->name('admin.logout');
   // Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index']) ->middleware('auth.admin')->name('admin.dashboard');
    // User Management
    Route::prefix('users')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/view/{id}', [UserController::class, 'show'])->name('admin.users.view');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');
    });

    // Vehicles Management
    Route::prefix('vehicles')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [VehicleController::class, 'index'])->name('admin.vehicles.index');
        Route::get('/create', [VehicleController::class, 'create'])->name('admin.vehicles.create');
        Route::post('/store', [VehicleController::class, 'store'])->name('admin.vehicles.store');
        Route::get('/view/{id}', [VehicleController::class, 'show'])->name('admin.vehicles.view');
        Route::get('/edit/{id}', [VehicleController::class, 'edit'])->name('admin.vehicles.edit');
        Route::post('/update/{id}', [VehicleController::class, 'update'])->name('admin.vehicles.update');
        Route::delete('/delete/{id}', [VehicleController::class, 'destroy'])->name('admin.vehicles.delete');
    });

   // Tyres Management
    Route::prefix('tyres')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [TyreController::class, 'index'])->name('admin.tyres.index');
        Route::post('/store', [TyreController::class, 'store'])->name('admin.tyres.store');
        Route::put('/update/{id}', [TyreController::class, 'update'])->name('admin.tyres.update');
        Route::get('/delete/{id}', [TyreController::class, 'destroy'])->name('admin.tyres.delete');
       
    });
    
    // PackageTypeController
    Route::prefix('packagetype')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [PackageTypeController::class, 'index'])->name('admin.packagetype.index');
        Route::post('/store', [PackageTypeController::class, 'store'])->name('admin.packagetype.store');
        Route::put('/update/{id}', [PackageTypeController::class, 'update'])->name('admin.packagetype.update');
        Route::get('/delete/{id}', [PackageTypeController::class, 'destroy'])->name('admin.packagetype.delete');
       
    });

    // DestinationController
    Route::prefix('destination')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [DestinationController::class, 'index'])->name('admin.destination.index');
        Route::post('/store', [DestinationController::class, 'store'])->name('admin.destination.store');
        Route::put('/update/{id}', [DestinationController::class, 'update'])->name('admin.destination.update');
        Route::get('/delete/{id}', [DestinationController::class, 'destroy'])->name('admin.destination.delete');
       
    });

    // ContractController
    Route::prefix('contract')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [ContractController::class, 'index'])->name('admin.contract.index');
        Route::get('/view/{id}', [ContractController::class, 'show'])->name('admin.contract.view');
        Route::post('/store', [ContractController::class, 'store'])->name('admin.contract.store');
        Route::put('/update/{id}', [ContractController::class, 'update'])->name('admin.contract.update');
        Route::get('/delete/{id}', [ContractController::class, 'destroy'])->name('admin.contract.delete');
    });
    Route::post('/get-rate', [ContractController::class, 'getRate']);

    // VehicleTypeController
    Route::prefix('vehicletype')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [VehicleTypeController::class, 'index'])->name('admin.vehicletype.index');
        Route::post('/store', [VehicleTypeController::class, 'store'])->name('admin.vehicletype.store');
        Route::put('/update/{id}', [VehicleTypeController::class, 'update'])->name('admin.vehicletype.update');
        Route::get('/delete/{id}', [VehicleTypeController::class, 'destroy'])->name('admin.vehicletype.delete');
    }); 

    // SettingsController

    Route::prefix('settings')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/store', [SettingsController::class, 'store'])->name('admin.settings.store');

    });

    // Warehouse Management
    Route::prefix('warehouse')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('admin.warehouse.index');
        Route::post('/store', [WarehouseController::class, 'store'])->name('admin.warehouse.store');
        Route::put('/update/{id}', [WarehouseController::class, 'update'])->name('admin.warehouse.update');
        Route::get('/delete/{id}', [WarehouseController::class, 'destroy'])->name('admin.warehouse.delete');
    });
        //maintenanceController
    Route::prefix('maintenance')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index'])->name('admin.maintenance.index');
        Route::post('/store', [MaintenanceController::class, 'store'])->name('admin.maintenance.store');
        Route::put('/update/{id}', [MaintenanceController::class, 'update'])->name('admin.maintenance.update');
        Route::get('/delete/{id}', [MaintenanceController::class, 'destroy'])->name('admin.maintenance.delete');
    });

    Route::prefix('employees')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.employees.index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('admin.employees.store');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
        Route::get('/show/{id}', [EmployeeController::class, 'show'])->name('admin.employees.show');
        Route::get('/task/{id}', [EmployeeController::class, 'task']) ->name('admin.employees.task');
        Route::get('/delete/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.delete');
    });
    
    Route::prefix('drivers')->middleware('admin.token.session','auth.admin')->group( function(){
        Route::get('', [DriverController::class, 'index'])->name('admin.drivers.index');
        Route::get('/create', action: [DriverController::class, 'create'])->name('admin.drivers.create');
        Route::post('/store', [DriverController::class, 'store'])->name('admin.drivers.store');
        Route::get('/edit/{id}', [DriverController::class, 'edit'])->name('admin.drivers.edit');
        Route::get('/show/{id}', [DriverController::class, 'show'])->name('admin.drivers.show');
        Route::post('/update/{id}', [DriverController::class, 'update'])->name('admin.drivers.update');
        Route::get('/delete/{id}', [DriverController::class, 'destroy'])->name('admin.drivers.delete');
    });

   // attendance
    Route::prefix('attendance')->middleware('admin.token.session','auth.admin')->group( function(){
        Route::get('/', [AttendanceController::class, 'index'])->name('admin.attendance.index');
        Route::post('/update', [AttendanceController::class, 'update'])->name('admin.attendance.update');
   });

   Route::prefix('payroll')->middleware('admin.token.session','auth.admin')->group( function(){
        Route::get('/', [PayrollController::class, 'index'])->name('admin.payroll.index');
        Route::get('/show/{id}', [PayrollController::class, 'show'])->name('admin.payroll.show');
   });

     Route::prefix('task-managment')->middleware('admin.token.session','auth.admin')->group(function(){
        Route::get('/', [TaskManagmentController::class, 'index'])->name('admin.task_management.index');
        Route::post('/store', [TaskManagmentController::class, 'store'])->name('admin.task_management.store');
        Route::put('/update/{id}', [TaskManagmentController::class, 'update'])->name('admin.task_management.update');
        Route::get('/delete/{id}', [TaskManagmentController::class, 'destroy'])->name('admin.task_management.delete');
        Route::get('/search-by-date', [TaskManagmentController::class, 'searchByDate'])->name('admin.task_management.searchByDate');
        Route::get('/close-task/{id}', [TaskManagmentController::class, 'closeTask'])->name('admin.task_management.task_status');
    });

    Route::prefix('orders')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');        
        Route::get('/create', [OrderController::class, 'create'])->name('admin.orders.create');
        Route::post('/store', [OrderController::class, 'store'])->name('admin.orders.store');
        Route::get('/edit/{order_id}', [OrderController::class, 'edit'])->name('admin.orders.edit');
        Route::get('/view/{order_id}', [OrderController::class, 'show'])->name('admin.orders.view');
        Route::get('/documents/{order_id}', [OrderController::class, 'docView'])->name('admin.orders.documents');
        Route::post('/update/{order_id}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::get('/delete/{order_id}', [OrderController::class, 'destroy'])->name('admin.orders.delete');
        Route::post('/update-status/{order_id}', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
         Route::get('/delete/{order_id}/{lr_number}', [OrderController::class, 'destroyLR'])->name('admin.orders.deleteLR');
    });

    // Consignment Management
    Route::prefix('consignments')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [ConsignmentNoteController::class, 'index'])->name('admin.consignments.index');
        Route::get('/create', [ConsignmentNoteController::class, 'create'])->name('admin.consignments.create');
        Route::post('/store', [ConsignmentNoteController::class, 'store'])->name('admin.consignments.store');
        Route::get('edit/{order_id}/{lr_number}', [ConsignmentNoteController::class, 'edit'])->name('admin.consignments.edit');
        Route::get('/view/{id}', [ConsignmentNoteController::class, 'show'])->name('admin.consignments.view');
        Route::get('/documents/{id}', [ConsignmentNoteController::class, 'docView'])->name('admin.consignments.documents');
        Route::post('/update/{order_id}/{lr_number}', [ConsignmentNoteController::class, 'update'])->name('admin.consignments.update');
        Route::get('/delete/{order_id}/{lr_number}', [ConsignmentNoteController::class, 'destroy'])->name('admin.consignments.delete');
        Route::post('/upload-pod', [ConsignmentNoteController::class, 'uploadPod'])->name('admin.consignments.uploadPod');
        Route::get('/multiple-pod', [ConsignmentNoteController::class, 'multiplePodForm'])->name('admin.consignments.multiplePodForm');
        Route::post('/multiple-pod-upload', [ConsignmentNoteController::class, 'uploadMultiplePod'])->name('admin.consignments.uploadMultiplePod');
        Route::get('/assign/{lr_number}', [ConsignmentNoteController::class, 'assign'])->name('admin.consignments.assign');
        Route::post('/assign/{lr_number}/save', [ConsignmentNoteController::class, 'assignSave'])->name('admin.consignments.assign.save');
        Route::get('/vehicle_eway_bill', [ConsignmentNoteController::class, 'fillFromEwayBill'])->name('admin.consignments.vehicle_eway_bill'); 
        Route::post('/vehicle_eway_bill/update', [ConsignmentNoteController::class, 'updatePartB'])->name('admin.consignments.vehicle_eway_bill.update');
        Route::get('/multi-vehicle-initiate', [ConsignmentNoteController::class, 'multiVehicleInitiate'])->name('admin.consignments.multi-vehicle-initiate');
        Route::post('/multi-vehicle-initiate', [ConsignmentNoteController::class, 'callInitiateApi'])->name('admin.consignments.call_initiate_api');
        Route::get('/add-vehicle-ui', [ConsignmentNoteController::class, 'showAddVehicleForm'])->name('admin.consignments.add_vehicle_form');
        Route::post('/add-vehicle-ui', [ConsignmentNoteController::class, 'callAddVehicleApi'])->name('admin.consignments.call_add_vehicle');
        Route::get('/change-vehicle-ui', [ConsignmentNoteController::class, 'showChangeVehicleForm'])->name('admin.consignments.change_vehicle_form');
        Route::post('/change-vehicle-ui', [ConsignmentNoteController::class, 'callChangeVehicleApi'])->name('admin.consignments.call_change_vehicle');

    });
    
    // Freight Bill Management
    Route::prefix('freight-bill')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [FreightBillController::class, 'index'])->name('admin.freight-bill.index');
        Route::get('/create', [FreightBillController::class, 'create'])->name('admin.freight-bill.create');
        Route::post('/store', [FreightBillController::class, 'store'])->name('admin.freight-bill.store');
        Route::get('/view/{id}', [FreightBillController::class, 'show'])->name('admin.freight-bill.view');
        Route::get('/edit/{id}', [FreightBillController::class, 'edit'])->name('admin.freight-bill.edit');
        Route::post('/update/{id}', [FreightBillController::class, 'updateTotals'])->name('admin.freight-bill.update');
        Route::post('/update-entry/{id}', [FreightBillController::class, 'updateEntry'])->name('admin.freight-bill.update-entry');
        Route::get('/delete/{id}', [FreightBillController::class, 'destroy'])->name('admin.freight-bill.delete');
        Route::get('/invoice', [FreightBillController::class, 'Invoice'])->name('admin.freight-bill.invoice');
        Route::get('invoice-view/{id}', [FreightBillController::class, 'InvoiceView'])->name('admin.freight-bill.invoice-view');
        Route::get('/generate-invoice/{id}', [FreightBillController::class, 'generateInvoice'])->name('admin.freight-bill.generate-invoice');

    });
    
    Route::prefix('role')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('admin.role.delete');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
    }); 
    
    Route::prefix('permissions')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('admin.permission.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('admin.permission.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('admin.permission.store');
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('admin.permission.edit');
        Route::post('/update/{id}', [PermissionController::class, 'update'])->name('admin.permission.update');
        Route::get('/delete/{id}', [PermissionController::class, 'destroy'])->name('admin.permission.delete');
    }); 

    Route::prefix('user')->middleware('admin.token.session','auth.admin')->group(function () {
        Route::get('/', [TestController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [TestController::class, 'create'])->name('admin.user.create');
        Route::post('/stote', [TestController::class, 'store'])->name('admin.user.store'); 
        Route::get('/edit/{id}', [TestController::class, 'edit'])->name('admin.user.edit');
        Route::post('/update/{id}', [TestController::class, 'update'])->name('admin.user.update');
        Route::get('/delete/{id}', [TestController::class, 'destroy'])->name('admin.user.delete');

    });
    
    // voucher
    Route::prefix('voucher')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('admin.voucher.index');
        Route::get('/create', [VoucherController::class, 'create'])->name('admin.voucher.create');
        Route::post('/stote', [VoucherController::class, 'store'])->name('admin.voucher.store'); 
        Route::get('/get-ledgers', [VoucherController::class, 'getLedgers']);
        Route::get('/view/{id}', [VoucherController::class, 'show'])->name('admin.voucher.view');
        Route::get('/edit/{id}', [VoucherController::class, 'edit'])->name('admin.voucher.edit');
        Route::post('/update/{id}', [VoucherController::class, 'update'])->name('admin.voucher.update');
        Route::get('/delete/{id}', [VoucherController::class, 'destroy'])->name('admin.voucher.delete');
        Route::get('/sync-tally', [VoucherController::class, 'syncTally'])->name('admin.voucher.syncTally');
    });

    // Group
    Route::prefix('group')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('admin.group.index');
        Route::get('/create', [GroupController::class, 'create'])->name('admin.group.create');
        Route::post('/stote', [GroupController::class, 'store'])->name('admin.group.store'); 
        Route::get('/view/{id}', [GroupController::class, 'show'])->name('admin.group.view');
        Route::get('/edit/{id}', [GroupController::class, 'edit'])->name('admin.group.edit');
        Route::post('/update/{id}', [GroupController::class, 'update'])->name('admin.group.update');
        Route::get('/delete/{id}', [GroupController::class, 'destroy'])->name('admin.group.delete');
    });

    // ledger-master
    Route::prefix('ledger_master')->group(function () {
        Route::get('/', [ledgerMasterController::class, 'index'])->name('admin.ledger_master.index');
        Route::get('/create', [ledgerMasterController::class, 'create'])->name('admin.ledger_master.create');
        Route::post('/stote', [ledgerMasterController::class, 'store'])->name('admin.ledger_master.store'); 
        Route::get('/edit/{id}', [ledgerMasterController::class, 'edit'])->name('admin.ledger_master.edit');
        Route::post('/update/{id}', [ledgerMasterController::class, 'update'])->name('admin.ledger_master.update');
        Route::get('/view/{id}', [ledgerMasterController::class, 'show'])->name('admin.ledger_master.view');
        Route::get('/delete/{id}', [ledgerMasterController::class, 'destroy'])->name('admin.ledger_master.delete');

    });

    // Ledgers
    Route::prefix('ledger')->group(function () {
        Route::get('/', [ledgerController::class, 'index'])->name('admin.ledger.index');
        Route::get('/create', [ledgerController::class, 'create'])->name('admin.ledger.create');
        Route::get('/view/{id}', [ledgerController::class, 'show'])->name('admin.ledger.view');
    });

    // accounts-receivable
    Route::prefix('accounts_receivable')->group(function () {
        Route::get('/', [AccountsReceivableController::class, 'index'])->name('admin.accounts_receivable.index');
        Route::get('/view', [AccountsReceivableController::class, 'show'])->name('admin.accounts_receivable.view');
        
    });

    // accounts-payable
    Route::prefix('accounts_payable')->group(function () {
        Route::get('/', [AccountsPayableController::class, 'index'])->name('admin.accounts_payable.index');
        Route::get('/view', [AccountsPayableController::class, 'show'])->name('admin.accounts_payable.view');
    });

    // profit-loss
    Route::prefix('profit_loss')->group(function () {
        Route::get('/', [ProfitLossController::class, 'index'])->name('admin.profit_loss.index');
        Route::get('/create', [ProfitLossController::class, 'create'])->name('admin.profit_loss.create');
    });

    // profit-loss
    Route::prefix('gst')->group(function () {
        Route::get('/', [GstController::class, 'index'])->name('admin.gst.index');
    });
    
    // balance-sheet
    Route::prefix('balance_sheet')->group(function () {
        Route::get('/', [BalanceSheetController::class, 'index'])->name('admin.balance_sheet.index');
        Route::get('/create', [BalanceSheetController::class, 'create'])->name('admin.balance_sheet.create');
    });

    // cash-flow
    Route::prefix('cash_flow')->group(function () {
        Route::get('/', [CashFlowController::class, 'index'])->name('admin.cash_flow.index');
        Route::get('/create', [CashFlowController::class, 'create'])->name('admin.cash_flow.create');
    });
});






















































































































