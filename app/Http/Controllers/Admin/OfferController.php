<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class OfferController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Offer::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('type', function(Offer $data) {
                                $type = "";
                                if($data->type == 0){
                                   $type = "Buy One/Get One";     
                                }
                                if($data->type == 1){
                                    $type = "Specail Discount";     
                                }
                                if($data->type == 2){
                                    $type = "Special Qunatity";     
                                 }
                                return $type;
                            })
                            ->addColumn('featured', function(Offer $data) {
                                $class = $data->is_feature == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->is_feature == 1 ? 'selected' : '';
                                $ns = $data->is_feature == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-offer-feature',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Featured</option><<option data-val="0" value="'. route('admin-offer-feature',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Non Featured</option>/select></div>';
                            }) 
                            ->addColumn('status', function(Offer $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-offer-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-offer-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            }) 
                            ->addColumn('action', function(Offer $data) {
                                return '<div class="action-list"><a href="' . route('admin-offer-edit',$data->id) . '"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-offer-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['status','featured','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.offers.index');
    }

    //*** GET Request
    public function create()
    {
        $products = Product::where(['status' => 1])->get();
        return view('admin.offers.create',compact('products'));
    }

    public function create_type_1()
    {
        $products = Product::where(['status' => 1])->get();
        return view('admin.offers.create_type_1',compact('products'));
    }

    public function create_type_2()
    {
        $products = Product::where(['status' => 1])->get();
        return view('admin.offers.create_type_2',compact('products'));
    }

    public function create_type_3()
    {
        $products = Product::where(['status' => 1])->get();
        return view('admin.offers.create_type_3',compact('products'));
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = ['image' => 'required'];
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }   
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Offer();
        $input = $request->all();
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');

        if ($file = $request->file('image')) 
        {      
           $name = time().$file->getClientOriginalName();
           $file->move(public_path().'/assets/images/offers',$name);           
           $input['image'] = $name;
       } 

        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.'.'<a href="'.route("admin-offer-index").'">View Offer Lists</a>';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Offer::findOrFail($id);
        $products = Product::where(['status' => 1])->get();
        return view('admin.offers.edit',compact('data','products'));
    }



    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section

        // $rules = ['na' => 'required'];
        // $validator = Validator::make(Input::all(), $rules);
        
        // if ($validator->fails()) {
        //   return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        // }        
        //--- Validation Section Ends

        //--- Logic Section
        $data = Offer::findOrFail($id);
        $input = $request->all();
        $input['start_date'] = Carbon::parse($input['start_date'])->format('Y-m-d');
        $input['end_date'] = Carbon::parse($input['end_date'])->format('Y-m-d');

        if ($file = $request->file('image')) 
        {      
           $name = time().$file->getClientOriginalName();
           $file->move(public_path().'/assets/images/offers',$name);           
           $input['image'] = $name;
       } 

        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.'.'<a href="'.route("admin-offer-index").'">View Offer Lists</a>';
        return response()->json($msg);    
        //--- Redirect Section Ends           
    }
      //*** GET Request Status
      public function status($id1,$id2)
        {
            $data = Offer::findOrFail($id1);
            $data->status = $id2;
            $data->update();
        }

        public function feature($id1,$id2)
        {
            $data = Offer::findOrFail($id1);
            $data->is_feature = $id2;
            $data->update();
        }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Offer::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }

    public function type(){
        return view('admin.offers.type');       
    }
}
