<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\Input;
use Datatables;
use Validator;

class CountryController extends Controller
{
   //*** GET Request
   public function index()
   {
       return view('admin.country.index');
   }

    public function datatables(){
        $countries = Country::orderBy('id','desc')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($countries)
                           ->addColumn('status', function(Country $country) {
                               $class = $country->status == 1 ? 'drop-success' : 'drop-danger';
                               $s = $country->status == 1 ? 'selected' : '';
                               $ns = $country->status == 0 ? 'selected' : '';
                               return '<div class="action-list"><select class="country-select"><option data-val="1" value="'. route('admin-country-status',['id1' => $country->id, 'id2' => 1]).'" '.$s.'>Activated</option><option data-val="0" value="'. route('admin-country-status',['id1' => $country->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                           })
                           ->addColumn('action', function(Country $country) {
                               return '<div class="action-list"><a data-href="' . route('admin-country-edit',$country->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>Edit</a><a href="javascript:;" data-href="' . route('admin-country-delete',$country->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
                           })
                           ->addColumn('stat', function(Country $country) {
                                if($country->status == 1){
                                    return 0;
                                }else{
                                    return 1;
                                }
                            })
                           ->rawColumns(['status','action','stat'])
                           ->toJson(); //--- Returning Json Data To Client Side

    }

       //*** GET Request
       public function create()
       {
           return view('admin.country.create');
       }

           //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'photo' => 'required|mimes:jpeg,jpg,png,svg',
            'country_name' => 'required|regex:/^[\pL\s\-]+$/u|unique:countries,country_name',
            'country_code' => 'required|alpha|unique:countries,country_code|min:2|max:2'
                 ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
       
        //--- Logic Section
        $data = new Country();
        $input = $request->all();

        if ($file = $request->file('photo'))
        {
           $name = time().$file->getClientOriginalName();
           $file->move('assets/images/flags',$name);
           $input['image'] = $name;
       }

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
            $data = Country::findOrFail($id);
            return view('admin.country.edit',compact('data'));
        }
 
            //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'country_name' => 'required|regex:/^[\pL\s\-]+$/u|unique:countries,country_name,'.$id,
            'country_code' => 'required|alpha|unique:countries,country_code,'.$id
                 ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Country::findOrFail($id);
        $input = $request->all();

        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/flags',$name);
            if($data->image != null)
            {
                if (file_exists('assets/images/flags/'.$data->image)) {
                    unlink('assets/images/flags/'.$data->image);
                }
            }
            $input['image'] = $name;
        }

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
        $data = Country::findOrFail($id1);
        $data->status = $id2;
        $data->update();

    }
 
          
              //*** GET Request Delete
    public function destroy($id)
    {
        $data = Country::findOrFail($id);
        $data->delete();
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }
}
