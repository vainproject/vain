<?php namespace Modules\Premium\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BitcoinController extends Controller {

    function __construct()
    {
        $this->middleware('payment.provider.enabled:bitcoin');
    }

    public function index(Request $request)
    {
        return view('premium::payment.bitcoin.index', ['user' => $request->user()]);
    }

}