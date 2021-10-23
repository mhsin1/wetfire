<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Http\Controllers\Controller;
use App\Models\ReturnOrder;
use App\Classes\GeniusMailer;
use App\Models\GeneralSetting;
use App\Models\Order;

class ReturnOrderController extends Controller
{
	public function __construct()
	    {
	        $this->middleware('auth:admin');
	    }

	    //*** JSON Request
	    public function datatables()
	    {
    	        $datas = ReturnOrder::orderBy('id')->get();
                //--- Integrating This Collection Into Datatables
                return Datatables::of($datas)
                ->editColumn('created_at', function(ReturnOrder $data) {
                    $date = $data->created_at->diffForHumans();
                    return  $date;
                })
                ->addColumn('name', function(ReturnOrder $data) {
                    $name = $data->user->name;
                    return  $name;
                })
                ->addColumn('action', function(ReturnOrder $data) {
                    return '<div class="action-list"><a href="' . route('admin-return_order-show',$data->id) . '"> <i class="fas fa-eye"></i> Details</a><a href="javascript:;" data-href="' . route('admin-return_order-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                }) 
                ->rawColumns(['action'])
                ->toJson(); //--- Returning Json Data To Client Side
	    }
	    //*** GET Request
	    public function index()
	    {
	        return view('admin.returns.index');
	    }

	    //*** GET Request
	    public function show($id)
	    {
            $data = ReturnOrder::findOrFail($id);
            $order = Order::findOrFail($data->order_id);
            $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
	        return view('admin.returns.show',compact('data','order','cart'));
	    }


	    //*** GET Request Delete
		public function delete($id)
		{
		    $data = ReturnOrder::findOrFail($id);
		    $data->delete();
		    //--- Redirect Section     
		    $msg = 'Data Deleted Successfully.';
		    return response()->json($msg);      
		    //--- Redirect Section Ends    
        }
        
        public function reason_response($id){
            $data = Order::findOrFail($id);
            $data->status = "declined";
            $data->save();
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

            return redirect(route('admin-return_order-index'))->with('message','Order is Declined Succesfully');
        }
}
