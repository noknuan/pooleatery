<style>
    * {
        font-family: DejaVu Sans !important;
    }

    .page-break {
        page-break-after: always;
    }
</style>
<center>
    <h1 style="font-size:20px;margin:0">The Pool Eatery</h1>
    <h4 style="margin: 0">Daily Summary Report</h4>
    <h5 style="margin: 5px">{{date('d-M-Y',strtotime(Session::get('report_from')))}}</h5>
</center>
<hr style="size:2px;border:inset">
<h2 style="text-align: center;padding: 10px;background: whitesmoke">
    {{number_format($orders['Total']['total'],2)}}</h2>
<table style="width:100%;margin-top:10px" border="1px solid" cellspacing="0" cellpadding="5px">
    <tr style="font-size:14px">
        <th width="70%">Category</th>
        <th width="30%">Total</th>
    </tr>
    @foreach($sale as $key=>$value)
        @if($key!='Total')
            <tr style="font-size: 14px">
                <td>{{$key}}</td>
                <td align="right">{{number_format($value['total'],2)}}</td>
            </tr>
        @endif
    @endforeach
</table>
<table style="width:100%;margin-top:10px" border="1px solid" cellspacing="0" cellpadding="5px">
    <tr style="font-size:14px;">
        <th width="70%">Period</th>
        <th width="30%">Total</th>
    </tr>
    @foreach($orders as $key=>$value)
        @if($key!='Total')
            <tr style="font-size: 14px;width: 50%">
                <td>{{$key}}</td>
                <td align="right">{{number_format($value['total'],2)}}</td>
            </tr>
        @endif
    @endforeach
</table>

