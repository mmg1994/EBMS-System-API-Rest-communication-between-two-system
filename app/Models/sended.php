<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Attribute;

class sended extends Model
{
    use HasFactory;
    public $timestamps = true;

   



    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'invoice_type',
        'tp_type',
        'tp_name',
        'tp_TIN',
        'tp_trade_number',
        'tp_postal_number',
        'tp_phone_number',
        'tp_address_province',
        'tp_address_commune',
        'tp_address_quartier',
        'tp_address_avenue',
        'tp_address_number',
        'vat_taxpayer',
        'ct_taxpayer',
        'tl_taxpayer',
        'tp_fiscal_center',
        'tp_activity_sector',
        'tp_legal_form',
        'payment_type',
       'invoice_currency',
        'customer_name',
        'customer_TIN',
        'customer_address',
        'vat_customer_payer',
        'cancelled_invoice_ref',
        'invoice_ref',
        'cn_motif',
        'invoice_signature',
        'invoice_signature_date',
        'invoice_items',
        'created_at'
    ];


}
