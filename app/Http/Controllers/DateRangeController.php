<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;






use Illuminate\Support\Facades\Http;





use App\Models\User;
use App\Http\Controllers\Controller;

use App\Models\getInvoice;
use App\Models\getClients;

use App\Models\getdetails_facture;
use App\Models\Personal;


use DataTables;









class DateRangeController extends Controller
{
   
    function index()
    {
     

     return view('dataRange/data_range');
    }

    
    
    function fetch_data(Request $request)
    {
     if($request->ajax())
     {
      if($request->from_date != '' && $request->to_date != '')
      {
       $data = DB::table('ENTETE_FACTURE')
         ->whereBetween('DO_Date', array($request->from_date, $request->to_date))
         ->get();
         
      }
      else
      {
       $data = DB::table('ENTETE_FACTURE')->orderBy('DO_Date', 'desc')->get();
       
      }
      echo json_encode($data);
     }

    /// return view('dataRange/data_range');
    }


}

?>
 