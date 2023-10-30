<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Delete Multiple Data using Checkbox with Datatables Yajra Server Side</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
<div class="row">
        <div class="col-12 table-responsive">
        <br />
        <h3 align="center">Liste des Factures</h3>
        <br />
    <!--    <div align="right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success"> <i class="bi bi-plus-square"></i> Add</button>
        </div>  -->
        <br />



		<form action="{{ route('form/report') }}" method ="POST">
        {{ csrf_field() }}
			<br>
			<div class="container">
				<div class="row">
					<div class="container-fluid">


						<div class="form-group row">
							<label for="date" class="col-form-label col-sm-2">From</label>
							<div class="col-sm-3">
								<input type="date" class="form-control input-sm" id="fromdate" name="fdate" >
							</div>
						</div>

						<div class="form-group row">
							<label for="date" class="col-form-label col-sm-2">To</label>
							<div class="col-sm-3">
								<input type="date" class="form-control input-sm" id="todate" name="sdate" >
							</div>
						</div>


                        <div class="form-group row">

                                <div class="col-sm-2">
                                    <button type="submit"  value="Submit" class="btn btn-success  waves-light" name="search"  title="Search"> search</button>
                                </div>
                            </div>
					    </div>

				</div>
			</div>
			<br>
		</form>





            <table class="table table-striped table-bordered user_datatable"> 
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th width="180px">Action</th>
                        <th width="50px"><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">Delete</button></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
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
<script type="text/javascript">
$(document).ready(function() {
    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('form/users') }}",
        columns: [
            {data: 'DO_Piece', name: 'id'},
            {data: 'DO_Piece', name: 'name'},
            {data: 'DO_Date', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},

            /* {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false}, */



            /* 'CLIENTS.CT_Intitule',
               'ENTETE_FACTURE.DO_Piece',
               'ENTETE_FACTURE.DO_Type',
               'ENTETE_FACTURE.DO_Date */
        ]
    });
 
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
        if(confirm("Are you sure you want to Delete this data?"))
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
                    success:function(data)
                    {
                        console.log(data);
                        alert("donnees bien envoyer dans OBR");
                        window.location.assign("users"); 
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
 
});
</script>
</html>