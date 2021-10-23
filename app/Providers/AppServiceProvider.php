<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Category;
use App\Models\Currency;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App;
use Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $admin_lang = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($admin_lang->name);
        view()->composer('*',function($settings){

            if (Session::has('currency')) {
                $curr = Currency::find(Session::get('currency'));
            }
            else {
                $curr = Currency::where('is_default','=',1)->first();
            }

            
            $settings->with('gs', DB::table('generalsettings')->find(1));
            $settings->with('ps', DB::table('pagesettings')->find(1));
            $settings->with('seo', DB::table('seotools')->find(1));
            $settings->with('pages', DB::table('pages')->get());
            $settings->with('curr', $curr);
            if(Auth::check()){
                $settings->with('wishs', DB::table('wishlists')->where(['user_id' => Auth::user()->id])->get());
            }else{
                $settings->with('wishs', DB::table('wishlists')->where(['user_id' => 0])->get());
            }
            $order = "asc";
            $settings->with('categories', Category::where('status','=',1)->when($order, function ($query,$order) {
                return $query->orderBy('sequence', $order);
            })->get());   
            if (Session::has('language')) 
            {
                $data = DB::table('languages')->find(Session::get('language'));
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }
            else
            {
                $data = DB::table('languages')->where('is_default','=',1)->first();
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
            }  

            if (!Session::has('popup')) 
            {
                $settings->with('visited', 1);
            }
            Session::put('popup' , 1);
             
        });
    }
}
