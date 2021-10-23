<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Models\Sale;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function getSales($year , $month){
        if($month < 10){
            $month = sprintf("%02d", $month);
        }
        $sales = Sale::select('id','total' , 'discount' ,'date' , 'created_at')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', $month)
        ->get();

        $gbp = Currency::where(['name' => 'GBP'])->first();
        if($gbp){
            foreach($sales as $sale){
                $sale->total = round(($sale->total * $gbp->value) , 2); 
            }
        }else{
            foreach($sales as $sale){
                $sale->total = round(($sale->total) , 2); 
            }
        }
        
        return DataTables::of($sales)
        ->addColumn('action', function ($id) {
            return '<a href="#" class="text-primary"><i class="fa fa-edit"></i></a>'; 
        })
        ->make(true);
    }

    public function index(){
        return view('admin.sales.sales');
    }

    public function create(){}

    public function store(){}
}
