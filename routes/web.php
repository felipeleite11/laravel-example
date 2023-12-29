<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    UserController,
    SessionController,
    ScheduleController,
    AppointmentController,
    ContactController,
    PropositionController,
    VisitController,
    CityBirthdateController,
    ReportScheduleController,
    ReportPropositionController,
    ElectionController,
    IDHController,
    AssemblyController,
    EducationController,
    PrefectureController,
    PopulationController,
    HotelController,
    PDFController,
    SeuSystemController
};
use App\Http\Middleware\Auth;

Route::get('/{id?}', [SeuSystemController::class, 'index']);

// Authentication routes
Route::prefix('sie')->group(function() {
    Route::post('/session', [SessionController::class, 'store']);
    Route::get('/destroy/session/', [SessionController::class, 'destroy']);
});

Route::prefix('sie')->middleware([Auth::class])->group(function() {
    Route::get('/', function() {
        return redirect('/sie/login');
    });

    Route::get('/login', [SessionController::class, 'index']);

    Route::get('/home', [HomeController::class, 'index']);

    // User management routes
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/destroy/{id}', [UserController::class, 'destroy'])->whereNumber('id');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->whereNumber('id');
    Route::post('/users/edit/{id}', [UserController::class, 'update'])->whereNumber('id');

    // Schedule routes
    Route::get('/schedule/{id}/show',[ScheduleController::class,'show']);
    Route::get('/list/schedule', [ScheduleController::class, 'index']);
    Route::get('/store/schedule', [ScheduleController::class, 'create']);
    Route::post('/store/schedule', [ScheduleController::class, 'store']);
    Route::get('/destroy/schedule/{id}', [ScheduleController::class, 'destroy'])->whereNumber('id');
    Route::get('/schedule/edit/{id}', [ScheduleController::class, 'edit'])->whereNumber('id');
    Route::post('/schedule/update/{id}', [ScheduleController::class, 'update'])->whereNumber('id');
    Route::get('/schedule/filter', [ScheduleController::class, 'filter']);

    // Appointment routes
    Route::get('/list/appointment', [AppointmentController::class, 'index']);
    Route::get('/appointment/{id}/show', [AppointmentController::class, 'show']);
    Route::get('/store/appointment', [AppointmentController::class, 'create']);
    Route::post('/store/appointment', [AppointmentController::class, 'store']);
    Route::get('/destroy/appointment/{id}', [AppointmentController::class, 'destroy'])->whereNumber('id');
    Route::get('/appointment/edit/{id}', [AppointmentController::class, 'edit'])->whereNumber('id');
    Route::post('/appointment/update/{id}', [AppointmentController::class, 'update'])->whereNumber('id');
    Route::get('/appointment/filter', [AppointmentController::class, 'filter']);
    Route::get('/appointment/pdf', [AppointmentController::class, 'generatePDF']);


    // Proposition routes
    Route::get('/proposition/{id}/show',[PropositionController::class,'show']);
    Route::get('/list/proposition', [PropositionController::class, 'index']);
    Route::get('/store/proposition', [PropositionController::class, 'create']);
    Route::post('/store/proposition', [PropositionController::class, 'store']);
    Route::get('/destroy/proposition/{id}', [PropositionController::class, 'destroy'])->whereNumber('id');
    Route::get('/proposition/edit/{id}', [PropositionController::class, 'edit'])->whereNumber('id');
    Route::post('/proposition/update/{id}', [PropositionController::class, 'update'])->whereNumber('id');
    Route::get('/proposition/filter', [PropositionController::class, 'filter']);

    // Visit routes
    Route::get('/visit/{id}/show',[VisitController::class,'show']);
    Route::get('/list/visit', [VisitController::class, 'index']);
    Route::get('/store/visit', [VisitController::class, 'create']);
    Route::post('/store/visit', [VisitController::class, 'store']);
    Route::get('/destroy/visit/{id}', [VisitController::class, 'destroy'])->whereNumber('id');
    Route::get('/visit/edit/{id}', [VisitController::class, 'edit'])->whereNumber('id');
    Route::post('/visit/update/{id}', [VisitController::class, 'update'])->whereNumber('id');
    Route::get('/visit/filter', [VisitController::class, 'filter']);

    // Contact routes
    Route::get('/contact/{id}/show',[ContactController::class,'show']);
    Route::get('/list/contact', [ContactController::class, 'index']);
    Route::get('/store/contact', [ContactController::class, 'create']);
    Route::post('/store/contact', [ContactController::class, 'store']);
    Route::get('/destroy/contact/{id}', [ContactController::class, 'destroy'])->whereNumber('id');
    Route::get('/contact/edit/{id}', [ContactController::class, 'edit'])->whereNumber('id');
    Route::post('/contact/update/{id}', [ContactController::class, 'update'])->whereNumber('id');
    Route::get('/contact/filter', [ContactController::class, 'filter']);

    // City birthdate
    Route::get('/list/city_birthdate', [CityBirthdateController::class, 'index']);
    Route::get('/store/city_birthdate', [CityBirthdateController::class, 'create']);
    Route::post('/store/city_birthdate', [CityBirthdateController::class, 'store']);
    Route::get('/city_birthdate/edit/{id}', [CityBirthdateController::class, 'edit'])->whereNumber('id');
    Route::post('/city_birthdate/update/{id}', [CityBirthdateController::class, 'update'])->whereNumber('id');
    Route::get('/destroy/city_birthdate/{id}', [CityBirthdateController::class, 'destroy'])->whereNumber('id');
    Route::get('/city_birthdate/filter', [CityBirthdateController::class, 'filter']);

    // Election
    Route::get('/election/{id}/show',[ElectionController::class,'show']);
    Route::get('/list/election', [ElectionController::class, 'index']);
    Route::get('/list/election/filter', [ElectionController::class, 'filter']);

    // Hotels
    Route::get('/hotels', [HotelController::class, 'hotels']);

    // IDH
    Route::get('/idh/{city_id}/{year}/show', [IDHController::class, 'show']);
    Route::get('/list/idh', [IDHController::class, 'list']);
    Route::get('/idh/filter', [IDHController::class, 'filter']);

    // Assembly (Câmara Municipal)
    Route::get('/assembly/{year}/{number}/{city_id}/show',[AssemblyController::class,'show']);
    Route::get('/list/assembly', [AssemblyController::class, 'index']);
    Route::get('/assembly/filter', [AssemblyController::class, 'filter']);

    // Population
    Route::get('/population/{id}/show',[PopulationController::class,'show']);
    Route::get('/list/population', [PopulationController::class, 'index']);

    // Education
    Route::get('/list/education', [EducationController::class, 'index']);
    Route::get('/list/education/filter', [EducationController::class, 'filter']);

    // Prefecture
    Route::get('/prefecture/{id}/show',[PrefectureController::class,'show']);
    Route::get('/list/prefecture', [PrefectureController::class, 'index']);
    Route::get('/list/prefecture/filter', [PrefectureController::class, 'filter']);
    Route::get('/prefecture/edit/{id}', [PrefectureController::class, 'edit'])->whereNumber('id');
    Route::post('/prefecture/update/{id}', [PrefectureController::class, 'update'])->whereNumber('id');


    // Reports

    // Schedule
    Route::get('/report/schedule', [ReportScheduleController::class, 'index']);
    Route::post('/report/schedule/filter', [ReportScheduleController::class, 'filter']);

    // Proposition
    Route::get('/report/proposition', [ReportPropositionController::class, 'index']);
    Route::post('/report/proposition/filter', [ReportPropositionController::class, 'filter']);
});
