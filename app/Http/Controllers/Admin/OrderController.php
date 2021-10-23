<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\Currency;
use App\Models\Admin;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\Sale;
use Carbon\Carbon;
use App\Models\VendorOrder;
use Datatables;
use PDF;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables($status)
    {
        if($status != 'none'){
            if(Auth::user()->role->name == "Driver"){
                $datas = Order::where('driver_id',Auth::user()->id)->where('status','=',$status)->get();  
            }else{
                $datas = Order::where('status','=',$status)->get();
            }    
        }else{
            if(Auth::user()->role->name == "Driver"){
                $datas = Order::where('driver_id',Auth::user()->id)->orderBy('id','desc')->get();  
            }else{
                $datas = Order::orderBy('id','desc')->get();  
            }
        }

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })
                            ->addColumn('action', function(Order $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                if(Auth::user()->role->name == "Driver"){
                                    $assign = '';
                                    $send = '';    
                                }else{
                                    $assign = '<a href="javascript:;" data-href="'. route('admin-order-assign',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-car"></i> Assign Driver</a>';
                                    $send = '<a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a>';    
                                }
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>'.$send.$orders.$assign.'</div></div>';
                            }) 
                            ->addColumn('date', function(Order $data) {
                                return Carbon::parse($data->created_at)->format('m/d/Y');
                            }) 
                            ->rawColumns(['id','action','date'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.order.index');
    }

    public function edit($id)
    {
        $data = Order::find($id);
        if($data->status != "completed"){
            return view('admin.order.delivery',compact('data'));
        }else{
            return response()->json("Order Completed! Change Delivery status is not allowed.");    
        }
    }

    public function assign($id){
        $data = Order::find($id);
        $admins = Admin::all();
        $users = [];
        foreach($admins as $admin){
            if($admin->role->name == "Driver"){
                array_push($users , $admin);
            }
        }
        return view('admin.order.assign',compact('data','users'));
    }

    public function assign_update(Request $request){
        $order = Order::find($request->order_id);
        $order->driver_id = $request->driver_id;
        $order->save(); 

        $msg = 'Order Assigned Successfully.';
        return response()->json($msg);    
    }

    //*** POST Request
    public function update(Request $request, $id)
    {

        //--- Logic Section
        $data = Order::findOrFail($id);

        $input = $request->all();
        if ($data->status == "completed"){

        // Then Save Without Changing it.
            $input['status'] = "completed";
            $data->update($input);
            //--- Logic Section Ends
    

        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends     
    
            }else{
            if ($input['status'] == "completed"){
    
                foreach($data->vendororders as $vorder)
                {
                    $uprice = User::findOrFail($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();
                }
                $this->recordSale($data->pay_amount , 'product' , $data->discount);        
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Confirmed!';
                   $msg = "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                }
            }
            if ($input['status'] == "declined"){
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Declined!';
                   $msg = "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                   $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }
    
            }

            $data->update($input);

            if($request->track_text)
            {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id','=',$id)->where('title','=',$title)->first();
                    if($ck){
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();  
                    }
                    else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();            
                    }
    
    
            } 


        $order = VendorOrder::where('order_id','=',$id)->update(['status' => $input['status']]);

         //--- Redirect Section          
         $msg = 'Status Updated Successfully.';
         return response()->json($msg);    
         //--- Redirect Section Ends    
    
            }

        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  

    }

    public function pending()
    {
        return view('admin.order.pending');
    }
    public function processing()
    {
        return view('admin.order.processing');
    }
    public function completed()
    {
        return view('admin.order.completed');
    }
    public function declined()
    {
        return view('admin.order.declined');
    }
    public function show($id)
    {
        if(!Order::where('id',$id)->exists())
        {
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.details',compact('order','cart'));
    }
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.invoice',compact('order','cart'));
    }
    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = 0;
            $datas = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            if($mail) {
                $data = 1;
            }
        }
        else
        {
            $data = 0;
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.print',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();       
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }

    public function recordSale($total , $type , $discount){
        $date = date('m/d/Y');
        $sale = Sale::where(['date' => $date ,'type' => $type])->first();

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
                'type' => $type
            ]);
        }
    }
}