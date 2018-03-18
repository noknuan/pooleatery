<h2 class="page-header">Daily Summary Report</h2>
<div class="row">
    <div class="col-sm-3 form-group">
        <div class='input-group date'>
<span class="input-group-addon">
<i class="glyphicon glyphicon-calendar"></i>
</span>
            <input type='text' class="form-control" value="{{date('d-M-Y',strtotime(Session::get('report_from')))}}"
                   id="report_from"/>
        </div>
    </div>
    <div class="form-group col-sm-3">
        <a href="javascript:window.open('report/print-daily-summary?report_from='+$('#report_from').val(),'_blank');"
           class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Print</a>
    </div>
</div>
<h2 style="text-align: center;padding: 10px;background: whitesmoke">
     {{number_format($orders['Total']['total'],2)}} บาท</h2>
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
            <tr bgcolor="#a9a9a9">
                <th style="text-align: center">Category</th>
                <th style="text-align: center">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sale as $key=>$value)
                @if($key!='Total')
                    <tr style="font-size: 14px">
                        <td>{{$key}}</td>
                        <td align="right"> {{number_format($value['total'],2)}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
            <tr style="font-size:14px" bgcolor="#a9a9a9" >
                <th style="text-align: center">Period</th>
                <th style="text-align: center">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $key=>$value)
                @if($key!='Total')
                    <tr style="font-size: 14px">
                        <td>{{$key}}</td>
                        <td align="right"> {{number_format($value['total'],2)}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    var old_date = $('#report_from').val();
    $('#report_from').pickadate({
        format: "dd-mmm-yyyy",
        selectMonths: true,
        selectYears: true,
        onOpen: function () {
            old_date = $('#report_from').val();
        },
        onClose: function () {
            if (this.get('select', 'dd-mmm-yyyy') != old_date)
                ajaxLoad('report/daily-summary?report_from=' + this.get('select', 'yyyy-mm-dd'));
        }
    });
</script>