@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')


 
 <body>

  <div class="col-lg-9 mx-auto" >    
     <br />
     <h2 align="center">liste des factures à envoyer</h2><hr>
     <br />
     @csrf

     
     <!--<input type="text" id="fname" name="fname"><br><br> -->
    
            <div class="row input-daterange">

                <div class="col-md-2">
                     <select name="fetchval" id="fetchval">
                        <option value=""></option>
                        
                        <option value="PFSUC" id="PFSUC">PFSUC</option>
                        <option value="PFSUCIMP" id="PFSUCIMP">PFSUCIMP</option>
                        <option value="BD20L" id="BD20L">BD20L</option>

                        <option value="HUILE-MOT" id="HUILE-MOT">HUILE-MOT</option>
                        <option value="COUV_MET" id="COUV_MET">COUV_MET</option>
                        <option value="TCOM" id="TCOM">TCOM</option>
                        <option value="BAT-USAGER" id="BAT-USAGER">BAT-USAGER</option>
                        <option value="LOYER" id="LOYER">LOYER</option>
                        <option value="LTERRE" id="LTERRE">LTERRE</option>
                        <option value="PROF_PFSUC" id="PROF_PFSUC">PROF_PFSUC</option>
                        <option value="PROF_SUC" id="PROF_SUC">PROF_SUC</option>
                        <option value="PROF_VT_SUC_BUJA" id="PROF_VT_SUC_BUJA">PROF_VT_SUC_BUJA</option>
                        <option value="PALRECUP" id="PALRECUP">PALRECUP</option>
                        <option value="BID20L" id="BID20L">BID20L</option>
                        <option value="COVOITURE" id="COVOITURE">COVOITURE</option>
                        <option value="PFAIR" id="PFAIR">PFAIR</option>
                        <option value="MELAS" id="MELAS">MELAS</option>
                        <option value="FUT200LM" id="FUT200LM">FUT200LM</option>
                        <option value="GIT" id="GIT">GIT</option>
                        <option value="TCONSO" id="TCONSO">TCONSO</option>
                        <option value="FRD" id="FRD">FRD</option>
                        <option value="BD50L" id="BD50L">BD50L</option>
                        <option value="1ESSENCEM3___" id="1ESSENCEM3___">1ESSENCEM3___</option>
                        <option value="FT" id="FT">FT</option>
                        <option value="FUT200P" id="FUT200P">FUT200P</option>
                        <option value="DECH_CHARB" id="DECH_CHARB">DECH_CHARB</option>
                        <option value="PISC" id="PISC">PISC</option>
                        <option value="COFUSO" id="COFUSO">COFUSO</option>
                        <option value="TUYUSAGED400MM" id="TUYUSAGED400MM">TUYUSAGED400MM</option>
                        <option value="PN-USEE" id="PN-USEE">PN-USEE</option>
                        <option value="RABOT" id="RABOT">RABOT</option>

                    </select>
                </div>

               
                
                
                <div class="col-md-3">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col-md-3">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                </div>
                


                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-primary">Refresh</button>
                    <button type="button" name="bulk_delete" id="bulk_delete" style="padding_left: 20px" class="btn btn-danger btn-xs">send to OBR</button>
                </div>
            </div>
            <br />
   <div class="table-responsive" >
   <div id="loader" class="modal-dialog" style="display: none; height: 100px;
  width: 100px; position:center; margin_left: 50px; top: 0px; z-index: 99999; ">
     <img src='/assets/image/loading.gif' style=" background-color: #555;  height: 100px;
  width: 100px; position:center; margin_left: 50px; top: 0px; z-index: 99999; "> <b> loading..</b>
    </div>
    <table class="table table-bordered table-striped" id="order_table">
           <thead>
            <tr>
               <!-- <th>Order ID</th> -->
                <th>Invoice Number</th>
                <th>Customer</th>
                <th>Enter Date</th>
                <th >Invoice Signature</th>
             <!--   <th width="180px">Action</th>  -->
             <th><input type="checkbox" id="master" ></th>
                
            </tr>
           </thead>
       </table>
   </div>

   <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
            </div>
        </form>  
        </div>
        </div>
    </div>

  </div>
 </body>
 <script>
  src="https://code.jquery.com/jquery-3.6.4.min.js"</script>
