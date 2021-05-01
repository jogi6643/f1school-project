<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Payment;
use Redirect,Response;
use Auth;
use DB;
use Session;
use App\Activateaccount;

class RazorpayController extends Controller
{
    
     public function index()
	 {
	 	return view('payments.razorpay');
	 }

	 public function razorPaySuccess(Request $request){
		
		// $userid = Auth::user()->id;
		// $useremail = Auth::user()->email;
		 $userid = DB::table('students')
                  ->where('mobileno',Auth::user()->mobile_no)->where('dob',Auth::user()->dob)->first()->id;

		$data = [
	           'user_id' => $userid,
	           // 'user_email' => $useremail,
	           'payment_id' => $request->razorpay_payment_id,
	           'amount' => $request->totalAmount,
	           'order_id' => $request->order_id,
	        ];
// echo json_encode($data);
// die;
	 	$getId = Payment::insertGetId($data);  
	 	$arr = array('msg' => 'Payment successfully credited', 'status' => true);

      //dd(Session::get('set_order_id'));

	 	$orderSuccess = DB::table('orderdetailspaytem')
	 						->where('orderid', Session::get('set_order_id'))
	 						->update([

	 								'order_status' => 'Success'
	 							]);

	 	return Response()->json($arr);    
	 }

	 public function RazorThankYou()
	 {
	
		 return view('payments.thankyou');
	 }


	 public function activateAccount(Request $request){
		
		
		$data = [
	           'school_id' => $request->school_id,
	           'user_email' => $request->user_email,
	           'payment_id' => $request->razorpay_payment_id,
	           'amount' => $request->totalAmount,
	        ];

	 	$getId = ActivateAccount::insertGetId($data);  
	 	$arr = array('msg' => 'Payment successfully credited', 'status' => true);

      //dd(Session::get('set_order_id'));

	 	$orderSuccess = DB::table('schools')
	 						->where('id', $request->school_id)
	 						->update([

	 								'status' => '1'
	 							]);

	 	return Response()->json($arr);    
	 }
}
