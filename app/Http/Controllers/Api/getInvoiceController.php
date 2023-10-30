<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\getInvoice;
use App\Models\getClients;
use Illuminate\Support\Facades\DB;
use App\Models\getdetails_facture;
//use App\Http\Requests\StorePostRequest;


class getInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
/*---------------------------------------------------------------*/
   /* public function show()
    { 
      
      //'clients' => $this->getClients->allDa(),
        $data=getClients::all();
        $getClient=array();
        
    foreach($data as $data){
    $getClient[]=array(
        'nom'=>$data->CT_Num,
         'prenom'=>$data->CT_Intitule,          
      );
    }
      return response()->json([
        'success' => true,
        'msg' => "Opération réussie",
        'result' => (['invoices' => $getClient])
    ],200);
    }
*/
    /*---------------------------------------------------------------*/

    public function show(Request $request)
    { 
      if($Invoice_signature = $request-> Invoice_signature) {


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
            $dede=[
              'item_designation' => $users[0]->DL_Design,
              'item_quantity'  => $users[0]->DL_QteBC,
              'item_price'  => $users[0]->DL_PrixUnitaire,
              'item_ct'  => $users[0]->DL_QteBC*600,
              'item_tl'  => $users[0]->DL_QteBC*22.08,
              'item_price_nvat' => $data->DO_TotalHTNet-($users[0]->DL_QteBC*22.08),
              'vat' => $data->DO_NetAPayer-$data->DO_TotalHTNet,
              'item_price_wvat' => $data->DO_NetAPayer-$users[0]->DL_QteBC*22.08,
              'item_total_amount' => $data->DO_NetAPayer,
            ];

        /*        $dede=array();

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
                    );};  */
                
                  }else{  //mugihe produit atagira TVA

                    $users = DB::table('DETAILS_FACTURE')
                    ->where('DO_Piece',$data->DO_Piece)
                    ->where('AR_Ref',$ff)
                    ->get();

                    $dede=[
                      'item_designation' => $users[0]->DL_Design,
                      'item_quantity'  => $users[0]->DL_QteBC,
                      'item_price'  => $users[0]->DL_PrixUnitaire,   
                      'item_ct'  => '0',
                      'item_tl'  => '0',
                      'item_price_nvat' => $data->DO_TotalHTNet,
                      'vat' => '0',
                      'item_price_wvat' => $data->DO_NetAPayer,
                      'item_total_amount' => $data->DO_NetAPayer,
                    ];
    
             /*       $dede=array();
    
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

                        );};    */
                  };
                  $titi = json_encode([$dede]);


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
                  

                    'invoice_signature'=>$data->E_Signature,
                    'invoice_signature_date' =>$new_invoice_signature_date,
                     'invoice_items' => $titi,        
    
                     );
          
                     }
            

       //     var_dump($dede);
           
          //    $data->whereRaw("CT_Intitule LIKE '%" . $s . "%'");
      

      return response()->json([
              'success' => true,
              'msg' => "Opération réussie",
              'result' => ['invoices' => $getClient, 
             // 'meme' =>$getClien
              ]
                ],200);}

                else {
                  return response()->json([
                    "success"=>  false,
                    "msg"=>  "Veuillez envoyer les donn\u00e9es en utilisant la m\u00e9thode POST.",
                    'result' => []
                  ], 404);    
              }  
    }

   /* -----------------------------------------------------------------------------------------------------*/
   public function liste(Request $request)
   {
              $fromDate = $request->input('fromData');
              $toDate = $request->input('toData');
            
                
            
              $dataa= DB::table('CLIENTS')
                            ->join('ENTETE_FACTURE', 'CLIENTS.CT_Num' , '=', 'ENTETE_FACTURE.DO_Tiers')
                            ->join('DETAILS_FACTURE', 'CLIENTS.CT_Num' , '=', 'DETAILS_FACTURE.CT_Num') 
                            //->whereBetween( 'ENTETE_FACTURE.DO_Piece', [$request->fdate, $request->sdate])
                            ->select(
                            // 'ENTETE_FACTURE.E_Signature',
                              
                              'ENTETE_FACTURE.DO_Date',
                              'ENTETE_FACTURE.DO_Piece',
                              'ENTETE_FACTURE.cbHashdate',
                              'CLIENTS.CT_Intitule',
                              'CLIENTS.CT_Identifiant',
                              'CLIENTS.CT_Siret',
                              'CLIENTS.CT_CodePostal',
                              'CLIENTS.CT_CodeRegion',
                              'CLIENTS.CT_Ville',
                              'CLIENTS.CT_Complement',
                              'CLIENTS.CT_Adresse',
                              'CLIENTS.CT_Adresse',
                              'CLIENTS.CT_Adresse',	
                            // 'CLIENTS.CT_Intitule',
                              'CLIENTS.CT_Identifiant',
                              'CLIENTS.CT_Adresse',
                              'DETAILS_FACTURE.AR_Ref',
                              'DETAILS_FACTURE.DL_Design',
                              'DETAILS_FACTURE.DL_QteBC',
                              'DETAILS_FACTURE.DL_PrixUnitaire',
                              'DETAILS_FACTURE.DL_MontantHT',
                              )
                        ->where('ENTETE_FACTURE.DO_Piece', '>=', $fromDate)
                        ->where('ENTETE_FACTURE.DO_Piece', '<=', $toDate)
                        ->get();



       $getClientee=array();
       $getClien=array();
       
           foreach($dataa as $dataa){
           $getClientee[]=array(
             'invoice_number'=>$dataa->DO_Piece,
             'invoice_date'=>$dataa->DO_Date,
            // 'tp_type'=>$data->,
             'tp_name'=>$dataa->CT_Intitule,
             'tp_TIN'=>$dataa->CT_Identifiant,
             'tp_trade_number'=>$dataa->CT_Siret,
             'tp_postal_number'=>$dataa->CT_CodePostal,
             'tp_adress_privonce'=>$dataa->CT_CodeRegion,
             'tp_adresse_commune'=>$dataa->CT_Ville,
             'tp_address_quartier'=>$dataa->CT_Complement,
             'tp_adresse_avenue'=>$dataa->CT_Adresse,
             'tp_adresse_rue'=>$dataa->CT_Adresse,
             'tp_adresse_number'=>$dataa->CT_Adresse,
            // 'vat_taxpayer'=>$data->,
            // 'ct_taxpayer'=>$data->,
           //  'tl_taxpayer'=>$data->,
           //  'tp_fiscal_center'=>$data->,
           //  'tp_activity_sector'=>$data->,
          //   'tp_legal_form'=>$data->,
          //   'payment_type'=>$data->,
             'customer_name'=>$dataa->CT_Intitule,
             'customer_TIN'=>$dataa->CT_Identifiant,
             'customer_adress'=>$dataa->CT_Adresse,
           //  'vat_customer_payer'=>$data->,
          //   'cancelled_invoice_ref'=>$data->,
          //   'invoice_signature'=>$data->,
             'invoice_signature_date'=>$dataa->cbHashdate,
             
             'invoice_items'=>$dataa->AR_Ref,
             'item_designation'=>$dataa->DL_Design,
             'item_quantity'=>$dataa->DL_QteBC,
             'item_price'=>$dataa->DL_PrixUnitaire,
           //  'item-ct'=>$data->,
           //  'item_tl'=>$data->,
            // 'item_price_nvat'=>$data->DL_MontantHT,  
                      
             );
           /*  $getClien[]=array(

               'item_price_nvat'=>$data->DL_MontantHT,       
             );*/

           }
           

          

         //    $data->whereRaw("CT_Intitule LIKE '%" . $s . "%'");
     

           return response()->json([
             'success' => true,
             'msg' => "Opération réussie",
             'result' => ['invoices' => $getClientee, 
            // 'meme' =>$getClien
             ]
               ],200);

                       
    }




   /* ----------------------------------------------------------------------------------------------------- */
    


  /*  public function index()
    {

     // $invoice_number = 'DO_Piece';
        $getInvoice = getInvoice::all(['DO_Piece', 'DO_Type']);
        

        return response()->json([
            'success' => true,
            'msg' => "Opération réussie",
            'result' => (['invoices' => $getInvoice])
           // 'invoices' => $getInvoice
        ],200);
        
        //$getInvoice = getInvoice::all();
        //return response()->json(['getInvoice' =>$getInvoice], 200);
    }
*/


