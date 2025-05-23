<?php
use App\Http\Controllers\AssetImportExcelController;
use App\Http\Controllers\LaptopAssetCodeController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\UserController;
use App\Models\Branch;
use App\Models\Department;
use App\Http\Controllers\AssetOperatorController;
use App\Http\Controllers\NonAssetImportController;
use App\Models\LaptopAssetCode;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/user_login/{employee_id}/{password}', function($employee_id, $password){
    return view('auth.user_login', compact('employee_id', 'password'));
})->name('user_login');
Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
Route::get('/', function () {

    $datas=LaptopAssetCode::latest()->paginate(20);
    $branches=Branch::all();
    $departments=Department::all();
    return view('dashboard',compact('datas','branches','departments'));
});

Route::resource('employee_benefic/laptop_asset_code', LaptopAssetCodeController::class);
Route::resource('employee_benefic/all_user', UserController::class);
Route::match(['get', 'post'], '/employee_benefic/search', [LaptopAssetCodeController::class, 'search'])->name('employee_benefic.search');
Route::match(['get', 'post'], '/all_user/search', [UserController::class, 'search'])->name('all_user.search');
Route::delete('/employee_benefic/delete_record/{id}',[LaptopAssetCodeController::class,'deletRecord']);
Route::delete('/all_user/delete_record/{id}',[UserController::class,'destroy']);
Route::delete('/employee_asset/delete_upload_record/{id}',[LaptopAssetCodeController::class,'deletUpload']);
Route::delete('/employee_asset/delete_asset_record/{id}',[LaptopAssetCodeController::class,'deletasset']);
Route::post('change_password/{id}',[App\Http\Controllers\UserController::class,'changePassword'])->name('change_password');
Route::get('branch_name/all_branchcode/{branch_name}', [LaptopAssetCodeController::class, 'branchSearch']);
Route::post('employee_asset/excel_import', [AssetImportExcelController::class, 'importExcel'])->name('excel_import');

Route::get('employee_asset/search_emp_id/{emp_id}', [LaptopAssetCodeController::class, 'empIDsearch']);
Route::get('employee_asset/search_asset_code/{asset_code}', [LaptopAssetCodeController::class, 'assetCodesearch']);
Route::get('employee_asset/search_asset_code2/{asset_code2}', [LaptopAssetCodeController::class, 'assetCodesearch']);
Route::get('/limit_rows', [LaptopAssetCodeController::class, 'paginateData']);
Route::get('/laptop-asset-code/export', [LaptopAssetCodeController::class, 'export'])->name('laptop-asset-code.export');
Route::get('/laptop_asset_code/fix-asset', [LaptopAssetCodeController::class, 'fix_asset'])->name('laptop_asset_code.fix_asset');

Route::post('/remark-form',  [LaptopAssetCodeController::class, 'reMark'])->name('remark-form');
Route::post('/operator-form',  [LaptopAssetCodeController::class, 'OpNew'])->name('operator-form');
Route::get('/remark/delete_remark/{id}',[LaptopAssetCodeController::class,'deletRemark']);
Route::get('/operator/delete_operator/{id}',[LaptopAssetCodeController::class,'deleteOperator']);

Route::post('/remark_update/{id}', [LaptopAssetCodeController::class, 'updateRemark']);
Route::match(['get', 'post'], '/employee_asset/asset_updatestore', [LaptopAssetCodeController::class, 'updateStore'])->name('asset_updatestore');
Route::get('/search_asset_code',[LaptopAssetCodeController::class,'search_asset_code'])->name('search_asset_code');
Route::get('/detail_fixasset/{asset_code}',[LaptopAssetCodeController::class,'fix_detail'])->name('detail_fixasset');
Route::put('/update_operator/{id}',[LaptopAssetCodeController::class,'update_operator'])->name('update_operator');
Route::put('/update_contract/{id}',[LaptopAssetCodeController::class,'update_contract'])->name('update_contract');
Route::post('operator_import/excel_import_operator', [OperatorController::class, 'importExcelOperator'])->name('excel_import_operator');

//--------------------------------------------------non asset code operator------------------------------
Route::get('non_asset_code_operator/non_asset_code_operator',[LaptopAssetCodeController::class,'non_asset_operator'])->name('laptop_asset_code.nonasset_operator');
Route::get('/create_nonasset_operator/create_non_asset_code_operator',[LaptopAssetCodeController::class,'nonasset_operator_create'])->name('laptop_asset_code.create_non_op');
Route::post('/non_asset_codeop_form',  [LaptopAssetCodeController::class, 'NonOpCreate'])->name('non_asset_codeop_form');
Route::delete('/non_asset_operator/delete_record/{id}',[LaptopAssetCodeController::class,'deletRecordNon']);
Route::get('/detail_non_asset_code/{doc_no}',[LaptopAssetCodeController::class,'getEditnonOp'])->name('detail_non_asset_detail');

Route::post('/operator-form-non-asset_code',  [LaptopAssetCodeController::class, 'OpNonNew'])->name('operator-form-non');
Route::put('/update_operator_non_asset_code/{id}',[LaptopAssetCodeController::class,'update_operator_non'])->name('update_operator_non');
Route::put('/update_contract_non_asset_code/{id}',[LaptopAssetCodeController::class,'update_contract_non'])->name('update_contract_non');

// Route::get('/non-remark/delete_remark/{id}',[LaptopAssetCodeController::class,'deletRemarknon']);

Route::delete('/non-remark/delete_remark/{id}',[LaptopAssetCodeController::class,'deletRemarknon']);
Route::get('/non-operator/delete_operator/{id}',[LaptopAssetCodeController::class,'deleteOperatornon']);
Route::post('/assetoperator_import', [AssetOperatorController::class, 'import'])->name('assetoperator.import');
Route::post('/assetnonoperator_import', [NonAssetImportController::class, 'import'])->name('nonassetoperator.import');
Route::put('/nonoperator_move_assetoperator/{id}', [LaptopAssetCodeController::class, 'moveAsset'])->name('asset.move');
});

Route::post('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
