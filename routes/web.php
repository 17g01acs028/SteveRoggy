<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Qcontroller;
use App\Http\Controllers\saveQuestions;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/registration/{token}', 'UserController@registration_view')->name('registration');
Route::POST('/registration', 'Auth\RegisterController@register')->name('accept');
Route::post('/users/invite', 'UserController@process_invites')->name('process_invite')->middleware('auth');
Route::get('/users/invite', 'UserController@invite_view')->name('invite_view')->middleware('auth');

Route::get('/tab1', 'ClientController@createStep1',function(){
  return view('/clients/create-step3');
})->name('tab_1')->middleware('auth');
Route::get('/tab2', 'ClientController@createStep1',function(){
  return view('/clients/create-step3');
})->name('tab_2')->middleware('auth');
Route::get('/tab3', 'ClientController@createStep1',function(){
  return view('/clients/create-step3');
})->name('tab_3')->middleware('auth');
Route::post('/clients/create-step0', 'ClientController@postCreateStep1')->name('step1_post')->middleware('auth');
Route::post('/clients/create-step00', 'ClientController@postCreateStep2')->name('step2_post')->middleware('auth');
Route::post('/clients/create-step000', 'ClientController@postCreateStep3')->name('step3_post')->middleware('auth');
Route::get('/tab0', 'ClientController@resetClient')->name('reset_client')->middleware('auth');

Route::get('/tabN1', 'NetworkController@createStep1',function(){
  return view('/networks/create-step3');
})->name('tabN_1')->middleware('auth');
Route::get('/tabN2', 'NetworkController@createStep1',function(){
  return view('/networks/create-step3');
})->name('tabN_2')->middleware('auth');
Route::get('/tabN3', 'NetworkController@createStep1',function(){
  return view('/networks/create-step3');
})->name('tabN_3')->middleware('auth');
Route::post('/networks/create-step0', 'NetworkController@postCreateStep1')->name('stepN1_post')->middleware('auth');
Route::post('/networks/create-step00', 'NetworkController@postCreateStep2')->name('stepN2_post')->middleware('auth');
Route::post('/networks/create-step000', 'NetworkController@postCreateStep3')->name('stepN3_post')->middleware('auth');
Route::get('/tabN0', 'NetworkController@resetNetwork')->name('reset_network')->middleware('auth');

Route::get('/tabM1', 'MessageController@createStep1',function(){
  return view('/messages/create-step3');
})->name('tabM_1')->middleware('auth');
Route::get('/tabM2', 'MessageController@createStep1',function(){
  return view('/messages/create-step3');
})->name('tabM_2')->middleware('auth');
Route::get('/tabM3', 'MessageController@createStep1',function(){
  return view('/messages/create-step3');
})->name('tabM_3')->middleware('auth');
Route::post('/messages/create-step0', 'MessageController@postCreateStep1')->name('stepM1_post')->middleware('auth');
Route::post('/messages/create-step00', 'MessageController@postCreateStep2')->name('stepM2_post')->middleware('auth');
Route::post('/messages/create-step000', 'MessageController@postCreateStep3')->name('stepM3_post')->middleware('auth');

Route::get('/tabM3Rep', 'MessageController@createStepReport1',function(){
return view('/messages');
})->name('tabM_3Rep')->middleware('auth');
Route::post('/mess', 'MessageController@postCreateStepReport1')->name('stepM1_postReport')->middleware('auth');


Route::get('/tabG1', 'GroupController@createStep1',function(){
  return view('/groups/create-step3');
})->name('tabG_1')->middleware('auth');
Route::get('/tabG2', 'GroupController@createStep1',function(){
  return view('/groups/create-step3');
})->name('tabG_2')->middleware('auth');
Route::get('/tabG3', 'GroupController@createStep1',function(){
  return view('/groups/create-step3');
})->name('tabG_3')->middleware('auth');
Route::post('/groups/create-step0', 'GroupController@postCreateStep1')->name('stepG1_post')->middleware('auth');
Route::post('/groups/create-step00', 'GroupController@postCreateStep2')->name('stepG2_post')->middleware('auth');
Route::post('/groups/create-step000', 'GroupController@postCreateStep3')->name('stepG3_post')->middleware('auth');

Route::get('/contacts/import', 'ContactController@getImport')->name('import')->middleware('auth');
Route::post('/contacts/import_parse', 'ContactController@parseImport')->name('import_parse')->middleware('auth');
Route::post('/contacts/import_process', 'ContactController@processImport')->name('import_process')->middleware('auth');