/*
public function index()
    {
      $getInvoic = getClients::all(['CT_Num','CT_Intitule']);
     

      $getClient=array();
      foreach($getInvoic as $gigi){

        $DO_Tiers=$gigi->CT_Num;
        $gute = getInvoice::find($DO_Tiers);
        
        $getClient[]=array(
          'DO_Piece'=>$gigi->id,
           'DO_Type'=>$gigi->name,
          'CT_Num'=>$gute->jiji
        );

      }

       return $this->sendResponse($getClient, 'succes');
   
      }

*/



   

    public function __construct()
    {
      $this->getClients = new getClients();
     // $this->CT_Num = 'id';
     // $this->id = request('CT_Num');
    }

    public function index()
    {
      
      $getd = [
       // $this->CT_Num = 'id',
       // 'CT_Num' => 'id',
        'client' => $this->getClients->allDate(),
        //'clients' => $this->getClients->allDa(),
        

      ];
      

      return response()->json([
        
     //   $this->CT_Num = 'id',
       // 'CT_Num' =>getClients->id,
        'success' => true,
        'msg' => "Opération réussie",
        'result' => (['invoices' => $getd])
       // 'invoices' => $getInvoice
    ],200);
    }






  /*  public function shower($DO_Piece)
    {
        $getInvoice = getInvoice::find($DO_Piece, 'DO_Tiers');

               if($getInvoice ){
                          return response()->json([
                              'success' => true,
                              'msg' => "operation reussie",
                              'invoices' => $getInvoice
                          ],200);
                }
                else{
                  return response()->json(['message' => 'No invoice found'],404);
                 }
        
        //$getInvoice = getInvoice::all();
        //return response()->json(['getInvoice' =>$getInvoice], 200);
    


              if (getInvoice::where('DO_Piece', $DO_Piece)->exists()) {
                  $getInvoice = getInvoice::where('DO_Piece', $DO_Piece)->get()->toJson(JSON_PRETTY_PRINT);
                  return response($getInvoice, 200);
                } 
                
                else {
                  return response()->json([
                    "message" => "No invoice found"
                  ], 404);
              }
     }

        */


}



