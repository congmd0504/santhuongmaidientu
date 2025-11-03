<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
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
//Artisan::call('storage:link');
Route::get('test', function () {
	// $a = bcrypt('1234567890');
	// echo $a;
	$data = App\Models\District::find(1)->communes()->get();
	$countView = new \App\Helper\CountView();
	$model = new \App\Models\Product();
	$countView->countView($model, 'view', 'product', 5);
});

Route::group(
	[
		'prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']
	],
	function () {
		UniSharp\LaravelFilemanager\Lfm::routes();
	}
);

Route::get('/upDatePointWhenEndMonth', "ProfileController@upDatePointWhenEndMonth")->name("profile.upDatePointWhenEndMonth");
Route::get('/upDatePointWhenEndYear', "ProfileController@upDatePointWhenEndYear")->name("profile.upDatePointWhenEndYear");

Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function () {
	Route::group(['prefix' => 'address'], function () {
		Route::get('district', 'AddressController@getDistricts')->name('ajax.address.districts');
		Route::get('communes', 'AddressController@getCommunes')->name('ajax.address.communes');
	});
});

Route::group(['prefix' => 'cart', 'middleware' => ['auth', 'cartToggle']], function () {
	Route::get('list', 'ShoppingCartController@list')->name('cart.list');
	Route::get('add/{id}', 'ShoppingCartController@add')->name('cart.add');
	Route::get('apply-code-sale', 'ShoppingCartController@applyCodeSale')->name('cart.applyCodeSale');
	Route::get('buy/{id}', 'ShoppingCartController@buy')->name('cart.buy');
	Route::get('remove/{id}', 'ShoppingCartController@remove')->name('cart.remove');
	Route::get('update/{id}', 'ShoppingCartController@update')->name('cart.update');
	Route::get('clear', 'ShoppingCartController@clear')->name('cart.clear');
	Route::post('order', 'ShoppingCartController@postOrder')->name('cart.order.submit');
	Route::get('order/sucess/{id}', 'ShoppingCartController@getOrderSuccess')->name('cart.order.sucess');
});
//Auth::routes();
Route::get('login', "Auth\LoginController@showLoginForm")->name("login");
Route::post('logout', "Auth\LoginController@logout")->name("logout");
Route::post('login', "Auth\LoginController@login")->name("login.submit");


Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
	Route::get('/', 'ProfileController@index')->name('profile.index');
	Route::get('/history', 'ProfileController@history')->name('profile.history');
	Route::get('/transaction-detail/{id}', "ProfileController@loadTransactionDetail")->name("profile.transaction.detail");
	Route::get('/list-rose', 'ProfileController@listRose')->name('profile.listRose');
	Route::get('/list-member', 'ProfileController@listMember')->name('profile.listMember');
	// Route::get('/create-member', 'ProfileController@createMember')->name('profile.createMember');
	// Route::post('/store-member', 'ProfileController@storeMember')->name('profile.storeMember');
	Route::post('/draw-point', 'ProfileController@drawPoint')->name('profile.drawPoint')->middleware('checkUserActive');
    Route::post('/Shoot-BB', 'ProfileController@shootBB')->name('profile.shootBB')->middleware('checkUserActive');
	Route::post('/doi-xu', 'ProfileController@pointToXu')->name('profile.pointToXu')->middleware('checkUserActive');
	Route::get('/history-draw-point', 'ProfileController@historyDrawPoint')->name('profile.history-draw-point');
	Route::get('/lich-su-nap-tien', 'ProfileController@lichSuNapTien')->name('profile.lichSuNapTien');
	Route::get('/lich-su-rut-tien', 'ProfileController@lichSuRutTien')->name('profile.lichSuRutTien');
	Route::get('/edit-info', 'ProfileController@editInfo')->name('profile.editInfo');
	Route::post('/update-info/{id}', 'ProfileController@updateInfo')->name('profile.updateInfo')->middleware('profileOwnUser');
	Route::get('/momo_payment', 'ProfileController@momoPayment')->name('profile.momoPayment');
	Route::post('/momo_payment_post', 'ProfileController@momoPaymentPost')->name('profile.momoPaymentPost');
	Route::post('/nl_payment_post', 'ProfileController@nganLuongPaymentPost')->name('profile.nganLuongPaymentPost');
	Route::get('/momo_payment_success', 'ProfileController@momoPaymentSuccess')->name('profile.momoPaymentSuccess');
	Route::get('/nl_payment_success', 'ProfileController@nganLuongPaymentSuccess')->name('profile.nganLuongPaymentSuccess');

	//  Route::get('{id}-{slug}', 'ProductController@detail')->name('product.detail');
	//  Route::get('/category-product/{id}-{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
});
Route::get('/', 'HomeController@index')->name('home.index');



// gii thiệu
Route::group(['prefix' => 'about-us'], function () {
	Route::get('/', 'HomeController@aboutUs')->name('about-us');
});

Route::group(['prefix' => 'product'], function () {
	Route::get('/', 'ProductController@index')->name('product.index');
	Route::get('{id}-{slug}', 'ProductController@detail')->name('product.detail');
	Route::get('/category-product/{id}-{slug}', 'ProductController@productByCategory')->name('product.productByCategory');
});


Route::get('product-sale', 'ProductController@productSale')->name('product.sale');
Route::get('product-new', 'ProductController@productNew')->name('product.new');
Route::get('product-selling', 'ProductController@productSelling')->name('product.selling');



Route::group(['prefix' => 'post'], function () {
	Route::get('/', 'PostController@index')->name('post.index');
	Route::get('{id}-{slug}', 'PostController@detail')->name('post.detail');
	Route::get('/category-post/{id}-{slug}', 'PostController@postByCategory')->name('post.postByCategory');
});

Route::group(['prefix' => 'contact'], function () {
	Route::get('/', 'ContactController@index')->name('contact.index');
	Route::post('/store-ajax', 'ContactController@storeAjax')->name('contact.storeAjax');
});

Route::group(['prefix' => 'search'], function () {
	Route::get('/', 'HomeController@search')->name('home.search');
});
Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'comment'], function () {
		Route::post('/{type}/{id}', 'CommentController@store')->name('comment.store');
	});
	Route::get('/mang-xa-hoi', 'PostController@socialNetwork')->name('socialNetwork');
	Route::get('/thong-bao', 'ProfileController@notification')->name('notification');
	Route::get('/danh-sach-bai-dang', 'PostController@listPostByUser')->name('listPostByUser');
	Route::get('/dang-bai', 'PostController@create')->name('post.create');
	Route::get('/commentPost/{id}', 'PostController@commentPost')->name('commentPost');
	Route::get('/sua-bai/{id}', 'PostController@edit')->name('post.edit');
	Route::get('/destroy-comment/{id}/{post_id}', 'PostController@destroyComment')->name('destroyComment');
	Route::get('/destroy/{id}', "Admin\AdminPostController@destroy")->name("post.destroy");

	Route::post('/update-bai/{id}', 'PostController@update')->name('post.update');
	Route::post('/store/dang-bai', 'PostController@store')->name('post.store');

	Route::get('/like/{id_post}', 'PostController@like')->name('post.like');
});

Route::get('/quen-mat-khau', 'ProfileController@forgotPassWord')->name('forgotPassWord');
Route::post('/forgotPassword', 'ProfileController@resetPassword')->name('resetPassword');


Route::group(['prefix' => 'profile/register'], function () {
	Route::get('/{code}', 'ProfileController@createRegisterReferral')->name('profile.register-referral.create');
	Route::post('/store', 'ProfileController@storeRegisterReferral')->name('profile.register-referral.store');
});
// auth
Auth::routes();
