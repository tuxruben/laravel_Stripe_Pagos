<?php

use App\User;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/producto/{id}', 'HomeController@show')->name('producto.show');
Route::get('/suscripcion/{id}', 'HomeController@showSuscripcion')->name('suscripcion.show');
Route::get('/setup-card', function(Request $request){
	$user = Auth::user();
return view('update-payment-method', [
    'intent' => $user->createSetupIntent()
]);
});
Route::post('/card-save', function(Request $request){
	$user = Auth::user();
$user->updateDefaultPaymentMethod($request->get('card'));
});
Route::get('/{sku}/producto-buy', function(Request $request, $sku){
	$user = Auth::user();
 $stripe = new \Stripe\StripeClient(
  'sk_test_51JNrhOA7H21qhYd10ekzaWuckSQzp1lGmxlJswksDB3KmObyENXK0IbvTKGeHLe0eVRkkNSKYmZO3Tl5Sk1HuXwY00Tc7eUV7B'
);
$sku =$stripe->prices->retrieve(
  $sku,
  []
);

$user->invoiceFor($sku->product, $sku->unit_amount, [
    'quantity' => 1,
], [
 'tax_percent' => 21,
]);
})->name('product-buy');
Route::get('/{plan}/plan-buy', function(Request $request, $plan){
	$user = Auth::user();
 $stripe = new \Stripe\StripeClient(
  'sk_test_51JNrhOA7H21qhYd10ekzaWuckSQzp1lGmxlJswksDB3KmObyENXK0IbvTKGeHLe0eVRkkNSKYmZO3Tl5Sk1HuXwY00Tc7eUV7B'
);
$plan =$stripe->plans->retrieve(
  $plan,
  []
);

$user->newSubscription($plan->product, $plan->id)->create($user->defaultPaymentMethod()->id);

})->name('plan-buy');