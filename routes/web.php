<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\Appartement\AppartController;
use App\Http\Controllers\Appartement\AppartHistoricController;
use App\Http\Controllers\Appartement\AppartRecapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndicePriceController;
use App\Http\Controllers\Vehicles\VehicleController;
use App\Http\Controllers\Vehicles\VehicleHistoricController;
use App\Http\Controllers\Vehicles\VehicleRepairController;
use App\Http\Controllers\Vehicles\VehiclesRecapController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class, 'index'])->middleware(
    'guest:sanctum'
);

Route::get('/home', [AuthController::class, 'index']);

// Inscription
Route::post('/register', [AuthController::class, 'register'])->middleware('auth:sanctum');
Route::get('/logout', [AuthController::class, 'signOut'])->name('logout');


Route::get('/login', [AuthController::class, 'index'])->middleware(
    'guest:sanctum'
)->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware(
    'guest:sanctum'
)->name('login_check');

Route::get('/email/verification/{user}', [
    AgentController::class,
    'verify',
])->name('validate_account');



Route::group(['middleware' => ['auth:sanctum']], function () {
    //vehicle route
    Route::get('/vehicle-dash', [VehicleController::class, 'index'])->name('vehicle_dash');
    Route::post('/add-vehicle', [VehicleController::class, 'store'])->name('addVehicle');
    Route::get('/list-vehicle', [VehicleController::class, 'getVehicles'])->name('getVehicles');
    Route::post('/get-vehicle', [VehicleController::class, 'getVehicleById'])->name('getVehicleById');
    Route::post('/update-vehicle', [VehicleController::class, 'updateVehicle'])->name('updateVehicle');
    Route::get('/matricules-vehicle', [VehicleController::class, 'getMatriculesList'])->name('getMatriculesList');

    //vehicle-historic route
    Route::get('/vehicle-historic-dash', [VehicleHistoricController::class, 'getVehicleActivities'])->name('vehicle_activites_dash');
    Route::post('/add-historic', [VehicleHistoricController::class, 'store'])->name('add_historic');
    Route::post('/list-historic', [VehicleHistoricController::class, 'getHistoric'])->name('getHistoric');
    Route::post('/get-historic', [VehicleHistoricController::class, 'getHistoricById'])->name('getHistoricById');
    Route::post('/update-historic', [VehicleHistoricController::class, 'updateHistoric'])->name('updateHistoric');

    //appart route
    Route::get('/appart-dash', [AppartController::class, 'index'])->name('appart_dash');
    Route::post('/add-appart', [AppartController::class, 'store'])->name('addAppart');
    Route::get('/list-appart', [AppartController::class, 'getApparts'])->name('getApparts');
    Route::post('/get-appart', [AppartController::class, 'getAppartById'])->name('getAppartById');
    Route::post('/appart-by-type', [AppartController::class, 'getAppartByType'])->name('getAppartByType');
    Route::post('/update-appart', [AppartController::class, 'updateAppart'])->name('updateAppart');
    Route::get('/active-appart', [AppartController::class, 'getValidAppart'])->name('getValidAppart');

    //appart-historic route
    Route::get('/appart-historic-dash', [AppartHistoricController::class, 'getAppartActivities'])->name('appart_activites_dash');
    Route::post('/add-appart-historic', [AppartHistoricController::class, 'store'])->name('addAppartHistoric');
    Route::post('/list-appart-historic', [AppartHistoricController::class, 'getAppartHistoric'])->name('getAppartHistoric');
    Route::post('/get-appart-historic', [AppartHistoricController::class, 'getAppartHistoricById'])->name('getAppartHistoricById');
    Route::post('/update-appart-historic', [AppartHistoricController::class, 'updateAppartHistoric'])->name('updateAppartHistoric');

    // agent routes
    Route::get('/agent-dash', [AgentController::class, 'index'])->name('agent_dash');
    Route::post('/add-agent', [AgentController::class, 'store'])->name('addAgent');
    Route::get('/list-agent', [AgentController::class, 'getAgents'])->name('getAgents');
    Route::post('/update-agent', [AgentController::class, 'updateAgent'])->name('updateAgent');
    Route::post('/get-agent', [AgentController::class, 'getAgentById'])->name('getAgentById');
    Route::get('/get-recap-agent', [AgentController::class, 'getRecapAgent'])->name('getRecapAgent');


    //vehicle recap routes
    Route::get('/vehicle-recap', [VehiclesRecapController::class, 'indexRecap'])->name('recapIndex');
    Route::post('/get-vehicle-recap', [VehiclesRecapController::class, 'recapVehicles'])->name('recapVehicles');
    Route::get('/get-vehicle-data', [VehicleController::class, 'getVehicleRecapData'])->name('getVehicleRecapData');

    //appart recap routes
    Route::get('/appart-recap', [AppartRecapController::class, 'indexRecap'])->name('recapIndexAppart');
    Route::post('/get-appart-recap', [AppartRecapController::class, 'recapAppartements'])->name('recapApparts');
    Route::get('/get-appart-data', [AppartController::class, 'getAppartRecapData'])->name('getAppartRecapData');



    Route::post('/get-indice', [IndicePriceController::class, 'getIndiceByTypeDays'])->name('getIndiceByTypeDays');

    //repair
    Route::get('/vehicle-repair', [VehicleRepairController::class, 'indexRepair'])->name('repairIndex');
    Route::get('/list-repair', [VehicleRepairController::class, 'getRepairs'])->name('getRepairs');
    Route::post('/add-repair', [VehicleRepairController::class, 'store'])->name('addRepair');
    Route::post('/get-repair', [VehicleRepairController::class, 'getRepairById'])->name('getRepairById');
    Route::post('/get-repair', [VehicleRepairController::class, 'getRepairById'])->name('getRepairById');
    Route::post('/update-repair', [VehicleRepairController::class, 'updateRepair'])->name('updateRepair');





    // home dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/changepassword', [
        AuthController::class,
        'changePassword',
    ])->name('change_password');

    Route::get('/get-change-password', [
        AuthController::class,
        'getChangePassword',
    ])->name('getChangePassword');
});
