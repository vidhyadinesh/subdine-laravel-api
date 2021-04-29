<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use App\User;
use App\Product;
use App\Notifications\StockNotification;

class StockController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
  
    public function index()
    {
        return view('welcome');
    }
    
    public function sendNotification() { $txt='';
        $prd = Product::where('quantity','<',10)->get(['id','name','quantity','price']);
        $data = User::first();
        foreach($prd as $pd){
        	if($txt !=''){
        		$txt.=', '.$pd->name;
        	}else{
        		$txt.=$pd->name;
            }
        }
        
        $stockData = [
            'name' => '#007 Notification',
            'body' => 'Stock less than 10  : '.$txt,
            'thanks' => 'Thank you',
            'text' => '',
            'offer' => url('/'),
            'pdid' =>'007' 
        ];
  
        Notification::send($data, new StockNotification($stockData));
   
        dd('Stock notification has been sent!');
    }

}
