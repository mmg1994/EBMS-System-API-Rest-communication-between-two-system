@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')


 <body>

  <div class="col-lg-9 mx-auto" >    
     <br />
     <h2 align="center">liste des factures dejà envoyer</h2><hr>
     <br />
            
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                </div>
            </div>
            <br />
   <div class="table-responsive" >
    <table class="table table-bordered table-striped" id="order_table">
           <thead>
            <tr>
               <!-- <th>Order ID</th> -->
                <th>Invoice Number</th>
                <th>Customer</th>
                <th style=" width:200px">Enter Date</th>
                <th >Invoice Signature</th>
             <!--   <th width="180px">Action</th>  
               <th width="50px"><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">send to OBR</button></th>
               -->
                    
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
</html>

<script>
$(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });

 load_data();

 function load_data(from_date = '', to_date = '')
 {
  $('#order_table').DataTable({
   processing: true,
   serverSide: true,
   ajax: {
    url:'{{ route("/datee") }}',
    data:{from_date:from_date, to_date:to_date}
   },
   columns: [
  //  {data:'DO_Piece', name:'order_id'},
    { data:'invoice_number',name:'Invoice Number'},
    { data:'customer_name',name:'Customer'},
    {data:'updated_at',name:'enter_date'},
    {data:'invoice_signature',name:'Invoice_Signature'},
   // {data: 'action', name: 'action', orderable: false, searchable: false},
   // {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},
    
    ],
    "aLengthMenu": [[5, 10, 20], [5, 10, 20]],
    "pageLength": 10,
    "searching": false
  });
 }


 var user_id;
  
  $(document).on('click', '.delete', function(){
      user_id = $(this).attr('phone');
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
        if(confirm("Are you sure you want to send this data?"))
        {
            $('.users_checkbox:checked').each(function(){
                E_Signature.push($(this).val());
            });
            if(E_Signature.length > 0)
            {
                $.ajax({
                    url:"{{ route('users.removealle')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"get",
                    data:{E_Signature:E_Signature},
                    success:function(data)
                    {
                        console.log(data);
                        alert("factures bien envoyer dans OBR");
                        window.location.assign("/datee"); 
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            }
            else
            {
                alert("Please select atleast one checkbox");
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
   alert('Both Date is required');
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