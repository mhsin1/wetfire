<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Input;
use Datatables;
use Validator;

class CityController extends Controller
{
   //*** GET Request
   public function index()
   {
       return view('admin.city.index');
   }

    public function datatables(){
        $cities = City::orderBy('id','desc')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($cities)
                           ->addColumn('status', function(City $city) {
                               $class = $city->status == 1 ? 'drop-success' : 'drop-danger';
                               $s = $city->status == 1 ? 'selected' : '';
                               $ns = $city->status == 0 ? 'selected' : '';
                               return '<div class="action-list"><select class="city-select"><option data-val="1" value="'. route('admin-city-status',['id1' => $city->id, 'id2' => 1]).'" '.$s.'>Activated</option><option data-val="0" value="'. route('admin-city-status',['id1' => $city->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                           })
                           ->editColumn('state_id', function(City $city) {
                                return $city->state->state_name;
                            })
                           ->addColumn('action', function(City $city) {
                               return '<div class="action-list"><a data-href="' . route('admin-city-edit',$city->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-city-delete',$city->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                           })
                           ->rawColumns(['status','action','state_id'])
                           ->toJson(); //--- Returning Json Data To Client Side

    }

       //*** GET Request
       public function create()
       {
           $states = State::where(['status' => 1])->get(); 
           return view('admin.city.create' , compact('states'));
       }

           //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'city_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'city_code' => 'required',
            'state_id' => 'required'
                 ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new City();
        $input = $request->all();
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = City::findOrFail($id);
        $states = State::where(['status' => 1])->get();  
        return view('admin.city.edit',compact('data' , 'states'));
    }
 
    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'city_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'city_code' => 'required',
            'state_id' => 'required'
                 ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = City::findOrFail($id);
        $input = $request->all();
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** GET Request Status
    public function status($id1,$id2)
    {
        $data = City::findOrFail($id1);
        $data->status = $id2;
        $data->update();

    }
 
          
              //*** GET Request Delete
    public function destroy($id)
    {
        $data = City::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
