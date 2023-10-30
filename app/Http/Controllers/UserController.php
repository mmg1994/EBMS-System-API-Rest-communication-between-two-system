<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\DB;



use App\Models\User;
use App\Http\Controllers\Controller;

use App\Models\getInvoice;
use App\Models\getClients;

use App\Models\getdetails_facture;
use App\Models\Personal;


use DataTables;


class UserController extends Controller
{
    
   
    public function index(Request $request)
    {
     
        if(request()->ajax())
        {
         if(!empty($request->from_date))
         {
          $data = DB::table('sendeds')
            ->whereBetween('created_at', array($request->from_date, $request->to_date))
            ->get();
         }
         else
         {
          $data = DB::table('sendeds')->orderBy('created_at', 'desc')
            ->get();
         }
         return datatables()->of($data)
         ->addIndexColumn()
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->invoice_date.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                    $button .= '   <button type="button" name="edit" id="'.$data->invoice_date.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $button;
                })
               // ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />')
               ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$invoice_date}}" />') 
               ->rawColumns(['checkbox','action'])
         ->make(true);
        }
        return view('report/dejaenvoyer');
       

    }  
 
    public function destroy($E_Signature)
    {
       // $data = User::findOrFail($E_Signature);
       $data = DB::table('ENTETE_FACTURE')
                ->findOrFail($E_Signature);
        $data->delete();
    }

/* 

    function removeall(Request $request)
    {
        $user_id_array = $request->input('E_Signature');
       // $user = User::whereIn('id', $user_id_array);

       $user = DB::table('ENTETE_FACTURE')
              // ->join('ENTETE_FACTURE', 'CLIENTS.CT_Num' , '=', 'ENTETE_FACTURE.DO_Tiers')
               ->join('DETAILS_FACTURE', 'ENTETE_FACTURE.DO_Tiers' , '=', 'DETAILS_FACTURE.CT_Num')
                ->select(
                                  

                         )
                 ->whereIn('E_Signature', $user_id_array)
                 ->get();



                                  $getClient=array();
                                  foreach($user as $user){
                                    $getClient[]=array(

                                        'tp_name'=>$user->DO_Piece,
                                        'tp_TIN'=>$user->DO_Piece,
                                      //--------------------------------
                                    );

                        }
                      $rr=  Personal::create([
                            'username'=> $user->DO_Piece,
                            'email' => $user->DO_Piece,
                            'phone'  => $user->CT_Num,
                            
                        ]);
                
        if($rr->create())
        {
            echo 'Data Deleted';
        }
    }*/



    /*$data = array();
$data['created_at'] =new \DateTime();
DB::table('practice')->insert($data); 
*/

Public function removeall(Request $request)
{
    $Invoice_signature = $request->input('E_Signature');
    if(!empty($Invoice_signature)){

       
    foreach ($Invoice_signature as $key => $value ){
        $user = DB::table('ENTETE_FACTURE')
        //  ->join('CLIENTS', 'ENTETE_FACTURE.DO_Tiers' , '=', 'CLIENTS.CT_Num')
       //   ->join('DETAILS_FACTURE', 'ENTETE_FACTURE.DO_Tiers' , '=', 'DETAILS_FACTURE.CT_Num')
          ->whereIn('E_Signature',$request->input('E_Signature'))
          ->get();

          $user_id_array =array();


     
          foreach($user as $user){
            $user_id_array[]=array(
                'phone'  =>$user->E_Signature,
                'email'=>$user->DO_Tiers,
                'username'=>$user->DO_Ref,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
        };

      

    }      

    
  //  DB::table('personals')->insert($user_id_array);
    
    

    }else{
        $checkbox = '';
        }
        return redirect()->back();
    }



    /*    function removeall(Request $request)
    {
        $user_id_array = $request->input('E_Signature');
       // $user = User::whereIn('id', $user_id_array);

       $user = DB::table('ENTETE_FACTURE')
                ->whereIn('E_Signature', $user_id_array);
        if($user->delete())
        {
            echo 'Data Deleted';
        }
    } */
 

}