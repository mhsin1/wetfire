<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Reason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class ReasonController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Reason::orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('action', function(Reason $data) {
                                return '<div class="action-list"><a href="' . route('admin-reason-edit',$data->id) . '"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-reason-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                            }) 
                            ->rawColumns(['action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.reason.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.reason.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = ['reason' => 'required|unique:reasons'];
        $customs = ['reason.required' => 'The Reason is required.'];
        $validator = Validator::make(Input::all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }   
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Reason();
        $input = $request->all();
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.'.'<a href="'.route("admin-reason-index").'">View Reasons Lists</a>';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Reason::findOrFail($id);
        return view('admin.reason.edit',compact('data'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section

        $rules = ['code' => 'required|unique:reasons,reason,'.$id];
        $customs = ['reason.required' => 'Thi reason is required.'];
        $validator = Validator::make(Input::all(), $rules, $customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }        
        //--- Validation Section Ends

        //--- Logic Section
        $data = Reason::findOrFail($id);
        $input = $request->all();
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.'.'<a href="'.route("admin-reason-index").'">View Reason Lists</a>';
        return response()->json($msg);    
        //--- Redirect Section Ends           
    }
      //*** GET Request Status
      public function status($id1,$id2)
        {
            $data = Reason::findOrFail($id1);
            $data->status = $id2;
            $data->update();
        }


    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Reason::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }
}
