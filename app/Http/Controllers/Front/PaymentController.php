<?php

namespace App\Http\Controllers\Front;
use App\Classes\GeniusMailer;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Pagesetting;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\UserNotification;
use Config;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

 public function store(Request $request){
    $validator = Validator::make($request->all(), [ 
        'name' => 'required|regex:/^[\pL\s\-]+$/u',
        'customer_country' => 'required|',
        'address' => 'required|max:500',
        'city' => 'required|regex:/^[\pL\s\-]+$/u',
        'email' => 'required|email',
        'phone' => 'required|digits_between:7,14',
        'zip' => 'required',
        'company_name' => 'required',
        'state' => 'required',
    ]);
 
    if ($validator->fails()) { 
        return redirect()->back()->withErrors($validator)->withInput();
    }


    if (!Session::has('cart')) {
        return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
     }

     session()->put('order_placed', request()->all());

     $oldCart = Session::get('cart');
     $cart = new Cart($oldCart);
     $curr = Currency::where('is_default','=',1)->first();
    
     $settings = Generalsetting::findOrFail(1);
     $paypal_email = $settings->paypal_business;
     $return_url = action('Front\PaymentController@payreturn');
     $cancel_url = action('Front\PaymentController@paycancle');
     $notify_url = action('Front\PaymentController@notify');

     $item_name = $settings->title." Order";
     $item_number = str_random(4).time();

     $inbuild_discount = 0;
     if($cart->items)
     foreach($cart->items as $item){
         $pr = Product::where(['id' => $item['item']['id']])->first();
         $inbuild_discount = $inbuild_discount + $pr->dsc_amt;
     }


     $item_amount = $request->total - (round($inbuild_discount * $curr->value,2));

     if($request->shipping){
        $item_amount = $item_amount + $request->shipping;
        $request->shipping = $request->shipping/$curr->value; 
     }

     $item_amount = $item_amount/$curr->value;

     $eur = Currency::where(['name' => 'GBP'])->first();
     if($eur){
        $euro_amount = $item_amount * $eur->value;
     }

        $querystring = '';

        // Firstly Append paypal account to querystring
        $querystring .= "?business=".urlencode($paypal_email)."&";
   
        // Append amount& currency (£) to quersytring so it cannot be edited in html
   
        //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
        $querystring .= "item_name=".urlencode($item_name)."&";

        if($eur){
            $querystring .= "amount=".urlencode($euro_amount)."&";
        }else{
            $querystring .= "amount=".urlencode($item_amount)."&";
        }

        $querystring .= "item_number=".urlencode($item_number)."&";
   
        $querystring .= "cmd=_xclick&";
        $querystring .= "bn=PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest&";
        $querystring .= "lc=UK&";
        if($eur){
            $querystring .= "currency_code=GBP&";
        }else{
            $querystring .= "currency_code=USD&";
        }
   
       // Append paypal return addresses
       $querystring .= "return=".urlencode(stripslashes($return_url))."&";
       $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
       $querystring .= "notify_url=".urlencode($notify_url)."&";
   
       $querystring .= "custom=".$request->user_id;
       // Redirect to paypal IPN


     if($settings->paypal_check == 0){
        return redirect('https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
     }else{
        return redirect('https://www.paypal.com/cgi-bin/webscr'.$querystring);
     }
 }


     public function paycancle(Request $request){
        $order = Order::where(['id' => $request->order_id])->first();
        $order->delete();
                
        return redirect()->route('front.cart')->with('unsuccess','Payment Cancelled.');
     }

     public function payreturn(Request $request){
        $txnid = $request->tx;
        $request = Session::get('order_placed');

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $curr = Currency::where('is_default','=',1)->first();
       
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $paypal_email = $settings->paypal_business;
   
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();

        $inbuild_discount = 0;
        if($cart->items)
        foreach($cart->items as $item){
            $pr = Product::where(['id' => $item['item']['id']])->first();
            $inbuild_discount = $inbuild_discount + $pr->dsc_amt;
        }
   
   
        $item_amount = $request['total'] - (round($inbuild_discount * $curr->value));

        if($request['shipping']){
           $item_amount = $item_amount + $request['shipping'];
           $request['shipping'] = $request['shipping']/$curr->value; 
        }
        $item_amount = $item_amount/$curr->value;
   
        $eur = Currency::where(['name' => 'GBP'])->first();
        if($eur){
           $euro_amount = $item_amount * $eur->value;
        }
   
           $order['user_id'] = $request['user_id'];
           $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
           $order['totalQty'] = $request['totalQty'];
           $order['pay_amount'] = $item_amount;
           $order['method'] = "Paypal";
           $order['customer_email'] = $request['email'];
           $order['customer_name'] = $request['name'];
           $order['customer_phone'] = $request['phone'];
           $order['order_number'] = $item_number;
           $order['shipping'] = $request['shipping'];
           $order['pickup_location'] = isset($request['pickup_location'])? $request['pickup_location'] : '';
           $order['customer_address'] = $request['address'];
           $order['customer_country'] = $request['customer_country'];
           $order['customer_city'] = $request['city'];
           $order['customer_zip'] = $request['zip'];
           $order['shipping_email'] = $request['shipping_email'];
           $order['shipping_name'] = $request['shipping_name'];
           $order['shipping_phone'] = $request['shipping_phone'];
           $order['shipping_address'] = $request['shipping_address'];
           $order['shipping_country'] = $request['shipping_country'];
           $order['shipping_city'] = $request['shipping_city'];
           $order['shipping_zip'] = $request['shipping_zip'];
           $order['order_note'] = isset($request['order_notes'])? $request['order_notes'] : ''; 
           $order['coupon_code'] = isset($request['coupon_code'])? $request['coupon_code'] : '';
           $order['coupon_discount'] = isset($request['coupon_discount'])? $request['coupon_discount'] : '';
           $order['inbuild_discount'] = $inbuild_discount;
           $order['payment_status'] = "Completed";
           $order['currency_sign'] = $curr->sign;
           $order['currency_value'] = $curr->value;
           $order['shipping_cost'] = $request['shipping_cost'];
           $order['packing_cost'] = $request['packing_cost'];
           $order['tax'] = $request['tax'];
           $order['dp'] = $request['dp'];
   
           $order['vendor_shipping_id'] = $request['vendor_shipping_id'];
           $order['vendor_packing_id'] = $request['vendor_packing_id'];
           $order['txnid'] = $txnid;
      
           $order->save();
      
          
        if($request['coupon_id'] != "")
        {
            $coupon = Coupon::findOrFail($request['coupon_id']);
            $coupon->used++;
            if($coupon->times != null)
            {
                $i = (int)$coupon->times;
                $i--;
                $coupon->times = (string)$i;
            }
            $coupon->update();

        }
        if($cart->items)
        foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {
                    $product = Product::findOrFail($prod['item']['id']);
                    $product->stock =  $prod['stock'];
                    $product->update();                
                }
            }
           if($cart->items)
           foreach($cart->items as $prod)
           {
               $x = (string)$prod['size_qty'];
               if(!empty($x))
               {
                   $product = Product::findOrFail($prod['item']['id']);
                   $x = (int)$x;
                   $x = $x - $prod['qty'];
                   $temp = $product->size_qty;
                   $temp[$prod['size_key']] = $x;
                   $temp1 = implode(',', $temp);
                   $product->size_qty =  $temp1;
                   $product->update();               
               }
           }
   
           if($cart->items)
           foreach($cart->items as $prod)
           {
               $x = (string)$prod['stock'];
               if($x != null)
               {
   
                   $product = Product::findOrFail($prod['item']['id']);
                   $product->stock =  $prod['stock'];
                   $product->update();  
                   if($product->stock <= 5)
                   {
                       $notification = new Notification;
                       $notification->product_id = $product->id;
                       $notification->save();                    
                   }              
               }
           }
   
   
           $notf = null;
   
           if($cart->items)
           foreach($cart->items as $prod)
           {
               if($prod['item']['user_id'] != 0)
               {
                   $vorder =  new VendorOrder;
                   $vorder->order_id = $order->id;
                   $vorder->user_id = $prod['item']['user_id'];
                   $notf[] = $prod['item']['user_id'];
                   $vorder->qty = $prod['qty'];
                   $vorder->price = $prod['price'];
                   $vorder->order_number = $order->order_number;             
                   $vorder->save();
               }
   
           }
   
           if(!empty($notf))
           {
               $users = array_unique($notf);
               foreach ($users as $user) {
                   $notification = new UserNotification;
                   $notification->user_id = $user;
                   $notification->order_number = $order->order_number;
                   $notification->save();    
               }
           }

           Session::put('temporder',$order);
           Session::put('tempcart',$cart);
           Session::forget('cart');   
   
            //Sending Email To Buyer

           $gs = Generalsetting::findOrFail(1);
           if($gs->is_smtp == 1)
           {
           $data = [
               'to' => $request['email'],
               'type' => "new_order",
               'cname' => $request['name'],
               'oamount' => "",
               'aname' => "",
               'aemail' => "",
               'wtitle' => "",
               'onumber' => $order->order_number,
           ];   

           $mailer = new GeniusMailer();
           $mailer->sendAutoOrderMail($data,$order->id);            

           }

           //Sending Email To Admin
           if($gs->is_smtp == 1)
           {
               $data = [
                   'to' => Pagesetting::find(1)->contact_email,
                   'subject' => "New Order Recieved!!",
                   'body' => "Hello Admin!<br>Your received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
               ];
   
               $mailer = new GeniusMailer();
               $mailer->sendCustomMail($data);            
           }



        if(Session::has('tempcart')){
        $oldCart = Session::get('tempcart');
        $tempcart = new Cart($oldCart);
        $order = Session::get('temporder');
        }
        else{
            $tempcart = '';
            return redirect()->back();
        }

         return view('front.success',compact('tempcart','order'));
     }

    
   /* public function payreturncardpayment(Request $request){
        var_dump($request->all());
    }*/
    
   public function payreturncardpayment(Request $request){
        $response = json_decode($request->transaction_json_response);
        $txnid = $response->transactionID;
        $request = Session::get('order_placed');

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $curr = Currency::where('is_default','=',1)->first();
       
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $paypal_email = $settings->paypal_business;
   
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();

        $inbuild_discount = 0;
        if($cart->items)
        foreach($cart->items as $item){
            $pr = Product::where(['id' => $item['item']['id']])->first();
            $inbuild_discount = $inbuild_discount + $pr->dsc_amt;
        }
   
   
        $item_amount = $request['total'] - (round($inbuild_discount * $curr->value));

        if($request['shipping']){
           $item_amount = $item_amount + $request['shipping'];
           $request['shipping'] = $request['shipping']/$curr->value; 
        }
        $item_amount = $item_amount/$curr->value;
   
        $eur = Currency::where(['name' => 'GBP'])->first();
        if($eur){
           $euro_amount = $item_amount * $eur->value;
        }
   
           $order['user_id'] = $request['user_id'];
           $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
           $order['totalQty'] = $request['totalQty'];
           $order['pay_amount'] = $item_amount;
           $order['method'] = "Debit/Credit Card";
           $order['customer_email'] = $request['email'];
           $order['customer_name'] = $request['name'];
           $order['customer_phone'] = $request['phone'];
           $order['order_number'] = $item_number;
           $order['shipping'] = $request['shipping'];
           $order['pickup_location'] = isset($request['pickup_location'])? $request['pickup_location'] : '';
           $order['customer_address'] = $request['address'];
           $order['customer_country'] = $request['customer_country'];
           $order['customer_city'] = $request['city'];
           $order['customer_zip'] = $request['zip'];
           $order['shipping_email'] = $request['shipping_email'];
           $order['shipping_name'] = $request['shipping_name'];
           $order['shipping_phone'] = $request['shipping_phone'];
           $order['shipping_address'] = $request['shipping_address'];
           $order['shipping_country'] = $request['shipping_country'];
           $order['shipping_city'] = $request['shipping_city'];
           $order['shipping_zip'] = $request['shipping_zip'];
           $order['order_note'] = isset($request['order_notes'])? $request['order_notes'] : ''; 
           $order['coupon_code'] = isset($request['coupon_code'])? $request['coupon_code'] : '';
           $order['coupon_discount'] = isset($request['coupon_discount'])? $request['coupon_discount'] : '';
           $order['inbuild_discount'] = $inbuild_discount;
           $order['payment_status'] = "Completed";
           $order['currency_sign'] = $curr->sign;
           $order['currency_value'] = $curr->value;
           $order['shipping_cost'] = $request['shipping_cost'];
           $order['packing_cost'] = $request['packing_cost'];
           $order['tax'] = $request['tax'];
           $order['dp'] = $request['dp'];
   
           $order['vendor_shipping_id'] = $request['vendor_shipping_id'];
           $order['vendor_packing_id'] = $request['vendor_packing_id'];
           $order['txnid'] = $txnid;
      
           $order->save();
      
          
        if($request['coupon_id'] != "")
        {
            $coupon = Coupon::findOrFail($request['coupon_id']);
            $coupon->used++;
            if($coupon->times != null)
            {
                $i = (int)$coupon->times;
                $i--;
                $coupon->times = (string)$i;
            }
            $coupon->update();

        }
        if($cart->items)
        foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {
                    $product = Product::findOrFail($prod['item']['id']);
                    $product->stock =  $prod['stock'];
                    $product->update();                
                }
            }
           if($cart->items)
           foreach($cart->items as $prod)
           {
               $x = (string)$prod['size_qty'];
               if(!empty($x))
               {
                   $product = Product::findOrFail($prod['item']['id']);
                   $x = (int)$x;
                   $x = $x - $prod['qty'];
                   $temp = $product->size_qty;
                   $temp[$prod['size_key']] = $x;
                   $temp1 = implode(',', $temp);
                   $product->size_qty =  $temp1;
                   $product->update();               
               }
           }
   
           if($cart->items)
           foreach($cart->items as $prod)
           {
               $x = (string)$prod['stock'];
               if($x != null)
               {
   
                   $product = Product::findOrFail($prod['item']['id']);
                   $product->stock =  $prod['stock'];
                   $product->update();  
                   if($product->stock <= 5)
                   {
                       $notification = new Notification;
                       $notification->product_id = $product->id;
                       $notification->save();                    
                   }              
               }
           }
   
   
           $notf = null;
   
           if($cart->items)
           foreach($cart->items as $prod)
           {
               if($prod['item']['user_id'] != 0)
               {
                   $vorder =  new VendorOrder;
                   $vorder->order_id = $order->id;
                   $vorder->user_id = $prod['item']['user_id'];
                   $notf[] = $prod['item']['user_id'];
                   $vorder->qty = $prod['qty'];
                   $vorder->price = $prod['price'];
                   $vorder->order_number = $order->order_number;             
                   $vorder->save();
               }
   
           }
   
           if(!empty($notf))
           {
               $users = array_unique($notf);
               foreach ($users as $user) {
                   $notification = new UserNotification;
                   $notification->user_id = $user;
                   $notification->order_number = $order->order_number;
                   $notification->save();    
               }
           }

           Session::put('temporder',$order);
           Session::put('tempcart',$cart);
           Session::forget('cart');   
   
            //Sending Email To Buyer

           $gs = Generalsetting::findOrFail(1);
           if($gs->is_smtp == 1)
           {
           $data = [
               'to' => $request['email'],
               'type' => "new_order",
               'cname' => $request['name'],
               'oamount' => "",
               'aname' => "",
               'aemail' => "",
               'wtitle' => "",
               'onumber' => $order->order_number,
           ];   

           $mailer = new GeniusMailer();
           $mailer->sendAutoOrderMail($data,$order->id);            

           }

           //Sending Email To Admin
           if($gs->is_smtp == 1)
           {
               $data = [
                   'to' => Pagesetting::find(1)->contact_email,
                   'subject' => "New Order Recieved!!",
                   'body' => "Hello Admin!<br>Your received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
               ];
   
               $mailer = new GeniusMailer();
               $mailer->sendCustomMail($data);            
           }



        if(Session::has('tempcart')){
        $oldCart = Session::get('tempcart');
        $tempcart = new Cart($oldCart);
        $order = Session::get('temporder');
        }
        else{
            $tempcart = '';
            return redirect()->back();
        }

         return view('front.success',compact('tempcart','order'));
     }

