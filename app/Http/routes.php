<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\User;

Route::get('/', ['middleware' => 'auth', function () {
    if(Entrust::hasRole('admin')){
        $users = \App\Role::where('name','=','user')->firstOrFail()->users;
        return View('admin/admin_home')->with('users', $users);
    }
    elseif(Entrust::hasRole('user')){
        $current_user = Auth::user();
        $contacts = \App\Contact::with('emails','phoneNumbers')->where('user_id','=',$current_user->id)->get();
        return View('contacts/user_home')->with('contacts',$contacts);
    }
    return view('welcome');
}]);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Admin routes
Route::group(['middleware' => 'auth'], function () {
// only users with roles that have the 'edit-users' permission will be able to access any route within admin/post
    Entrust::routeNeedsPermission('admin/*', 'edit-users',Redirect::to('errors/403'));
    Route::get('admin/create_user', 'Admin\AdminController@getCreateUser');
    Route::post('admin/create_user', 'Admin\AdminController@postCreateUser');
    Route::get('admin/delete_user/{id}', 'Admin\AdminController@getDeleteUser');
    Route::post('admin/delete_user/{id}', 'Admin\AdminController@postDeleteUser');
    Route::get('admin/update_user/{id}', 'Admin\AdminController@getUpdateUser');
    Route::post('admin/update_user/{id}', 'Admin\AdminController@postUpdateUser');
});

// Contacts routes
Route::group(['middleware' => 'auth'], function () {
// only users with roles that have the 'edit-users' permission will be able to access any route within admin/post
    Entrust::routeNeedsPermission('contacts/*', 'edit-contacts',Redirect::to('errors/403'));
    Route::get('contacts/create_contact', 'Contacts\ContactsController@getCreateContact');
    Route::post('contacts/create_contact', 'Contacts\ContactsController@postCreateContact');
    Route::get('contacts/delete_contact/{id}', 'Contacts\ContactsController@getDeleteContact');
    Route::post('contacts/delete_contact/{id}', 'Contacts\ContactsController@postDeleteContact');
    Route::get('contacts/import_contacts', 'Contacts\ImportController@getImportContacts');
    Route::post('contacts/import_contacts', 'Contacts\ImportController@postImportContacts');
});

// errors
Route::get('/errors/503', function () {
    return view('errors/503');
});
Route::get('/errors/403', function () {
    return view('errors/403');
});