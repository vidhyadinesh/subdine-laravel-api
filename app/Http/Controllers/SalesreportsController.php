<?php

namespace App\Http\Controllers;
use App\Purchase;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesreportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function lasttwodays($cnt)
    {   $lasttwodays=$testarr=array();
    	
    	
        $purchase = Purchase::whereDate('created_at', '>', Carbon::today()->subDays( $cnt+1 ))
->whereDate('created_at', '!=', Carbon::today())->get(['data','total','created_at']);
        foreach($purchase as $purch){ 
        	$prchdata=json_decode($purch->data);
            $pur_date=$purch->created_at->todatestring();
              
        	foreach($prchdata as $p_data){      		
        		              
        		$prd = Product::where('id',$p_data->id)->get(['id','name','quantity','price']);       		
        		
        		if($cnt==2){
	        		$lasttwodays[$pur_date][$p_data->id]=array('name'=>'','sold'=>0);
	        		if(!is_array($lasttwodays[$pur_date][$p_data->id])){
	        			$lasttwodays[$pur_date][$p_data->id]=array('name'=>'','sold'=>0);
	        			$sold=0;
	        		}else{
	        			$sold=$lasttwodays[$pur_date][$p_data->id]['sold']+$p_data->quantity;
	        		}
	        		$lasttwodays[$pur_date][$p_data->id]=array('name'=>$prd[0]->name,'sold'=>$sold);
        		}else{
        			
	        		if (array_key_exists($p_data->id,$testarr)){
	        			$sold=$testarr[$p_data->id]['sold']+$p_data->quantity;
	        			
	        		}else{
	        			$testarr[$p_data->id]=array('name'=>'','sold'=>0);
	        			$sold=0;
	        		}
	        		$testarr[$p_data->id]=array('name'=>$prd[0]->name,'sold'=>$sold);
        		}              

        	}
        }
        $mss='list the aggregate of dishes and sold count in the last 2 days.';
        if($cnt==10){
        	//print_r($lasttwodays);
        	//print_r($this->sortArray($lasttwodays,'sold'));
        	$flag=0;
        	foreach($testarr as $last){ 
        		if($flag==0){
                    $lasttwodays['leastsold']=array('name'=>$last['name'],'sold'=>$last['sold']);
                    $flag=1;
        		}else{
        			$lasttwodays['mostsold']=array('name'=>$last['name'],'sold'=>$last['sold']);
        	    }
        	}
        	
        	$mss='list the most sold and least sold 5 items in the last 10 days';
        }
        return response()->json([
            'status' => "success",
            'data'=>$lasttwodays,
            'message' =>$mss
            ], 200);
    }

    function sortArray( $data, $field ) {
	    $field = (array) $field;
	    uasort( $data, function($a, $b) use($field) {
	        $retval = 0;
	        foreach( $field as $fieldname ) {
	            if( $retval == 0 ) $retval = strnatcmp( $a[$fieldname], $b[$fieldname] );
	        }
	        return $retval;
	    } );
	    return $data;
	}

}
