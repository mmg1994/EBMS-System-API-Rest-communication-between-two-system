
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 5.8 - Daterange Filter in Datatables with Server-side Processing</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
 </head>
 <body>

  <div class="container">    
     <br />
     <h3 align="center">liste des factures à envoyer</h3>
     <br />
            <br />
            <h4>Search NIF</h4><hr>
             <form action="{{ route('web.finder') }}" method="POST">
       
                <div class="form-group">
                   <label for="">Enter NIF</label>
                   <input type="text" class="form-control" name="query" placeholder="Search here....." value="{{ request()->input('query') }}">
                   <span class="text-danger">@error('query'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                 <button type="submit" class="btn btn-primary">Search</button>
                </div>
             </form>
            <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="order_table">
           <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Date</th>
                  
            </tr>
           </thead>
       </table>
   </div>

   <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST" id="sample_form" class="form-horizontal">
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

 function load_data(query = '')
 {
  $('#order_table').DataTable({
   processing: true,
   serverSide: true,
   type: 'post'
   ajax: {
    url:'{{ route("web.finder") }}',
    nif:{query:query}
   },
   columns: [
    {nif:'invoice_number', name:'invoice_number'},
    { nif:'invoice_number',name:'invoice_number'},
    {nif:'invoice_number',name:'invoice_number'},
    
    ]
  });
 }


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
        if(confirm("Are you sure you want to send this data?"))
        {
            $('.users_checkbox:checked').each(function(){
                E_Signature.push($(this).val());
            });
            if(E_Signature.length > 0)
            {
                $.ajax({
                    url:"{{ route('users.removeall')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"POST",
                    data:{E_Signature:E_Signature},
                    success:function(data)
                    {
                        console.log(data);
                        alert("factures bien envoyer dans OBR");
                        window.location.assign("/date"); 
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
