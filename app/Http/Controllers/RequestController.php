<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



use App\Models\User;
use App\Http\Controllers\Controller;

use App\Models\getInvoice;
use App\Models\getClients;

use App\Models\getdetails_facture;


class RequestController extends Controller
{
    public function list(){
        $getInvoice =  DB::table('CLIENTS')
        ->join('ENTETE_FACTURE', 'CLIENTS.CT_Num' , '=', 'ENTETE_FACTURE.DO_Tiers')
        ->join('DETAILS_FACTURE', 'CLIENTS.CT_Num' , '=', 'DETAILS_FACTURE.CT_Num')
        ->select(
            'CLIENTS.CT_Intitule',
            'ENTETE_FACTURE.DO_Piece',
            'ENTETE_FACTURE.DO_Type',
            'ENTETE_FACTURE.DO_Date',)
        ->get();
        return view('student.student_all', compact('studentShow'));
            }


     public function getAllPost(){
        $post = Http::get("https://jsonplaceholder.typicode.com/posts")->json();
        //return $post->json();

        return view ('PlaceholderAPI.index', compact('post'));

       // return $post->json();
       
        }

      public function edit($id){

        $post = Http::get('https://jsonplaceholder.typicode.com/posts/'.$id)->json();

            //return $post;

                    return view('PlaceholderAPI.edit', compact('post'));
                    }



                        public function singlePost($id){

                            $post = Http::get("https://jsonplaceholder.typicode.com/posts".$id);
                            return $post->json();
                        }


                        public function addPost(){
                            $post = Http::post("https://jsonplaceholder.typicode.com/posts",[
                                'title' => 'New Title',
                                'body' => 'Test Body'
                            ]);
                            return $post->json();
                        }

                        public function headersPost(){
                            $post = Http::withToken(getenv('TOKEN'))
                            ->post("https://jsonplaceholder.typicode.com/posts",[
                                'title' => 'New Title',
                                'body' => 'Test Body'
                            ]);
                            return $post->json();
                        }


