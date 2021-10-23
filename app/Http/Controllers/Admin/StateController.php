<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Input;
use Datatables;
use Validator;

class StateController extends Controller
{
     //*** GET Request
     public function index()
     {
         return view('admin.state.index');
     }
  
      public function datatables(){
          $states = State::orderBy('id','desc')->get();
          //--- Integrating This Collection Into Datatables
          return Datatables::of($states)
                             ->addColumn('status', function(State $state) {
                                 $class = $state->status == 1 ? 'drop-success' : 'drop-danger';
                                 $s = $state->status == 1 ? 'selected' : '';
                                 $ns = $state->status == 0 ? 'selected' : '';
                                 return '<div class="action-list"><select class="state-select"><option data-val="1" value="'. route('admin-state-status',['id1' => $state->id, 'id2' => 1]).'" '.$s.'>Activated</option><option data-val="0" value="'. route('admin-state-status',['id1' => $state->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                             })
                             ->editColumn('country_id', function(State $state) {
                                return $state->country->country_name;
                            })
                             ->addColumn('action', function(State $state) {
                                 return '<div class="action-list"><a data-href="' . route('admin-state-edit',$state->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-state-delete',$state->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                             })
                             ->rawColumns(['status','action','country_id'])
                             ->toJson(); //--- Returning Json Data To Client Side
  
      }
  
         //*** GET Request
         public function create()
         {
             $countries = Country::where(['status' => 1])->get();
             return view('admin.state.create' , compact('countries'));
         }
  
             //*** POST Request
      public function store(Request $request)
      {
          //--- Validation Section
          $rules = [
              'state_name' => 'required|regex:/^[\pL\s\-]+$/u',
              'state_code' => 'required',
              'country_id' => 'required'
                   ];
          $validator = Validator::make(Input::all(), $rules);
  
          if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
          }
          //--- Validation Section Ends
  
          //--- Logic Section
          $data = new State();
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
              $data = State::findOrFail($id);
              $countries = Country::where(['status' => 1])->get(); 
              return view('admin.state.edit',compact('data' , 'countries'));
          }
   
              //*** POST Request
      public function update(Request $request, $id)
      {
          //--- Validation Section
          $rules = [
              'state_name' => 'required|regex:/^[\pL\s\-]+$/u',
              'state_code' => 'required',
              'country_id' => 'required'
                   ];
          $validator = Validator::make(Input::all(), $rules);
  
          if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
          }
          //--- Validation Section Ends
  
          //--- Logic Section
          $data = State::findOrFail($id);
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
          $data = State::findOrFail($id1);
          $data->status = $id2;
          $data->update();
  
      }
   
            
                //*** GET Request Delete
      public function destroy($id)
      {
          $data = State::findOrFail($id);
          $data->delete();
          //--- Redirect Section
          $msg = 'Data Deleted Successfully.';
          return response()->json($msg);
          //--- Redirect Section Ends
      }
  }
  