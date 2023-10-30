@extends('admin.layouts')
@section('content')


<div class="container">
    <div class="panel panel-default">

    <div class="panel-body" style="padding-top:6px;">
    <div class="row">
        <div class="col-md-3">
        <div class="form-group">
            <label for="Academic">Academic year</label>
            {!!form::select(AcademicID, $academics, null,['class=>'form-control', 'id'=>'AcademicID'])!!}
        </div>
        </div>

        <div class="col-md-3">
        <div class="form-group">
                <label>From</label>
                <input type="text" name="StartDate" id="StartDate" class="form-control" required>
        </div>
        </div>
           
        
        <div class="col-md-3">
        <div class="form-group">
                <label>From</label>
                <input type="text" name="EndDate" id="EndDate" class="form-control" required>
        </div>
        </div>
    
    </div>
    </div>
    </div>
    <div class="list-student-report"></div>
</div>
@endsection

@section('script')
<script type="text/javascript">

$('#startDate').datapicker({
        changeMonth: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1970:+0',
        dateFormat: 'yy/mm/dd',
        onSelect: function(dataText){
            var DateRegistered = $('#StartDate').val();
            var EndDate = $('#EndDate').val();
            var AcademicID = $('#AcademicID').val();
            listStudent(DateRegistered,EndDate,AcademicID);
        }
    });


$('#EndDate').datapicker({
        changeMonth: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1970:+0',
        dateFormat: 'yy/mm/dd',
        onSelect: function(dataText){
            var DateRegistered = $('#StartDate').val();
            var EndDate = $('#EndDate').val();
            var AcademicID = $('#AcademicID').val();
            listStudent(DateRegistered,EndDate,AcademicID);
        }
    });

function listStudent(criteria1, criteria2, criteria3)
{
    $.ajax({
                type:'get',
                url:"{!!url('report-list-student')!!}",
                data : {DateRegistrered:criteria1, EndDate:criteria2, AcademicID:criteria3},
                success:function(data)
                    {
                          $('.list-student-report').empty().html(data);
                    }
    })
}

$(".excel").click(function(){
    $("#list-student-report").table2excel({
        exclude: ".noExl",
        name:"Excel Document Name",
        filename: currentDate(),
        fileext:".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true
    });
});

</Script>


@endsection   