                        public function postGuzzleRequest(Request $request){

                                   $Invoice_signature = $request->Invoice_signature;
                                   $data= DB::table('CLIENTS')
                                   ->join('ENTETE_FACTURE', 'CLIENTS.CT_Num' , '=', 'ENTETE_FACTURE.DO_Tiers')
                                   ->join('DETAILS_FACTURE', 'CLIENTS.CT_Num' , '=', 'DETAILS_FACTURE.CT_Num')
                                   ->select(
                                     
                                     'CLIENTS.CT_Intitule',
                                     'CLIENTS.CT_Num', 
                                     'CLIENTS.CT_Identifiant',
                                     'ENTETE_FACTURE.DO_Date',
                                     'CLIENTS.CT_Type',  
                                     'CLIENTS.CT_Siret',
                                     'CLIENTS.CT_Ville',
                                     'CLIENTS.CT_Complement', 
                                     'CLIENTS.CT_Ape', 
                                     'CLIENTS.CT_Ape',
                                     'CLIENTS.CT_Ape', 
                                     'CLIENTS.CT_Contact',  
                                     'CLIENTS.CT_Adresse',
                                     'CLIENTS.CT_Commentaire',
                                     'ENTETE_FACTURE.DO_Piece',
                                     'ENTETE_FACTURE.DO_Coord01',
                                     'ENTETE_FACTURE.DO_TotalHTNet',
                                     'ENTETE_FACTURE.DO_NetAPayer',
                                     
                                     //'CLIENTS.CT_Intitule',
                                     'ENTETE_FACTURE.E_Signature',   
                                     'ENTETE_FACTURE.cbHashdate',
                                     'DETAILS_FACTURE.AR_Ref', 
                                    
                                    
                                    
                                   // Il faut fournir un tableau contenant les éléments suivants: 
                                    'DETAILS_FACTURE.DL_Design', 
                                    'DETAILS_FACTURE.DL_QteBC', 
                                    'DETAILS_FACTURE.DL_PrixUnitaire', 
                                    'DETAILS_FACTURE.DL_MontantHT',
                                   //  'vat=>$data->',
                                 //    'item_price_wvat=>$data->',
                                    'DETAILS_FACTURE.DL_TRemExep'
                   
                                     )
                                      ->whereRaw("ENTETE_FACTURE.E_Signature LIKE '%" . $Invoice_signature. "%'")
                                      ->get();
                                 $getClient=array();
                   
                                  foreach($data as $data){
                                   // kurondera type ya produit nkorerako condition ya select
                                   $PFSUC=DB::table('DETAILS_FACTURE')
                                   ->where('DO_Piece',$data->DO_Piece)
                                   ->get('AR_Ref');
                   
                                   // condiction ya select ya produit
                                   $ff=$PFSUC[0]->AR_Ref;
                                   $fff='PFSUC';
                                   if($ff == $fff){
                   
                                   $users = DB::table('DETAILS_FACTURE')
                                   ->where('DO_Piece',$data->DO_Piece)
                                   ->where('AR_Ref',$ff)
                                   ->get();
                   
                                  // ku getinga resultat
                                   $dede=array();
                   
                                      foreach($users as $users){
                                       $dede[]=array(
                                         'item_designation' => $users->DL_Design,
                                         'item_quantity'  => $users->DL_QteBC,
                                         'item_price'  => $users->DL_PrixUnitaire,
                                         'item_ct'  => $users->DL_QteBC*600,
                                         'item_tl'  => $users->DL_QteBC*22.08,
                                         'item_price_nvat' => $data->DO_TotalHTNet-($users->DL_QteBC*22.08),
                                         'vat' => $data->DO_NetAPayer-$data->DO_TotalHTNet,
                                         'item_price_wvat' => $data->DO_NetAPayer-$users->DL_QteBC*22.08,
                                         'item_total_amount' => $data->DO_NetAPayer,
                                       );};
                                   
                                     }else{  //mugihe produit atagira TVA
                   
                                       $users = DB::table('DETAILS_FACTURE')
                                       ->where('DO_Piece',$data->DO_Piece)
                                       ->where('AR_Ref',$ff)
                                       ->get();
                       
                                       $dede=array();
                       
                                          foreach($users as $users){
                                           $dede[]=array(
                                         'item_designation' => $users->DL_Design,
                                         'item_quantity'  => $users->DL_QteBC,
                                         'item_price'  => $users->DL_PrixUnitaire,   
                                         'item_ct'  => '0',
                                         'item_tl'  => '0',
                                         'item_price_nvat' => $data->DO_TotalHTNet,
                                         'vat' => '0',
                                         'item_price_wvat' => $data->DO_NetAPayer,
                                         'item_total_amount' => $data->DO_NetAPayer,
                   
                                           );};
                                     };
                   
                   
                                       // convertir les dates 
                   
                                       // convertir les dates ** invoice_date **
                                       $invoice_date = $data->DO_Date;
                                       $timestamp = strtotime($invoice_date); 
                                      $new_invoice_date = date("Y-m-d 00:00:00", $timestamp );
                   
                                      // convertir les dates ** invoice_date **
                                      $invoice_signature_date = $data->cbHashdate;
                                      $timestamp = strtotime($invoice_signature_date); 
                                     $new_invoice_signature_date = date("Y-m-d 00:00:00", $timestamp );
                   
                                     // convertir assigety a la TVA **
                                     $ret=$data->CT_Ape;
                                      if(empty($ret)) {
                                          $TVA = '0';
                                      } else{
                                       $TVA = '1';
                                      };
                   
                   
                   
                   
                                      $getClient[0]=array(
                   
                    
                                       'invoice_number'=>$data->DO_Piece,
                                       'invoice_date'  =>$new_invoice_date,
                                       'invoice_type' => 'FN',
                                       'tp_type'=>'1',
                                       'tp_name'=>'SOSUMO SOCIETE SUCRIERE DU MOSO',
                                       'tp_TIN'=>'4000004566',
                                       'tp_trade_number' =>'23904',
                                       'tp_postal_number' => 'BP835',
                                       'tp_phone_number' =>'22507102',
                                       'tp_address_province' =>'RUTANA',
                                       'tp_address_commune' =>'BUKEMBA',
                                       'tp_address_quartier' =>'GIHOFI', 
                                       'tp_address_avenue'=> '',
                                       'tp_address_number' => '',
                                       'vat_taxpayer' =>'1', 
                                       'ct_taxpayer' =>'1',
                                       'tl_taxpayer' =>'1', 
                                       'tp_fiscal_center' =>'DGC', 
                                       'tp_activity_sector' =>'INDUSTRIE',
                                       'tp_legal_form' =>'SM',
                                       'payment_type' =>'4',
                                       'invoice_currency' => 'BIF',
                                       'customer_name' =>$data->CT_Intitule,
                                       'customer_TIN' =>$data->CT_Identifiant,
                                       'customer_address' =>$data->CT_Adresse,
                                       'vat_customer_payer' =>$TVA,
                                       'cancelled_invoice_ref' =>'',
                                       'invoice_ref' => '',
                                       'cn_motif' => '',
                   
                                       'invoice_signature'=>$data->E_Signature,
                                       'invoice_signature_date' =>$new_invoice_signature_date,
                                        'invoice_items' => $dede,        
                       
                                        );
                             
                                        }
                               

                                $response = Http::post('https://ebms.obr.gov.bi:9443/ebms_api/login/', [

                                    'username'=> 'the username',  // ici il faudra mettre le username delivre par l'OBR
                                   'password'=> 'the password',  // ici il faudra mettre le mot de passe delivre par l'OBR
                                 
                               ]);

                               $json= json_decode($response->getBody());
                               $token = $json->result->token;
                               //var_dump($token);
                               //echo $token;
                               
                              // echo $json[0]['token'];
                               // var_dump($response);

                        $response = Http::withHeaders([
                            'Authorization' => 'Bearer '.$token
                        ])->post("https://ebms.obr.gov.bi:9443/ebms_api/addInvoice/", [

                     
                          'invoice_number'=>$data->DO_Piece,
                          'invoice_date'  =>$new_invoice_date,
                          'invoice_type' => 'FN',
                          'tp_type'=>'1',
                          'tp_name'=>$data->tp_name,
                          'tp_TIN'=>$data->tp_TIN,
                          'tp_trade_number' =>$data->tp_trade_number,
                          'tp_postal_number' => $data->tp_postal_number,
                          'tp_phone_number' =>$data->tp_phone_number,
                          'tp_address_province' =>$data->tp_address_province,
                          'tp_address_commune' =>$data->tp_address_commune,
                          'tp_address_quartier' =>$data->tp_address_quartier, 
                          'tp_address_avenue'=> '',
                          'tp_address_number' => '',
                          'vat_taxpayer' =>'1', 
                          'ct_taxpayer' =>'1',
                          'tl_taxpayer' =>'1', 
                          'tp_fiscal_center' =>'DGC', 
                          'tp_activity_sector' =>'INDUSTRIE',
                          'tp_legal_form' =>'SM',
                          'payment_type' =>'4',
                          'invoice_currency' => 'BIF',
                          'customer_name' =>$data->CT_Intitule,
                          'customer_TIN' =>$data->CT_Identifiant,
                          'customer_address' =>$data->CT_Adresse,
                          'vat_customer_payer' =>$TVA,
                          'cancelled_invoice_ref' =>'',
                          'invoice_ref' => '',
                          'cn_motif' => '',
      
                          'invoice_signature'=>$data->E_Signature,
                          'invoice_signature_date' =>$new_invoice_signature_date,
                           'invoice_items' => $dede,        
          

                        ]);
                        

                        return $response->json();
                   //    return view('report.report',compact('data'));

                         }
              public function test(Request $request){

                                $Invoice_signature = $request->Invoice_signature;
                              $data= DB::table('CLIENTS')
                              ->join('ENTETE_FACTURE', 'CLIENTS.CT_Num' , '=', 'ENTETE_FACTURE.DO_Tiers')
                              ->join('DETAILS_FACTURE', 'CLIENTS.CT_Num' , '=', 'DETAILS_FACTURE.CT_Num')
                              ->select(
                                'CLIENTS.CT_Intitule',
                                'CLIENTS.CT_Num', 
                                'ENTETE_FACTURE.DO_Date',
                                'CLIENTS.CT_Type',  
                                'CLIENTS.CT_Siret',
                                'CLIENTS.CT_Ville',
                                'CLIENTS.CT_Complement', 
                                'CLIENTS.CT_Ape', 
                                'CLIENTS.CT_Ape',
                                'CLIENTS.CT_Ape', 
                                'CLIENTS.CT_Contact', 
                                'CLIENTS.CT_Commentaire',
                                'ENTETE_FACTURE.DO_Coord01',
                                //'CLIENTS.CT_Intitule',
                                'ENTETE_FACTURE.E_Signature',   
                                'ENTETE_FACTURE.cbHashdate',
                                'DETAILS_FACTURE.AR_Ref', 
                               
                                'ENTETE_FACTURE.DO_Piece',
                               
                              // Il faut fournir un tableau contenant les éléments suivants: 
                               'DETAILS_FACTURE.DL_Design', 
                               'DETAILS_FACTURE.DL_QteBC', 
                               'DETAILS_FACTURE.DL_PrixUnitaire', 
                               'DETAILS_FACTURE.DL_MontantHT',
                              //  'vat=>$data->',
                                 //    'item_price_wvat=>$data->',
                               'DETAILS_FACTURE.DL_TRemExep'

                                    )

                                    
                                 ->whereIn('E_Signature', $Invoice_signature)
                                 
                                 ->get();
                                  $getClient=array();
                                   foreach($data as $data){
                                 $getClient[]=array(

                                     'tp_name'=>$data->CT_Intitule,
                                     'tp_TIN'=>$data->CT_Num,
                                   'num'  =>$data->DO_Piece,
                                   //-------------------------------- 
              
                                     'invoice_date'  =>$data->DO_Date,
                                     'tp_type'=>$data->CT_Type,
                                     'tp_trade_number' =>$data->CT_Siret,
                                     'tp_address_commune' =>$data->CT_Ville,
                                     'tp_address_quartier' =>$data->CT_Complement, 
                                     'vat_taxpayer' =>$data->CT_Ape, 
                                     'ct_taxpayer' =>$data->CT_Ape,
                                     'tl_taxpayer' =>$data->CT_Ape, 
                                     'tp_fiscal_center' =>$data->CT_Contact, 
                                     'tp_activity_sector' =>$data->CT_Commentaire,
                                     'payment_type' =>$data->DO_Coord01,
                                     'customer_name' =>$data->CT_Intitule,
              
                                     'invoice_signature'=>$data->E_Signature,
              
                                     'invoice_signature_date' =>$data->cbHashdate,
                                   //  'invoice_items' =>$data->AR_Ref,      
              
                                     // Il faut fournir un tableau contenant les éléments suivants: 
              
                                     'invoice_items' =>[
                                          
                                          [  
                                            'item_designation'=>$data->DL_Design, 
                                            'item_quantity'=>$data->DL_QteBC, 
                                            'item_price'=>$data->DL_PrixUnitaire, 
                                            'item_price_nvat'=>$data->DL_MontantHT,
                                            //-----$$$$$$$$$$$$$$$$$$--------//
                                            'vat'=>$data->DL_TRemExep,
                                            'item_price_wvat'=>$data->DL_TRemExep,
                                            //-----$$$$$$$$$$$$$$$$$$$---------//
                                            
                                          ],
                                      
                                      
                                          [ 'item_designation'=>$data->DL_Design, 
                                          'item_quantity'=>$data->DL_QteBC, 
                                          'item_price'=>$data->DL_PrixUnitaire, 
                                          'item_price_nvat'=>$data->DL_MontantHT,
                                          //-----$$$$$$$$$$$$$$$$$$--------//
                                          'vat'=>$data->DL_TRemExep,
                                          'item_price_wvat'=>$data->DL_TRemExep,
                                          //-----$$$$$$$$$$$$$$$$$$$---------//
                                          
                                          ]
                                     ]
              
                         );
                     }

                         //  print_r($request->Invoice_signature);

                      //   $Invoice_signature = $request->Invoice_signature;

                    //     User::whereIn('id', $Invoice_signature)->delete();
                      //      return redirect()->back();

                      return view('report/invoice', $getClient);
                    //return redirect('form/report');
                  
               
            }



