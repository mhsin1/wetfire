<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Auth;
use Validator;
use App\Models\Order;
use App\Models\ReturnOrder;
use App\Models\Reason;
use App\Models\Product;
use App\Models\PaymentGateway;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->get();
        return view('user.order.index',compact('user','orders'));
    }

    public function ordertrack()
    {
        $user = Auth::guard('web')->user();
        return view('user.order-track',compact('user'));
    }

    public function trackload($id)
    {
        $order = Order::where('order_number','=',$id)->first();
        $datas = array('Pending','Processing','On Delivery','Completed');
        return view('load.track-load',compact('order','datas'));

    }


    public function order($id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::findOrfail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('user.order.details',compact('user','order','cart'));
    }

    public function orderdownload($slug,$id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::where('order_number','=',$slug)->first();
        $prod = Product::findOrFail($id);
        if(!isset($order) || $prod->type == 'Physical' || $order->user_id != $user->id)
        {
            return redirect()->back();
        }
        return response()->download(public_path('assets/files/'.$prod->file));
    }

    public function orderprint($id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::findOrfail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('user.order.print',compact('user','order','cart'));
    }

    public function trans()
    {
        $id = $_GET['id'];
        $trans = $_GET['tin'];
        $order = Order::findOrFail($id);
        $order->txnid = $trans;
        $order->update();
        $data = $order->txnid;
        return response()->json($data);            
    }  

    public function orderReturn($id){
        $user = Auth::guard('web')->user();
        $order = Order::where(['id' => $id])->first();
        $reasons = Reason::all();
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('user.order.return' , compact('order','cart','user','reasons'));
    }

    public function order_return_submit(Request $request){
        $validator = Validator::make($request->all(), [ 
            'reason' => 'required',
            'details' => 'required',
            'order_id' => 'required',
        ]);
     
        if ($validator->fails()) { 
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new ReturnOrder();
        $input = $request->all();

        $images = [];
        if($request->hasFile('images'))
        {
            foreach($request->file('images') as $image)
            {
                $name = time().$image->getClientOriginalName();
                $image->move('public/assets/images/returns',$name);
                array_push($images, $name);          
            }
        }
        $input['images'] = json_encode($images);
        $input['user_id'] = Auth::user()->id;
        $data->fill($input)->save();

        return redirect(URL::previous() . "#success-trigger")->with('success','Your Return Request is Submitted');
    }
}
