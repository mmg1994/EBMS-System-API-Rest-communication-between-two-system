<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AnnulerController extends Controller
{
    function search(){

       
        // if( isset($_GET['query']) && strlen($_GET['query']) > 1){

        //     $search_text = $_GET['query'];
        //     $countries = DB::table('country')->where('Name','LIKE','%'.$search_text.'%')->paginate(2);
        //     // $countries->appends($request->all());
        //     return view('search',['countries'=>$countries]);
            
        // }else{
        //      return view('search');
        // }
        return view('dataRange/annuler');
       
          }


          function isend(){

       
            // if( isset($_GET['query']) && strlen($_GET['query']) > 1){
    
            //     $search_text = $_GET['query'];
            //     $countries = DB::table('country')->where('Name','LIKE','%'.$search_text.'%')->paginate(2);
            //     // $countries->appends($request->all());
            //     return view('search',['countries'=>$countries]);
                
            // }else{
            //      return view('search');
            // }
            return view('dataRange/invoicesend');
           
              }

    function find(Request $request){
            $request->validate([
              'query'=>'required|min:2'
           ]);
  
           $search_text = $request->input('query');
           $nif = DB::table('ENTETE_FACTURE')
                      ->where('DO_Tiers','LIKE','%'.$search_text.'%')
                    //   ->orWhere('SurfaceArea','<', 10)
                    //   ->orWhere('LocalName','like','%'.$search_text.'%')
                      ->paginate(2);
            return view('dataRange/search',['nif'=>$nif]);   


    }



    function finder(Request $request){
       
        $request->validate([
            'query'=>'required|min:2'
         ]);
   $tp_TIN = $request->input('query');
        $response = Http::post('https://ebms.obr.gov.bi:8443/ebms_api/login/', [

          'username'=> 'the username',  // ici il faudra mettre le username delivre par l'OBR
          'password'=> 'the password',  // ici il faudra mettre le mot de passe delivre par l'OBR
         
       ]);
                $json= json_decode($response->getBody());
                $token = $json->result->token;
 
            $niff = Http::withHeaders([
                
                'Authorization' => 'Bearer '.$token,
               
            ])
       
            ->post("https://ebms.obr.gov.bi:8443/ebms_api/cancelInvoice/",[
                'tp_TIN' => $tp_TIN,
                
            ]);
           $json= json_decode($niff->getBody());
           $nifff = $json->success;
         if ( $nifff == 1 ){
            $nif = $json->result->taxpayer[0]->tp_name;
          return view('dataRange/search',['nif'=>$nif]);} else {
            return view('dataRange/search',['nif'=>'NIF not found']);
          }
    // return $nif->json();
}


function findere(Request $request){


       
    $request->validate([
        'query'=>'required|min:2',
        'queryy'=>'required|min:2'
     ]);
$invoice_signature = $request->input('query');
$cn_motif = $request->input('queryy');

//$invoice_signature = $request->query;
    $response = Http::post('https://ebms.obr.gov.bi:8443/ebms_api/login/', [

      'username'=> 'the username',  // ici il faudra mettre le username delivre par l'OBR
      'password'=> 'the password',  // ici il faudra mettre le mot de passe delivre par l'OBR
     
   ]);
            $json= json_decode($response->getBody());
            $token = $json->result->token;

        $isend = Http::withHeaders([
            
            'Authorization' => 'Bearer '.$token,
           
        ])
   
        ->post("https://ebms.obr.gov.bi:8443/ebms_api/cancelInvoice/",[
            'invoice_signature' => $invoice_signature,
            'cn_motif' => $cn_motif,
            
        ]);
       $json= json_decode($isend->getBody());

       $nifff = $json->success;

     //  var_dump($nifff);
       $WW= true;
       $qq= false;
      if ( $nifff == $WW ){

     
       $invoice_number= $json->msg;
       
      // $nife = json_encode($gif, true);
      
      $invoice_number=array('invoice_number'=>$invoice_number);
      


    
   //  var_dump($invoice_items);
    // echo $nif['one'];
    //  var_dump(json_encode($nif, true));
      //echo($nif);
    // return view('dataRange/invoicesend',['nif'=>$nif]);
 //  return view('report.wetu', compact('nif'));
//4000004566/ws400000456600327/20230208000000/00001

                    
                return view("dataRange/annuler")->with([
                    'invoice_number'=>$json->msg,
                   
                    ]); 
                        } else if( $nifff == $qq ){  
                
               // return view("dataRange/invoicesend")->with(['invoice_number'=>'INVOICE not found']);
                return view('dataRange/annuler')->with([
                  'invoice_number'=> $json->msg,
                  ]); 
           
            // return $nif->json();    
            }else{ return view('dataRange/annuler')->with([
              'invoice_number'=> $json->msg,
              ]);}



        }
}