         public function login(){

            $response = Http::post('https://ebms.obr.gov.bi:9443/ebms_api/login/', [

              'username'=> 'the username',  // ici il faudra mettre le username delivre par l'OBR
              'password'=> 'the password',  // ici il faudra mettre le mot de passe delivre par l'OBR
              
            ]);

            $json= json_decode($response, true);
            dd($json);

        }


        

        public function getAllInvoice(Request $request){

            $Invoice_signature = $request->input('Invoice_signature');

            $response = Http::post('https://ebms.obr.gov.bi:9443/ebms_api/login/', [
              'username'=> 'the username',  // ici il faudra mettre le username delivre par l'OBR
              'password'=> 'the password',  // ici il faudra mettre le mot de passe delivre par l'OBR
             
           ]);

                    $json= json_decode($response->getBody());
                    $token = $json->result->token;
                    //var_dump($token);
                    //echo $token;
                    
                // echo $json[0]['token'];
                    // var_dump($response);

                $response = Http::withHeaders([
                    
                    'Authorization' => 'Bearer '.$token
                ])
                ->whereRaw("CT_Num LIKE '%" . $Invoice_signature. "%'")
                ->get("https://ebms.obr.gov.bi:9443/ebms_api/getInvoice/")->json();

                return $response->json();






         /*   $post = Http::get("https://jsonplaceholder.typicode.com/posts")->json();
            //return $post->json();
    
            return view ('PlaceholderAPI.index', compact('post'));
    
           // return $post->json();
            */
        }

}


