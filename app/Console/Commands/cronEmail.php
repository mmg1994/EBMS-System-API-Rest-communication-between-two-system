<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Http;
use App\Models\Personal;
use Illuminate\Support\Facades\DB;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
       // info('hello world');  //c'est la ou on met la function
       // return 0;
       info("Cron Job running at ". now());
    
       /*------------------------------------------
       --------------------------------------------
       Write Your Logic Here....
       I am getting users and create new users if not exist....
       --------------------------------------------
       --------------------------------------------
       $response = Http::get('https://jsonplaceholder.typicode.com/users');
       
       $users = $response->json();
   
       if (!empty($users)) {
           foreach ($users as $key => $user) {
               
                   Personal::create([
                       'name' => $user['name'],
                       'email' => $user['email'],
                       'password' => bcrypt('123456789')
                   ]);
               
           }
       }

      }    */
   /*  ////////////////////////////////////////////////////////////////////////////////////////////////////  
      $ww='2023-01-11';
      $data = DB::table('ENTETE_FACTURE')
        ->where('DO_Date',$ww )
        ->get();
       
      
  
      if (!empty($data)) {
          foreach ($data as $key => $user) {
            
            DB::table('personals')->insert([
                      'username' => $user->DO_Piece,
                      'email' => $user->DO_Ref,
                     
                  ]);
              //php artisan schedule:work
          }
      }     
      ////////////////////////////////////////////////////////////////////////  */

      $timestamp = time();
      $currentDate = gmdate('Y-m-d', $timestamp);

      $ww='2023-01-23';
      $data= DB::table('ENTETE_FACTURE')
      //  ->where('DO_Date',$ww )
        ->where('DO_Date',$currentDate)
         ->get();
         $getClient=array(); 

         if (!empty($data)) {

          foreach($data as $data){
            // kurondera type ya produit nkorerako condition ya select
            $PFSUC=DB::table('DETAILS_FACTURE')
            ->where('DO_Piece',$data->DO_Piece)
            ->get('AR_Ref');

            // condiction ya select ya produit
            $ff=$PFSUC[0]->AR_Ref;
            $fff='PFSUC';
            if($ff == $fff){

            $userss = DB::table('DETAILS_FACTURE')
            ->where('DO_Piece',$data->DO_Piece)
            ->where('AR_Ref',$ff)
            ->get();

           // ku getinga resultat
            $dedee=array();

               foreach($userss as $userss){
                $dedee[]=array(
                  'item_designation' => $userss->DL_Design,
                  'item_quantity'  => $userss->DL_QteBC,
                  'item_price'  => $userss->DL_PrixUnitaire,
                  'item_ct'  => $userss->DL_QteBC*350,
                  'item_tl'  => $userss->DL_QteBC*31.58,
                  //'item_price_nvat' => $data->DO_TotalHTNet-($userss->DL_QteBC*22.08),

                 // && recent && 'item_price_nvat' => $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                 'item_price_nvat' => $userss->DL_QteBC * 2676.62,

                  //'vat' => $data->DO_NetAPayer-$data->DO_TotalHTNet,

                 // && recent && 'vat' =>(($userss->DL_QteBC * $userss->DL_PrixUnitaire)*0.18),
                 'vat' =>(($userss->DL_QteBC * 2676.62)*0.18),

                 // 'item_price_wvat' => $data->DO_NetAPayer-$userss->DL_QteBC*22.08,

                  // && recent && 'item_price_wvat' => ($userss->DL_QteBC * $userss->DL_PrixUnitaire) + (($userss->DL_QteBC * $userss->DL_PrixUnitaire)*0.18),
                  'item_price_wvat' => ($userss->DL_QteBC * 2676.62) + (($userss->DL_QteBC * 2676.62)*0.18),

                 // && recent && 'item_total_amount' => $data->DO_NetAPayer,
                 'item_total_amount' => (($userss->DL_QteBC * 2676.62) + (($userss->DL_QteBC * 2676.62)*0.18)) + $userss->DL_QteBC*31.58,
                 //'item_total_amount' => (($userss->DL_QteBC * $userss->DL_PrixUnitaire) + (($userss->DL_QteBC * $userss->DL_PrixUnitaire)*0.18)) + $userss->DL_QteBC*22.08,
              //  item_price_nvat=Qte*2676.62
              //  vat=item_price_nvat*18/100

                  );};
            
              }else{  //mugihe produit atagira TVA

                $userss = DB::table('DETAILS_FACTURE')
                ->where('DO_Piece',$data->DO_Piece)
                ->where('AR_Ref',$ff)
                ->get();

                $dedee=array();

                   foreach($userss as $userss){
                    $dedee[]=array(
                      'item_designation' => $userss->DL_Design,
                      'item_quantity'  => $userss->DL_QteBC,
                      'item_price'  => $userss->DL_PrixUnitaire,   
                      'item_ct'  => '0',
                      'item_tl'  => '0',
                    // 'item_price_nvat' => $data->DO_TotalHTNet,
                      'item_price_nvat' =>  $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                      'vat' => '0',
                      'item_price_wvat' => $data->DO_NetAPayer,
                    // 'item_price_wvat' => $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                      'item_total_amount' => $data->DO_NetAPayer,
                    // 'item_total_amount' => $userss->DL_QteBC * $userss->DL_PrixUnitaire,
                   
                    );};
              };


        $titi = json_encode([$dedee]);


          // convertir les dates 

          // convertir les dates ** invoice_date **
          $invoice_date = $data->DO_Date;
          $timestamp = strtotime($invoice_date); 
         $new_invoice_date = date("Y-m-d 00:00:00", $timestamp );

         // convertir les dates ** invoice_date **
         $invoice_signature_date = $data->DO_Date;
         $timestamp = strtotime($invoice_signature_date); 
        $new_invoice_signature_date = date("Y-m-d 00:00:00", $timestamp );

        // convertir assigety a la TVA **
        
        $u = DB::table('CLIENTS')
          ->where('CT_Num',$data->DO_Tiers)
          
          ->get();


         /*       // convertir les donnees des clients  
              $ret=$u[0]->CT_Ape;
               if(empty($ret)) {
                   $TVA = '0';
               } else{
                $TVA = '1';
               };     */
    
    
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
          'customer_name' =>$data->DO_Ref,
     //   'customer_TIN' =>$u[0]->CT_Identifiant,
    //    'customer_address' =>$u[0]->CT_Adresse,
    //    'vat_customer_payer' =>$TVA,
          'customer_TIN' =>'',
          'customer_address' =>'',
          'vat_customer_payer' =>'',
          'cancelled_invoice_ref' =>'',
          'invoice_ref' => '',
          'cn_motif' => '',
          'invoice_signature'=>$data->E_Signature,
          'invoice_signature_date' =>$new_invoice_signature_date,
          'invoice_items' => $titi,
          'created_at' =>$currentDate,
          'updated_at' =>$currentDate,
          ///////////////////////////////
           'DO_Domaine'=>$data->DO_Domaine,
           'DO_Type'=>$data->DO_Type,
           'DO_Piece'=>$data->DO_Piece,
           'DO_Date'=>$data->DO_Date,
           'DO_Ref'=>$data->DO_Ref,
           'DO_Tiers'=>$data->DO_Tiers,
           'cbDO_Tiers'=>$data->cbDO_Tiers,
           'CO_No'=>$data->CO_No,
           'cbCO_No'=>$data->cbCO_No,
           'DO_Period'=>$data->DO_Period,
           'DO_Devise'=>$data->DO_Devise,
           'DO_Cours'=>$data->DO_Cours,
           'DE_No'=>$data->DE_No,
           'cbDE_No'=>$data->cbDE_No,
           'LI_No'=>$data->LI_No,
           'cbLI_No'=>$data->cbLI_No,
           'CT_NumPayeur'=>$data->CT_NumPayeur,
           'cbCT_NumPayeur'=>$data->cbCT_NumPayeur,
           'DO_Expedit'=>$data->DO_Expedit,
           'DO_NbFacture'=>$data->DO_NbFacture,
           'DO_BLFact'=>$data->DO_BLFact,
           'DO_TxEscompte'=>$data->DO_TxEscompte,
           'DO_Reliquat'=>$data->DO_Reliquat,
           'DO_Imprim'=>$data->DO_Imprim,
           'CA_Num'=>$data->CA_Num,
           'cbCA_Num'=>$data->cbCA_Num,
           'DO_Coord01'=>$data->DO_Coord01,
           'DO_Coord02'=>$data->DO_Coord02,
           'DO_Coord03'=>$data->DO_Coord03,
           'DO_Coord04'=>$data->DO_Coord04,
           'DO_Souche'=>$data->DO_Souche,
           'DO_DateLivr'=>$data->DO_DateLivr,
           'DO_Condition'=>$data->DO_Condition,
           'DO_Tarif'=>$data->DO_Tarif,
           'DO_Colisage'=>$data->DO_Colisage,
           'DO_TypeColis'=>$data->DO_TypeColis,
           'DO_Transaction'=>$data->DO_Transaction,
           'DO_Langue'=>$data->DO_Langue,
           'DO_Ecart'=>$data->DO_Ecart,
           'DO_Regime'=>$data->DO_Regime,
           'N_CatCompta'=>$data->N_CatCompta,
           'DO_Ventile'=>$data->DO_Ventile,
           'AB_No'=>$data->AB_No,
           'DO_DebutAbo'=>$data->DO_DebutAbo,
           'DO_FinAbo'=>$data->DO_FinAbo,
           'DO_DebutPeriod'=>$data->DO_DebutPeriod,
           'DO_FinPeriod'=>$data->DO_FinPeriod,
           'CG_Num'=>$data->CG_Num,
           'cbCG_Num'=>$data->cbCG_Num,
           'DO_Statut'=>$data->DO_Statut,
           'DO_Heure'=>$data->DO_Heure,
           'CA_No'=>$data->CA_No,
           'CO_NoCaissier'=>$data->CO_NoCaissier,
           'cbCO_NoCaissier'=>$data->cbCO_NoCaissier,
           'DO_Transfere'=>$data->DO_Transfere,
           'DO_Cloture'=>$data->DO_Cloture,
           'DO_NoWeb'=>$data->DO_NoWeb,
           'DO_Attente'=>$data->DO_Attente,
           'DO_Provenance'=>$data->DO_Provenance,
           'CA_NumIFRS'=>$data->CA_NumIFRS,
           'MR_No'=>$data->MR_No,
           'DO_TypeFrais'=>$data->DO_TypeFrais,
           'DO_ValFrais'=>$data->DO_ValFrais,
           'DO_TypeLigneFrais'=>$data->DO_TypeLigneFrais,
           'DO_TypeFranco'=>$data->DO_TypeFranco,
           'DO_ValFranco'=>$data->DO_ValFranco,
           'DO_TypeLigneFranco'=>$data->DO_TypeLigneFranco,
           'DO_Taxe1'=>$data->DO_Taxe1,
           'DO_TypeTaux1'=>$data->DO_TypeTaux1,
           'DO_TypeTaxe1'=>$data->DO_TypeTaxe1,
           'DO_Taxe2'=>$data->DO_Taxe2,
           'DO_TypeTaux2'=>$data->DO_TypeTaux2,
           'DO_TypeTaxe2'=>$data->DO_TypeTaxe2,
           'DO_Taxe3'=>$data->DO_Taxe3,
           'DO_TypeTaux3'=>$data->DO_TypeTaux3,
           'DO_TypeTaxe3'=>$data->DO_TypeTaxe3,
           'DO_MajCpta'=>$data->DO_MajCpta,
           'DO_Motif'=>$data->DO_Motif,
           'CT_NumCentrale'=>$data->CT_NumCentrale,
           'cbCT_NumCentrale'=>$data->cbCT_NumCentrale,
           'DO_Contact'=>$data->DO_Contact,
           'DO_FactureElec'=>$data->DO_FactureElec,
           'DO_TypeTransac'=>$data->DO_TypeTransac,
           'DO_DateLivrRealisee'=>$data->DO_DateLivrRealisee,
           'DO_DateExpedition'=>$data->DO_DateExpedition,
           'DO_FactureFrs'=>$data->DO_FactureFrs,
           'cbDO_FactureFrs'=>$data->cbDO_FactureFrs,
           'DO_PieceOrig'=>$data->DO_PieceOrig,
           'DO_GUID'=>$data->DO_GUID,
           'DO_EStatut'=>$data->DO_EStatut,
           'DO_DemandeRegul'=>$data->DO_DemandeRegul,
           'ET_No'=>$data->ET_No,
           'cbET_No'=>$data->cbET_No,
           'DO_Valide'=>$data->DO_Valide,
           'DO_Coffre'=>$data->DO_Coffre,
           'DO_CodeTaxe1'=>$data->DO_CodeTaxe1,
           'DO_CodeTaxe2'=>$data->DO_CodeTaxe2,
           'DO_CodeTaxe3'=>$data->DO_CodeTaxe3,
           'DO_TotalHT'=>$data->DO_TotalHT,
           'DO_StatutBAP'=>$data->DO_StatutBAP,
           'cbProt'=>$data->cbProt,
           'cbMarq'=>$data->cbMarq,
           'cbCreateur'=>$data->cbCreateur,
           'cbModification'=>$data->cbModification,
           'cbReplication'=>$data->cbReplication,
           'cbFlag'=>$data->cbFlag,
           'cbCreation'=>$data->cbCreation,
           'cbCreationUser'=>$data->cbCreationUser,
           'DO_Escompte'=>$data->DO_Escompte,
           'DO_DocType'=>$data->DO_DocType,
           'DO_TypeCalcul'=>$data->DO_TypeCalcul,
           'DO_FactureFile'=>$data->DO_FactureFile,
           'DO_TotalHTNet'=>$data->DO_TotalHTNet,
           'DO_TotalTTC'=>$data->DO_TotalTTC,
           'DO_NetAPayer'=>$data->DO_NetAPayer,
           'DO_MontantRegle'=>$data->DO_MontantRegle,
           'DO_RefPaiement'=>$data->DO_RefPaiement,
           'DO_AdressePaiement'=>$data->DO_AdressePaiement,
           'DO_PaiementLigne'=>$data->DO_PaiementLigne,
           'DO_MotifDevis'=>$data->DO_MotifDevis,
           'DO_Conversion'=>$data->DO_Conversion,
            //'cbHash'=>$data->cbHash,
           'cbHashVersion'=>$data->cbHashVersion,
           'cbHashDate'=>$data->cbHashDate,
           'cbHashOrder'=>$data->cbHashOrder,
           'cbDO_Piece'=>$data->cbDO_Piece,
           'cbCA_No'=>$data->cbCA_No,
           'cbDO_PieceOrig'=>$data->cbDO_PieceOrig,
           'E_Signature'=>$data->E_Signature,
             );



  //  ********************************URL******************************************************  //  
             $res = Http::post('https://ebms.obr.gov.bi:8443/ebms_api/login/', [

              'username'=> 'the username',  // ici il faudra mettre le username delivre par l'OBR
              'password'=> 'the password',  // ici il faudra mettre le mot de passe delivre par l'OBR
             
              ]);

           $json= json_decode($res->getBody());
           $token = $json->result->token;
           //var_dump($token);
           //echo $token;
           
           // echo $json[0]['token'];
           // var_dump($response);

            $response = Http::withHeaders([
          'Authorization' => 'Bearer '.$token
           ])->post("https://ebms.obr.gov.bi:8443/ebms_api/addInvoice/", [ 


       //     $response = Http::post("http://127.0.0.1:8002/api/add/create", [
    
          'invoice_number'=>$data->DO_Piece,
          'invoice_date'  =>$new_invoice_date,
          'invoice_type' => 'FN',
          'tp_type'=>'2',
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
          'customer_name' =>$data->DO_Ref,
     //   'customer_TIN' =>$u[0]->CT_Identifiant,
    //    'customer_address' =>$u[0]->CT_Adresse,
    //    'vat_customer_payer' =>$TVA,
          'customer_TIN' =>'',
          'customer_address' =>'',
          'vat_customer_payer' =>'',
          'cancelled_invoice_ref' =>'',
          'invoice_ref' => '',
          'cn_motif' => '',

          'invoice_signature'=>$data->E_Signature,
          'invoice_signature_date' =>$new_invoice_signature_date,
          'invoice_items' => $dedee,        


        ]);

  //  ******************************URL********************************************************  //  
                  //php artisan schedule:work
                

          DB::table('sendeds')->insert($getClient[0]);
        DB::table('ENTETE_FACTURE')->where('DO_Date',$currentDate)->delete();
           }


      }
    }

}
