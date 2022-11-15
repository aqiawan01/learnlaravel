<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Category;

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
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'is_admin']], function() {
     
        // User Routes
        Route::get('user/index', 'UserController@index')->name('user.index')->middleware('permission:user-list');
        Route::get('user/create', 'UserController@create')->name('user.create')->middleware('permission:user-create');
        Route::get('user/store', 'UserController@store')->name('user.store')->middleware('permission:user-create');
        Route::get('user/show', 'UserController@show')->name('user.show')->middleware('permission:user-list');
        Route::get('user/{user}/edit', 'UserController@edit')->name('user.edit')->middleware('permission:user-edit');
        Route::get('user/{user}/update', 'UserController@update')->name('user.update')->middleware('permission:user-edit');
        Route::get('user/{user}/destroy', 'UserController@destroy')->name('user.destroy')->middleware('permission:user-delete');
        Route::get('user/', 'UserController@index')->name('user.index')->middleware('permission:user-list')->middleware('permission:user-list');



        // Roles Routes
         Route::get('roles/index', 'RoleController@index')->name('role.index')->middleware('permission:role-list');
        Route::get('roles/create', 'RoleController@create')->name('role.create')->middleware('permission:role-create');
        Route::get('roles/store', 'RoleController@store')->name('role.store')->middleware('permission:role-create');
        Route::get('roles/show', 'RoleController@show')->name('role.show')->middleware('permission:role-list');
        Route::get('roles/{roles}/edit', 'RoleController@edit')->name('role.edit')->middleware('permission:role-edit');
        Route::get('roles/{roles}/update', 'RoleController@update')->name('role.update')->middleware('permission:role-edit');
        Route::get('roles/{roles}/destroy', 'RoleController@destroy')->name('role.destroy')->middleware('permission:role-delete');
        
        // category Routes
        Route::get('category/statusActive', 'CategoryController@statusActive')->name('category.statusActive');
        Route::get('category/statusDeactive', 'CategoryController@statusDeactive')->name('category.statusDeactive');
        Route::get('category/deleteAll', 'CategoryController@deleteAll')->name('category.deleteAll');
        Route::put('category/{category}/status', 'CategoryController@status');
        Route::resource('category', 'CategoryController');

        // Sub Category Routes
        Route::get('sub_category/statusActive', 'SubcategoryController@statusActive')->name('sub_category.statusActive');
        Route::get('sub_category/statusDeactive', 'SubcategoryController@statusDeactive')->name('sub_category.statusDeactive');
        Route::get('sub_category/deleteAll', 'SubcategoryController@deleteAll')->name('sub_category.deleteAll');
        Route::put('sub_category/{sub_category}/status', 'SubcategoryController@status');
        Route::resource('sub_category', 'SubcategoryController');


        // Product Routes
        Route::get('product/statusActive', 'ProductController@statusActive')->name('product.statusActive');
        Route::get('product/statusDeactive', 'ProductController@statusDeactive')->name('product.statusDeactive');
        Route::get('product/deleteAll', 'ProductController@deleteAll')->name('product.deleteAll');
        Route::put('product/{product}/status', 'ProductController@status');
        Route::resource('product', 'ProductController');

        // Brand Routes
        Route::get('brand/statusActive', 'BrandController@statusActive')->name('brand.statusActive');
        Route::get('brand/statusDeactive', 'BrandController@statusDeactive')->name('brand.statusDeactive');
        Route::get('brand/deleteAll', 'BrandController@deleteAll')->name('brand.deleteAll');
        Route::put('brand/{brand}/status', 'BrandController@status');
        Route::resource('brand', 'BrandController');
       
       
        Route::post('/updatepassword', 'HomeController@updatepassword')->name('update.password');
        Route::get('/profile', 'HomeController@profile');
        Route::post('/profile/update', 'HomeController@profile_update')->name('profile.update');

        Route::get('/ajax-subcat',function (Request $request) {

        $parent_id = $request->category_id;
         
        $subcategories = Category::where('parent_id',$parent_id)
                              ->get();
        return response()->json([
            'subcategories' => $subcategories

            ]);

        });




});


// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('books', BookController::class);
});
Auth::routes();
Route::get('admin/login', 'Auth\LoginController@adminShowLoginForm')->name('admin.login');
Route::get('/login', 'Auth\LoginController@ShowLoginForm')->name('login');

Route::get('admin/home', 'HomeController@adminHome')->name('admin.home');

Route::get('/home', 'HomeController@index')->name('home');