<script>
$(document).ready(function(){

// select all

    $(function(e){

    $("#master").click(function(){
        $('.users_checkbox').prop('checked',$(this).prop('checked'));

    });

    });




 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });




 // -------------------------------------------------------------------------------------

 load_data();

 function load_data(from_date = '', to_date = '')
 {
  $('#order_table').DataTable({
   processing: true,
   serverSide: true,
   ajax: {
    url:'{{ route("/date") }}',
    data:{from_date:from_date, to_date:to_date}
   },
   columns: [
  //  {data:'DO_Piece', name:'order_id'},
    { data:'DO_Piece',name:'Invoice Number'},
    { data:'DO_Ref',name:'Customer'},
    {data:'DO_Date',name:'enter_date'},
    {data:'E_Signature',name:'Invoice_Signature'},
   // {data: 'action', name: 'action', orderable: false, searchable: false},
    {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},
    
    ],
    "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
    "pageLength": 10,
    "searching": false
  });
 }


// ----------------------------------------------------------------------------
//--------------------------------assigeti---------------------------------------------





$("#fetchval").on('change', function(){
    var selectedValue = $(this).val();
   // alert(value);

   $('#order_table').DataTable({
    "bDestroy": true,
   ajax: {
   // type: 'GET',
    url:'{{ route("/assigeti") }}',
    data:{selectedValue:selectedValue},
   },
   
   columns: [
  //  {data:'DO_Piece', name:'order_id'},
  { data:'DO_Piece',name:'Invoice Number'},
    { data:'DO_Ref',name:'Customer'},
    {data:'DO_Date',name:'enter_date'},
    {data:'E_Signature',name:'Invoice_Signature'},
   // {data: 'action', name: 'action', orderable: false, searchable: false},
    {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},
    
    ],
    "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
    "pageLength": 10,
    "searching": false
  }).fnDestroy();
});


     
// ----------------------------------------------------------------------------
//-----------------------------------------------------------------------------




 var user_id;
  
  $(document).on('click', '.delete', function(){
      user_id = $(this).attr('E_Signature');
      $('#confirmModal').modal('show');
  });


  $('#ok_button').click(function(){
        $.ajax({
            url:"users/destroy/"+user_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#user_table').DataTable().ajax.reload();
                alert('Data Deleted');
                }, 2000);
            }
        })
    });

    $(document).on('click', '#bulk_delete', function(){
        var E_Signature = [];
        if(confirm("Êtes-vous sûr de vouloir envoyer ces données ?"))
        {
            $('.users_checkbox:checked').each(function(){
                E_Signature.push($(this).val());
            });
            if(E_Signature.length > 0)
            {
                
                $.ajax({

                    url:"{{ route('users.removeall')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"get",
                    data:{E_Signature:E_Signature},    
                    
                    beforeSend: function(){
                        $('#loader').show();
                    },

                    success:function(data)
                    {
                        
                        console.log(data);
                        alert(data.msg);
                      //  alert(data.message);
                        //alert("factures bien envoyer dans OBR");
                        window.location.assign("/date"); 
                    },
                    complete: function(){
                        $('#loader').hide();
                    },
                    error: function(xhr, status, error) {
                       // var errors = data.responseJSON;
                       // console.log(errors);
                     //  console.log(data);
                      // alert("une erreur est survenue lors de l'envoi");
                     // console.log(errors);
                     // alert(errors.file);
                     alert(xhr.responseText);
                       window.location.assign("/date"); 
                    }
                });
            }
            else
            {
                alert("Veuillez cocher au moins une case");
                window.location.assign("/date"); 
            }
        }
    });



 $('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date != '' &&  to_date != '')
  {
   $('#order_table').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Les deux dates sont requises');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#order_table').DataTable().destroy();
  load_data();
 });

});
</script>
@endsection   