public function notify(Request $request){

    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    //return $myPost;


    // Read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }

    /*
     * Post IPN data back to PayPal to validate the IPN data is genuine
     * Without this step anyone can fake IPN data
     */
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
    $ch = curl_init($paypalURL);
    if ($ch == FALSE) {
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// Set TCP timeout to 30 seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
    $res = curl_exec($ch);

    /*
     * Inspect IPN validation result and act accordingly
     * Split response headers and payload, a better way for strcmp
     */
    $tokens = explode("\r\n\r\n", trim($res));
    $res = trim(end($tokens));
    if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

        $order = Order::where('user_id',$_POST['custom'])
            ->where('order_number',$_POST['item_number'])->first();
        $data['txnid'] = $_POST['txn_id'];
        $data['payment_status'] = $_POST['payment_status'];
        if($order->dp == 1)
        {
            $data['status'] = 'completed';
        }
        $order->update($data);
        $notification = new Notification;
        $notification->order_id = $order->id;
        $notification->save();
        Session::forget('cart');
    }else{
        $payment = Order::where('user_id',$_POST['custom'])
            ->where('order_number',$_POST['item_number'])->first();
        VendorOrder::where('order','=',$payment->id)->delete();
        $payment->delete();

        Session::forget('cart');

    }

}


    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }












    public function paytabs(Request $request){
        if (!Session::has('cart')) {
           return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }
           if($request->pass_check) {
               $users = User::where('email','=',$request->personal_email)->get();
               if(count($users) == 0) {
                   if ($request->personal_pass == $request->personal_confirm){
                       $user = new User;
                       $user->name = $request->personal_name; 
                       $user->email = $request->personal_email;   
                       $user->password = bcrypt($request->personal_pass);
                       $token = md5(time().$request->personal_name.$request->personal_email);
                       $user->verification_link = $token;
                       $user->affilate_code = md5($request->name.$request->email);
                       $user->email_verified = 'Yes';
                       $user->save();
                       Auth::guard('web')->login($user);                     
                   }else{
                       return redirect()->back()->with('unsuccess',"Confirm Password Doesn't Match.");     
                   }
               }
               else {
                   return redirect()->back()->with('unsuccess',"This Email Already Exist.");  
               }
           }
   
   
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
               // if (Session::has('currency')) 
               // {
               //   $curr = Currency::find(Session::get('currency'));
               // }
               // else
               // {
           $curr = Currency::where('is_default','=',1)->first();
               // }

        $darham = Currency::where('name','=',"AED")->first();
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
   
        $item_name = $settings->title." Order";
        $item_number = str_random(4).time();
   
        $inbuild_discount = 0;
        foreach($cart->items as $item){
            $pr = Product::where(['id' => $item['item']['id']])->first();
            $inbuild_discount = $inbuild_discount + $pr->dsc_amt;
        }
   
        $item_amount = $request->total - (round($inbuild_discount * $curr->value));
        $item_amount = $item_amount/$curr->value;

            $order['user_id'] = $request->user_id;
            $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
            $order['totalQty'] = $request->totalQty;
            $order['pay_amount'] = round($item_amount, 2);
            $order['method'] = "Paypal";
            $order['customer_email'] = $request->email;
            $order['customer_name'] = $request->f_name." ".$request->l_name;
            $order['customer_phone'] = $request->phone;
            $order['order_number'] = $item_number;
            $order['shipping'] = $request->shipping;
            $order['pickup_location'] = $request->pickup_location;
            $order['customer_address'] = $request->address;
            $order['customer_country'] = $request->customer_country;
            $order['customer_city'] = $request->city;
            $order['customer_zip'] = $request->zip;
            $order['shipping_email'] = $request->shipping_email;
            $order['shipping_name'] = $request->shipping_name;
            $order['shipping_phone'] = $request->shipping_phone;
            $order['shipping_address'] = $request->shipping_address;
            $order['shipping_country'] = $request->shipping_country;
            $order['shipping_city'] = $request->shipping_city;
            $order['shipping_zip'] = $request->shipping_zip;
            $order['order_note'] = $request->order_notes;
            $order['coupon_code'] = $request->coupon_code;
            $order['coupon_discount'] = $request->coupon_discount/$curr->value;
            $order['inbuild_discount'] = $inbuild_discount;
            $order['payment_status'] = "Pending";
            $order['currency_sign'] = $darham->sign;
            $order['currency_value'] = $darham->value;
            $order['shipping_cost'] = $request->shipping_cost;
            $order['packing_cost'] = $request->packing_cost;
            $order['tax'] = $request->tax;
            $order['dp'] = $request->dp;
   
           $order['vendor_shipping_id'] = $request->vendor_shipping_id;
           $order['vendor_packing_id'] = $request->vendor_packing_id;
   
            $order->save();
            if($request->coupon_id != "")
            {
                $coupon = Coupon::findOrFail($request->coupon_id);
                $coupon->used++;
                if($coupon->times != null)
                {
                    $i = (int)$coupon->times;
                    $i--;
                    $coupon->times = (string)$i;
                }
                $coupon->update();

            }
            foreach($cart->items as $prod)
            {
                $x = (string)$prod['stock'];
                if($x != null)
                {
                        $product = Product::findOrFail($prod['item']['id']);
                        $product->stock =  $prod['stock'];
                        $product->update();                
                    }
                }
           foreach($cart->items as $prod)
           {
               $x = (string)$prod['size_qty'];
               if(!empty($x))
               {
                   $product = Product::findOrFail($prod['item']['id']);
                   $x = (int)$x;
                   $x = $x - $prod['qty'];
                   $temp = $product->size_qty;
                   $temp[$prod['size_key']] = $x;
                   $temp1 = implode(',', $temp);
                   $product->size_qty =  $temp1;
                   $product->update();               
               }
           }
   
      
           foreach($cart->items as $prod)
           {
               $x = (string)$prod['stock'];
               if($x != null)
               {
                   $product = Product::findOrFail($prod['item']['id']);
                   $product->stock =  $prod['stock'];
                   $product->update();  
                   if($product->stock <= 5)
                   {
                       $notification = new Notification;
                       $notification->product_id = $product->id;
                       $notification->save();                    
                   }              
               }
           }
   
   
           $notf = null;
   
           foreach($cart->items as $prod)
           {
               if($prod['item']['user_id'] != 0)
               {
                   $vorder =  new VendorOrder;
                   $vorder->order_id = $order->id;
                   $vorder->user_id = $prod['item']['user_id'];
                   $notf[] = $prod['item']['user_id'];
                   $vorder->qty = $prod['qty'];
                   $vorder->price = $prod['price'];
                   $vorder->order_number = $order->order_number;             
                   $vorder->save();
               }
   
           }
   
           if(!empty($notf))
           {
               $users = array_unique($notf);
               foreach ($users as $user) {
                   $notification = new UserNotification;
                   $notification->user_id = $user;
                   $notification->order_number = $order->order_number;
                   $notification->save();    
               }
           }
                       Session::put('temporder',$order);
                       Session::put('tempcart',$cart);
                       Session::forget('cart');
   
   
                               //Sending Email To Buyer
           $gs = Generalsetting::findOrFail(1);
           if($gs->is_smtp == 1)
           {
           $data = [
               'to' => $request->email,
               'type' => "new_order",
               'cname' => $request->name,
               'oamount' => "",
               'aname' => "",
               'aemail' => "",
               'wtitle' => "",
               'onumber' => $order->order_number,
           ];
   
        
           $mailer = new GeniusMailer();
           $mailer->sendAutoOrderMail($data,$order->id);            
           }
   
           //Sending Email To Admin
           if($gs->is_smtp == 1)
           {
               $data = [
                   'to' => Pagesetting::find(1)->contact_email,
                   'subject' => "New Order Recieved!!",
                   'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
               ];
   
               $mailer = new GeniusMailer();
               $mailer->sendCustomMail($data);            
           } 
           
           Session::put('temporder',$order);
           Session::put('tempcart',$cart);


           $user = Auth::user();
           return view('front.payment' , compact('order' , 'user' , 'darham'));   
    }
   
    public function paytabsResponse(Request $request){
        $order = Order::where(['id' => $request->order_id])->first();
        $order->pay_id = $request->transaction_id;
        $order->payment_status = "Completed";
        $order->save();

        if(Session::has('tempcart')){
            $oldCart = Session::get('tempcart');
            $tempcart = new Cart($oldCart);
            $order = Session::get('temporder');
            }
            else{
                $tempcart = '';
                return redirect()->back();
            }

            Session::forget('cart'); 
            Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');
 
        return view('front.success',compact('tempcart','order'));    
    }

    public function paytabsCancel(Request $request){        
        Order::where(['id' => $request->order_id])->delete();
        VendorOrder::where(['order_id' => $request->order_id])->delete();

        return redirect(route('front.checkout'));
    }

    public function recordSale($total , $type , $discount){
        $date = date('m/d/Y');
        $sale = Sale::where(['date' => $date , 'user_id' => Auth::user()->id , 'type' => $type])->first();

        if(!is_null($sale)){

            $sale->total = $sale->total + (float)$total;
            $sale->discount = $discount;
            $sale->type = $type;
            $sale->date = $date;
            $sale->save();

        }else{
            Sale::create([
                'total' => (float) $total,
                'discount' => (float)$discount,
                'date' => $date,
                'type' => $type,
                'user_id' => $Auth::user()->id 
            ]);
        }
    }

}
