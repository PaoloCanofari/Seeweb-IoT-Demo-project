<?php

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
    return view('auth.login');
});

Route::post('/login', 'loginController@login');

Route::post('/status_trigger', 'device\deviceStatusTrigger@updateStatus');

Route::post('/devices', 'device\devicesController@main');

Route::post('/reg_device', 'device\regDeviceController@main');

Route::post('/delete_device', 'device\delete_device@delete');

Route::post('/change_config', 'dashboard\change_config@main');

Route::post('/input_config', 'dashboard\change_config@get_api');

Route::post('/over_value_trigger', 'device\overValueTrigger@main');

Route::post('/lower_value_trigger', 'device\lowerValueTrigger@main');

Route::post('/update_dashboard', 'dashboard\UpdateDashboard@main');