Route::post('/detach', 'ContactGroupController@detach')->name('detach_contact')->middleware('auth');
Route::post('/detach_sender', 'ClientSenderController@detach')->name('detach_client')->middleware('auth');

Route::post('/pass', 'UserController@pass_id')->name('pass_id')->middleware('auth');
Route::post('/approve', 'AllocationController@approve')->name('approve')->middleware('auth');
Route::post('/approve_client', 'ClientController@approve')->name('approve_client')->middleware('auth');
Route::post('/dissapprove_client', 'ClientController@dissapprove')->name('dissapprove_client')->middleware('auth');

Route::post('/enable_notfis', 'UserController@enable')->name('enable_notfis')->middleware('auth');
Route::post('/disable_notfis', 'UserController@disable')->name('disable_notfis')->middleware('auth');


Route::get('/users/{user}/edit_user', 'UserController@edit_user')->name('edit_user')->middleware('auth');
Route::put('/users/update_user/{user}', 'UserController@update_user')->name('update_user')->middleware('auth');
Route::get('/users/show_user/{user}', 'UserController@show_user')->name('show_user')->middleware('auth');
Route::get('/users/show_client/{client}', 'UserController@show_client')->name('show_client')->middleware('auth');

Route::get('/clients/clients_credits', 'ClientController@clients_credits')->name('clients_credits')->middleware('auth');

Route::post('/daterange', 'HomeController@postCreateStep')->name('daterange')->middleware('auth');


Route::resource('clients', 'ClientController')->middleware('auth');
Route::resource('users','UserController');
Route::resource('invites', 'InviteController')->middleware('auth');
Route::resource('allocations', 'AllocationController')->middleware('auth');
Route::resource('networks', 'NetworkController')->middleware('auth');
Route::resource('prefixes', 'PrefixController')->middleware('auth');
Route::resource('routes', 'RouteController')->middleware('auth');
Route::resource('route_maps', 'RouteMapController')->middleware('auth');
Route::resource('messages', 'MessageController')->middleware('auth');
Route::resource('received', 'MessageReceivedController')->middleware('auth');
Route::get('inbox', 'MessageReceivedController@inbox')->name('inbox')->middleware('auth');

Route::resource('groups', 'GroupController')->middleware('auth');
Route::resource('contacts', 'ContactController')->middleware('auth');
Route::resource('contact_groups', 'ContactGroupController')->middleware('auth');
Route::resource('schedules', 'ScheduleController')->middleware('auth');
Route::resource('templates', 'TemplateController')->middleware('auth');
Route::resource('senders', 'SenderController')->middleware('auth');
Route::resource('client_senders', 'ClientSenderController')->middleware('auth');
Route::resource('roles','RoleController')->middleware('auth');
Route::resource('mpesa_codes', 'MpesaCodeController')->middleware('auth');
Route::resource('transactions', 'TransactionController')->middleware('auth');
Route::resource('notfis','NotfiController')->middleware('auth');
Route::resource('balances', 'BalanceController')->middleware('auth');
//callback url
Route::post('messages/received', 'MessageReceivedController@messagesReceived');
Route::get('/userlist/{id?}', 'MessageReceivedController@user_list')->name('user.list');
Route::get('usermessage/{id}/{short_code_id?}', 'MessageReceivedController@user_message')->name('user.message');
Route::post('sendmessage', 'MessageReceivedController@send_message')->name('user.message.send');
Route::get('get_codes', 'MessageReceivedController@getShortCodes');

Route::resource('shortcodes', 'ShortCodeController')->middleware('auth');
Route::post('destroy', 'ShortCodeController@destroy')->name('destroy')->middleware('auth');


Route::resource('sender_prices', 'SenderPriceController')->middleware('auth');
Route::resource('shortcode_prices', 'ShortcodePriceController')->middleware('auth');


/*

defining the routes for the survey here
including :: survey routes
questions routes
options routes
responses routes
*/
Route::view('question/create', 'question.create');
Route::post("question/create",[saveQuestions::class,'index']);
Route::resource('survey', 'SurveyController')->middleware('auth');
Route::resource('questions', 'saveQuestions')->middleware('auth');
Route::resource('option','OptionController')->middleware('auth');
Route::resource('response', 'ResponseController')->middleware('auth');
