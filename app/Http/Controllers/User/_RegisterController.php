<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Classes\GeniusMailer;
use App\Models\Notification;
use App\Models\Country;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Validator;

class RegisterController extends Controller
{

	public function showRegisterForm(){
		$countries = Country::where(['status' => 1])->get();
		return view('front.user.register',compact('countries'));
	}
    public function register(Request $request)
    {

    	$gs = Generalsetting::findOrFail(1);

		//--- Validation Section
		
		$phone = $request->phone;
		$request->merge([
		   'phone' => $request->country_code.$request->phone,
	   ]);
		$validator = Validator::make($request->all(), [ 
			'phone' => 'required|unique:users,phone',
	   ]);
	   
	   $request->merge([
		   'phone' => $phone,
	   ]);
	   
		if ($validator->fails()) { 
			return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
 	    }

        $rules = [
		        'email'   => 'required|email|unique:users',
				'password' => 'required|confirmed',
				'phone' => 'required|digits_between:8,14',
                ];
        $validator = Validator::make(Input::all(), $rules);
				
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

	        $user = new User;
			$input = $request->all();        
			$input['phone'] = $request->country_code.$request->phone;
			$input['password'] = bcrypt($request['password']);
	        $token = md5(time().$request->name.$request->email);
			$input['verification_link'] = $token;
	        $input['affilate_code'] = md5($request->name.$request->email);

	          if(!empty($request->vendor))
	          {
					//--- Validation Section
					$rules = [
						'shop_name' => 'unique:users',
						'shop_number'  => 'max:10'
							];
					$customs = [
						'shop_name.unique' => 'This Shop Name has already been taken.',
						'shop_number.max'  => 'Shop Number Must Be Less Then 10 Digit.'
					];

					$validator = Validator::make(Input::all(), $rules, $customs);
					if ($validator->fails()) {
					return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
					}
					$input['is_vendor'] = 1;

			  }
			  
			$user->fill($input)->save();
			if($gs->is_verification_email == 1){
				$to = $request->email;
				$subject = 'Verify your email address.';
				$msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
				//Sending Email To Customer
				$data = [
					'to' => $to,
					'subject' => $subject,
					'body' => $msg,
				];

				$mailer = new GeniusMailer();
				$mailer->sendCustomMail($data);

				// Sending Code to Mobile
				$code = substr(str_shuffle("0123456789"), 0, 4);
				DB::table('users')->where('id', $user->id)->update(['code' => $code]);
				$sMessage = $code;
				$iPhoneNumber = $user->phone;
				$iPhoneNumber = str_replace('+','',$iPhoneNumber);
				$url = "http://api.smscountry.com/SMSCwebservice_bulk.aspx";
				$post = ['User'=> "SoftGates",'passwd'=>"76393134",'sid'=> "8282",'mobilenumber'=> $iPhoneNumber,'message'=> $sMessage,'mtype'=> "N",'DR'=>'Y'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				$response = curl_exec($ch);
				$err = curl_error($ch);
				curl_close($ch);
				if ($err) {		
					return response()->json('Error In SMS .. '.$err);
				}
				else{
					return response()->json(2);
				}				

				return response()->json('We need to verify your email address. We have sent an email to '.$to.' to verify your email address. Please click link in that email to continue.');
	        }
	        else {
				$user->email_verified = 'Yes';
				$user->update();
				$notification = new Notification;
				$notification->user_id = $user->id;
				$notification->save();
				Auth::guard('web')->login($user); 
				return response()->json(1);
	        }
    }

    public function token($token)
    {
        $gs = Generalsetting::findOrFail(1);

        if($gs->is_verification_email == 1){    	
				$user = User::where('verification_link','=',$token)->first();
				if(isset($user))
				{
					$user->email_verified = 'Yes';
					$user->update();
					$notification = new Notification;
					$notification->user_id = $user->id;
					$notification->save();
					Auth::guard('web')->login($user); 
					return redirect()->route('user-dashboard')->with('success','Email Verified Successfully');
				}
    		}else{
	    		return redirect()->back();	
    		}
	}
	
	public function get_verify_page()
    {
        return view("front.user.verify");
	}
	
	public function verifyCode(Request $request)
    {
        $user = User::query()->where("code", $request->code)->first();

        if ($user) {
            if ($user->code != $request->code) {
                return redirect(route('verify_page'))->with(['error' => 'Error In Code .. ',
                    'alert-type' => 'error']);
            } else {
                DB::table('users')->where('id', $user->id)->update(['email_verified' => "Yes"]);
				Auth::login($user);				
				return redirect(route('user-dashboard'))->with(['message' => 'Your Account Verified Successfully',
				'alert-type' => 'success']);
            }
        }
        return redirect(route('verify_page'))->with(['error' => 'User not Found You Must Register .. ',
            'alert-type' => 'error']);
    }
}