<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class getClients extends Model
{
    protected $table ='CLIENTS';
    //protected  $primaryKey = 'CT_Num';
    protected $fillable = [
        'CT_Num',
        'CT_Intitule',
        'CT_Type',
    
    ];
public function allDate(){

    


    return DB::table('CLIENTS')
    ->leftJoin('ENTETE_FACTURE', 'ENTETE_FACTURE.DO_Tiers', '=', 'CLIENTS.CT_Num')
   // ->leftJoin('ENTETE_FACTURE', 'ENTETE_FACTURE.DO_Tiers', '=', 'CLIENTS.CT_Num')
    ->get('CT_Num');


}

public function allDa(){

    return DB::table('ENTETE_FACTURE')
    ->leftJoin('CLIENTS', 'CLIENTS.CT_Num', '=', 'ENTETE_FACTURE.DO_Tiers')
   // ->leftJoin('ENTETE_FACTURE', 'ENTETE_FACTURE.DO_Tiers', '=', 'CLIENTS.CT_Num')
    ->get(
        
        'DO_Type'


);}
    

          

   /* use HasFactory;
    protected $table ='CLIENTS';
   // protected $table = 'DETAIL_FACTURE';
    protected $fillable = [
        'CT_Num',
        'CT_Intitule',
        'CT_Type',
    ];*/


}
