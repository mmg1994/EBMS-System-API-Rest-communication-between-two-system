<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendeds', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('invoice_type')->nullable();
            $table->string('tp_type')->nullable();
            $table->string('tp_name')->nullable();
            $table->string('tp_TIN')->nullable();
            $table->string('tp_trade_number')->nullable();
            $table->string('tp_postal_number')->nullable();
            $table->string('tp_phone_number')->nullable();
            $table->string('tp_address_province')->nullable();
            $table->string('tp_address_commune')->nullable();
            $table->string('tp_address_quartier')->nullable();
            $table->string('tp_address_avenue')->nullable();
            $table->string('tp_address_number')->nullable();
            $table->string('vat_taxpayer')->nullable();
            $table->string('ct_taxpayer')->nullable();
            $table->string('tl_taxpayer')->nullable();
            $table->string('tp_fiscal_center')->nullable();
            $table->string('tp_activity_sector')->nullable();
            $table->string('tp_legal_form')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('invoice_currency')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_TIN')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('vat_customer_payer')->nullable();
            $table->string('cancelled_invoice_ref')->nullable();
            $table->string('invoice_ref')->nullable();
            $table->string('cn_motif')->nullable();
            $table->string('invoice_signature')->nullable();
            $table->string('invoice_signature_date')->nullable();
            $table->json('invoice_items')->nullable();
            
            
    ////////////////////////////////////////////////////////////////////////////////////////////        
            $table->string('DO_Domaine')->nullable();
            $table->string('DO_Type')->nullable();
            $table->string('DO_Piece')->nullable();
            $table->string('DO_Date')->nullable();
            $table->string('DO_Ref')->nullable();
            $table->string('DO_Tiers')->nullable();
            $table->string('cbDO_Tiers')->nullable();
            $table->string('CO_No')->nullable();
            $table->string('cbCO_No')->nullable();
            $table->string('DO_Period')->nullable();
            $table->string('DO_Devise')->nullable();
            $table->string('DO_Cours')->nullable();
            $table->string('DE_No')->nullable();
            $table->string('cbDE_No')->nullable();
            $table->string('LI_No')->nullable();
            $table->string('cbLI_No')->nullable();
            $table->string('CT_NumPayeur')->nullable();
            $table->string('cbCT_NumPayeur')->nullable();
            $table->string('DO_Expedit')->nullable();
            $table->string('DO_NbFacture')->nullable();
            $table->string('DO_BLFact')->nullable();
            $table->string('DO_TxEscompte')->nullable();
            $table->string('DO_Reliquat')->nullable();
            $table->string('DO_Imprim')->nullable();
            $table->string('CA_Num')->nullable();
            $table->string('cbCA_Num')->nullable();
            $table->string('DO_Coord01')->nullable();
            $table->string('DO_Coord02')->nullable();
            $table->string('DO_Coord03')->nullable();
            $table->string('DO_Coord04')->nullable();
            $table->string('DO_Souche')->nullable();
            $table->string('DO_DateLivr')->nullable();
            $table->string('DO_Condition')->nullable();
            $table->string('DO_Tarif')->nullable();
            $table->string('DO_Colisage')->nullable();
            $table->string('DO_TypeColis')->nullable();
            $table->string('DO_Transaction')->nullable();
            $table->string('DO_Langue')->nullable();
            $table->string('DO_Ecart')->nullable();
            $table->string('DO_Regime')->nullable();
            $table->string('N_CatCompta')->nullable();
            $table->string('DO_Ventile')->nullable();
            $table->string('AB_No')->nullable();
            $table->string('DO_DebutAbo')->nullable();
            $table->string('DO_FinAbo')->nullable();
            $table->string('DO_DebutPeriod')->nullable();
            $table->string('DO_FinPeriod')->nullable();
            $table->string('CG_Num')->nullable();
            $table->string('cbCG_Num')->nullable();
            $table->string('DO_Statut')->nullable();
            $table->string('DO_Heure')->nullable();
            $table->string('CA_No')->nullable();
            $table->string('CO_NoCaissier')->nullable();
            $table->string('cbCO_NoCaissier')->nullable();
            $table->string('DO_Transfere')->nullable();
            $table->string('DO_Cloture')->nullable();
            $table->string('DO_NoWeb')->nullable();
            $table->string('DO_Attente')->nullable();
            $table->string('DO_Provenance')->nullable();
            $table->string('CA_NumIFRS')->nullable();
            $table->string('MR_No')->nullable();
            $table->string('DO_TypeFrais')->nullable();
            $table->string('DO_ValFrais')->nullable();
            $table->string('DO_TypeLigneFrais')->nullable();
            $table->string('DO_TypeFranco')->nullable();
            $table->string('DO_ValFranco')->nullable();
            $table->string('DO_TypeLigneFranco')->nullable();
            $table->string('DO_Taxe1')->nullable();
            $table->string('DO_TypeTaux1')->nullable();
            $table->string('DO_TypeTaxe1')->nullable();
            $table->string('DO_Taxe2')->nullable();
            $table->string('DO_TypeTaux2')->nullable();
            $table->string('DO_TypeTaxe2')->nullable();
            $table->string('DO_Taxe3')->nullable();
            $table->string('DO_TypeTaux3')->nullable();
            $table->string('DO_TypeTaxe3')->nullable();
            $table->string('DO_MajCpta')->nullable();
            $table->string('DO_Motif')->nullable();
            $table->string('CT_NumCentrale')->nullable();
            $table->string('cbCT_NumCentrale')->nullable();
            $table->string('DO_Contact')->nullable();
            $table->string('DO_FactureElec')->nullable();
            $table->string('DO_TypeTransac')->nullable();
            $table->string('DO_DateLivrRealisee')->nullable();
            $table->string('DO_DateExpedition')->nullable();
            $table->string('DO_FactureFrs')->nullable();
            $table->string('cbDO_FactureFrs')->nullable();
            $table->string('DO_PieceOrig')->nullable();
            $table->string('DO_GUID')->nullable();
            $table->string('DO_EStatut')->nullable();
            $table->string('DO_DemandeRegul')->nullable();
            $table->string('ET_No')->nullable();
            $table->string('cbET_No')->nullable();
            $table->string('DO_Valide')->nullable();
            $table->string('DO_Coffre')->nullable();
            $table->string('DO_CodeTaxe1')->nullable();
            $table->string('DO_CodeTaxe2')->nullable();
            $table->string('DO_CodeTaxe3')->nullable();
            $table->string('DO_TotalHT')->nullable();
            $table->string('DO_StatutBAP')->nullable();
            $table->string('cbProt')->nullable();
            $table->string('cbMarq')->nullable();
            $table->string('cbCreateur')->nullable();
            $table->string('cbModification')->nullable();
            $table->string('cbReplication')->nullable();
            $table->string('cbFlag')->nullable();
            $table->string('cbCreation')->nullable();
            $table->string('cbCreationUser')->nullable();
            $table->string('DO_Escompte')->nullable();
            $table->string('DO_DocType')->nullable();
            $table->string('DO_TypeCalcul')->nullable();
            $table->string('DO_FactureFile')->nullable();
            $table->string('DO_TotalHTNet')->nullable();
            $table->string('DO_TotalTTC')->nullable();
            $table->string('DO_NetAPayer')->nullable();
            $table->string('DO_MontantRegle')->nullable();
            $table->string('DO_RefPaiement')->nullable();
            $table->string('DO_AdressePaiement')->nullable();
            $table->string('DO_PaiementLigne')->nullable();
            $table->string('DO_MotifDevis')->nullable();
            $table->string('DO_Conversion')->nullable();
            $table->string('cbHash')->nullable();
            $table->string('cbHashVersion')->nullable();
            $table->string('cbHashDate')->nullable();
            $table->string('cbHashOrder')->nullable();
            $table->string('cbDO_Piece')->nullable();
            $table->string('cbCA_No')->nullable();
            $table->string('cbDO_PieceOrig')->nullable();
            $table->string('E_Signature')->nullable();
//////////////////////////////////////////////////////////////////////////////////////////////////////
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sendeds');
    }
}