<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $stripe = new \Stripe\StripeClient(
  'sk_test_51JNrhOA7H21qhYd10ekzaWuckSQzp1lGmxlJswksDB3KmObyENXK0IbvTKGeHLe0eVRkkNSKYmZO3Tl5Sk1HuXwY00Tc7eUV7B'
);
$skus = $stripe->products->all();
$suscripcion = $stripe->plans->all(['limit' => 3]);
        return view('list',['skus' => $skus, 'suscripcion' =>$suscripcion]);
    }

      public function show($id)
    {
          $stripe = new \Stripe\StripeClient(
  'sk_test_51JNrhOA7H21qhYd10ekzaWuckSQzp1lGmxlJswksDB3KmObyENXK0IbvTKGeHLe0eVRkkNSKYmZO3Tl5Sk1HuXwY00Tc7eUV7B'
);
$skus = $stripe->prices->all();
        return view('show', ['skus' => $skus, 'id' =>$id]);
    }
     public function showSuscripcion($id)
    {
          $stripe = new \Stripe\StripeClient(
  'sk_test_51JNrhOA7H21qhYd10ekzaWuckSQzp1lGmxlJswksDB3KmObyENXK0IbvTKGeHLe0eVRkkNSKYmZO3Tl5Sk1HuXwY00Tc7eUV7B'
);
$skus = $stripe->prices->all();
        return view('suscripcion.show', ['skus' => $skus, 'id' =>$id]);
    }
}
