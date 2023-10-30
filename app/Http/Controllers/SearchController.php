<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;



class SearchController extends Controller
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
        return view('dataRange/search');
       
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

          "username" => "wsl400000456600352",
          "password" => "\\E3pn~;f",
         
       ]);
                $json= json_decode($response->getBody());
                $token = $json->result->token;
 
            $niff = Http::withHeaders([
                
                'Authorization' => 'Bearer '.$token,
               
            ])
       
            ->post("https://ebms.obr.gov.bi:8443/ebms_api/checkTIN/",[
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
        'query'=>'required|min:2'
     ]);
$invoice_signature = $request->input('query');
//$invoice_signature = $request->query;
    $response = Http::post('https://ebms.obr.gov.bi:8443/ebms_api/login/', [

      'username'=> 'the username',  // ici il faudra mettre le username delivre par l'OBR
      'password'=> 'the password',  // ici il faudra mettre le mot de passe delivre par l'OBR

    // "username" => "ws400000456600327",
    // "password" => "8G^c{2T1",
    
     
   ]);
            $json= json_decode($response->getBody());
            $token = $json->result->token;

        $isend = Http::withHeaders([
            
            'Authorization' => 'Bearer '.$token,
           
        ])
   
        ->post("https://ebms.obr.gov.bi:8443/ebms_api/getInvoice/",[
            'invoice_signature' => $invoice_signature,
            
        ]);
       $json= json_decode($isend->getBody());

       $nifff = $json->success;

 
       $hawo = $json->result->invoices[0]->cancelled_invoice;

       $futu = "N";
       $vitu = "Y";

      // var_dump($nifff);
       $WW= true;
       $qq= false;
      if ( $nifff == $WW ){

        if($hawo == $futu){
        
        $customer_name = $json->result->invoices[0]->customer_name;
        $invoice_number= $json->result->invoices[0]->invoice_number;
        $invoice_date= $json->result->invoices[0]->invoice_date;
        $cancelled_invoice =  $json->result->invoices[0]->cancelled_invoice;
        $invoice_signature_date= $json->result->invoices[0]->invoice_signature_date;
        $item_designation = $json->result->invoices[0]->invoice_items[0]->item_designation;
        $item_price= $json->result->invoices[0]->invoice_items[0]->item_price;
        $item_quantity= $json->result->invoices[0]->invoice_items[0]->item_quantity;
       // $nife = json_encode($gif, true);
       
       $invoice_number=array('invoice_number'=>$invoice_number);
       $customer_name=array('customer_name'=>$customer_name);
       $cancelled_invoice=array('cancelled_invoice'=>$cancelled_invoice);
       $item_designation=array('item_designation'=>$item_designation);
       $item_price=array('item_price'=>$item_price);
       $item_quantity=array('item_quantity'=>$item_quantity);
       $invoice_date=array('invoice_date'=>$invoice_date);
       $invoice_signature_date=array('invoice_signature_date'=>$invoice_signature_date);
 
 
     
    //  var_dump($invoice_items);
     // echo $nif['one'];
     //  var_dump(json_encode($nif, true));
       //echo($nif);
     // return view('dataRange/invoicesend',['nif'=>$nif]);
  //  return view('report.wetu', compact('nif'));
 //4000004566/ws400000456600327/20230208000000/00001
 
                     
                 return view("dataRange/invoicesend")->with([
                     'invoice_number'=>$invoice_number,
                     'customer_name'=>$customer_name,
                     'item_designation'=>$item_designation,
                     'item_price'=>$item_price,
                     'item_quantity'=>$item_quantity,
                     'cancelled_invoice'=>$cancelled_invoice,
                     'invoice_date'=>$invoice_date,
                     'invoice_signature_date'=>$invoice_signature_date,
                     ]); 
                    } else{
     
                      $customer_name = $json->result->invoices[0]->customer_name;
                      $invoice_number= $json->result->invoices[0]->invoice_number;
                      $invoice_date= $json->result->invoices[0]->invoice_date;
                      $invoice_signature_date= $json->result->invoices[0]->invoice_signature_date;
                      $cancelled_invoice =  $json->result->invoices[0]->cancelled_invoice;
                    //  $item_designation = $json->result->invoices[0]->invoice_items[0]->item_designation;
                    //  $item_price= $json->result->invoices[0]->invoice_items[0]->item_price;
                    //  $item_quantity= $json->result->invoices[0]->invoice_items[0]->item_quantity;
                     // $nife = json_encode($gif, true);
                     
                     $invoice_number=array('invoice_number'=>$invoice_number);
                     $customer_name=array('customer_name'=>$customer_name);
                     $cancelled_invoice=array('cancelled_invoice'=>$cancelled_invoice);
                   //  $item_designation=array('item_designation'=>$item_designation);
                   //  $item_price=array('item_price'=>$item_price);
                  //   $item_quantity=array('item_quantity'=>$item_quantity);
                     $invoice_date=array('invoice_date'=>$invoice_date);
                     $invoice_signature_date=array('invoice_signature_date'=>$invoice_signature_date);
               
               
                   
                  //  var_dump($invoice_items);
                   // echo $nif['one'];
                   //  var_dump(json_encode($nif, true));
                     //echo($nif);
                   // return view('dataRange/invoicesend',['nif'=>$nif]);
                //  return view('report.wetu', compact('nif'));
               //4000004566/ws400000456600327/20230208000000/00001
               
                                   
                               return view("dataRange/invoiceCancellled")->with([
                                   'invoice_number'=>$invoice_number,
                                   'customer_name'=>$customer_name,
                                   'cancelled_invoice'=>$cancelled_invoice,
                                 //  'item_designation'=>$item_designation,
                                 //  'item_price'=>$item_price,
                                 //  'item_quantity'=>$item_quantity,
                                   'invoice_date'=>$invoice_date,
                                   'invoice_signature_date'=>$invoice_signature_date,
                                  ]);
            
                    }
            
             
                                    } else if( $nifff == $qq ){  
                            
                           // return view("dataRange/invoicesend")->with(['invoice_number'=>'INVOICE not found']);
                            return view('dataRange/invoicesendNotfound')->with([
                              'invoice_number'=>'INVOICE NOT FOUND',
                              ]); 
                       
                        // return $nif->json();    
                        }else{ return view('dataRange/invoicesendNotfound')->with([
                          'invoice_number'=>'INVOICE NOT FOUND',
                          ]);}
            
            
            
                    }
            }