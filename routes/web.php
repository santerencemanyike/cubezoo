<?php

Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
   
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Sites
    Route::delete('sites/destroy', 'SiteController@massDestroy')->name('sites.massDestroy');
    Route::get('sites', 'SiteController@index')->name('sites.index')->middleware('can:site_access');
    Route::get('sites/create', 'SiteController@create')->name('sites.create')->middleware('can:site_create');
    Route::post('sites', 'SiteController@store')->name('sites.store')->middleware('can:site_create');
    Route::get('sites/{site}/edit', 'SiteController@edit')->name('sites.edit')->middleware('can:site_edit');
    Route::put('sites/{site}', 'SiteController@update')->name('sites.update')->middleware('can:site_edit');
    Route::get('sites/{site}', 'SiteController@show')->name('sites.show')->middleware('can:site_show');
    Route::delete('sites/{site}', 'SiteController@destroy')->name('sites.destroy')->middleware('can:site_delete');

    // Visits
    Route::delete('visits/destroy', 'VisitController@massDestroy')->name('visits.massDestroy');
    Route::get('visits', 'VisitController@index')->name('visits.index')->middleware('can:visit_access');
    Route::get('visits/create/{site?}', 'VisitController@create')->name('visits.create')->middleware('can:visit_create');
    Route::post('visits', 'VisitController@store')->name('visits.store')->middleware('can:visit_create');
    Route::get('visits/{visit}/edit', 'VisitController@edit')->name('visits.edit')->middleware('can:visit_edit');
    Route::put('visits/{visit}', 'VisitController@update')->name('visits.update')->middleware('can:visit_edit');
    Route::get('visits/{visit}', 'VisitController@show')->name('visits.show')->middleware('can:visit_show');
    Route::delete('visits/{visit}', 'VisitController@destroy')->name('visits.destroy')->middleware('can:visit_delete');
    Route::post('visits/{visit}/submit', 'VisitController@submit')->name('visits.submit')->middleware('can:visit_edit');

    // Batch Jobs
    Route::post('/run-batch', 'BatchController@run')->name('batch.run');
    Route::get('/batch-progress/{id}', 'BatchController@progress')->name('batch.progress');
});

Route::post('password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'update'])->name('profile.passsword.reset');

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');

    }
});
