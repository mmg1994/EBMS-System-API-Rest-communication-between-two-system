@if (count($status))
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-academic-report" id="list-student-report" style="font-size:11pt;border-collapse:collapse;">
            <thead class="th">

            <tr>
                <th style="background: #f5f5f5;text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">N<sup>0</sup></th>
                <th style="background: #f5f5f5;text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">ID</th>
                <th style="background: #f5f5f5;text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">khmer Name</th>
                <th style="background: #f5f5f5;text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">English Name</th>
                <th style="background: #f5f5f5;text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">Sex</th>
                <th style="background: #f5f5f5;text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">Birth Date</th>
                <th style="background: #f5f5f5;text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($status as $key => $st)

         <tr>
            <td style="vertical-align: middle; text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">{!!++$key!!}</td>
            <td style="vertical-align: middle; text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">{!!$st->StudentID!!}</td>
            <td style="vertical-align: middle; text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">{!!$st->StudentID!!}</td>
            <td style="vertical-align: middle; text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">{!!$st->StudentID!!}</td>
            <td style="vertical-align: middle; text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">{!!$st->StudentID!!}</td>
            <td style="vertical-align: middle; text-align: left;border:0.5pt solid #ada5a5;font-family:'Century'">{!!$st->StudentID!!}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="background: #f3f3f3; text-align: left;border:0.5pt solid #ada5a5;font-weight: bold;">Number:{!!count($status)!!}</td>
            </tr>
        </tfoot>
        </table>
</div>
</div>
</div>

@endif