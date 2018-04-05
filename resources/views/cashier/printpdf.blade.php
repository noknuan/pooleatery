<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    *{ font-family: DejaVu Sans !important;}
    .page-break {
        page-break-after: always;
    }
    </style>
</head>
<body>
    <center><h4 style="padding: 0px;margin: 0px">Invoice</h4>
</center>
<table style="width:100%;font-size:12px">
    <tr>
        <td width="80px" style="text-align:right">Invoice #:</td>
        <td style="text-align:left">{{str_pad($order->id,6,0,0)}}</td>
        <td style="width:60px;text-align:right">Date:</td>
        <td style="text-align:left;width:100px">{{date("d-M-Y",strtotime($order->updated_at))}}</td>
    </tr>
    <tr>
        <td width="80px" style="text-align:right">Table No:</td>
        <td style="text-align:left">{{$order->table->name}}</td>
        <td style="width:60px;text-align:right">Cashier:</td>
        <td style="text-align:left;width:100px">{{ucwords(Auth::user()->username)}}</td>
    </tr>
    <tr>
        <td width="80px" style="text-align:right">Customer:</td>
        <td style="text-align:left">{{!empty($order->customer_id)&&$order->customer_id!='-1'?$order->customer->name:'General'}}</td>
    </tr>
</table>
<table style="width:100%;margin-top:10px" border="0" cellspacing="0" cellpadding="2px">
    <tr style="font-size:13px">
        <th width="20px">No</th>
        <th>Description</th>
        <th style="width:8%;text-align: center;">Qty</th>
        <th style="width:16%;text-align: right">Price</th>
        {{--<th style="width:12%">D.C</th>--}}
        <th style="width:18%;text-align: right">Total</th>
    </tr>
    <tr style="font-size:14px">
        <th colspan="6" align="left">
            <hr>
        </th>
    </tr>
    <?php $total = 0;$i = 1 ?>
    @foreach($order->order_details()->select(DB::raw("description,sum(quantity) as quantity,price,discount"))->groupBy('product_id')->groupBy('price')->groupBy('description')->groupBy('discount')->orderBy('description')->get() as $orderDetail)
        <tr style="font-size:11px;@if(!empty($orderDetail->deleted_at)) text-decoration: line-through; @endif">
            <td align="center">{{$i++}}</td>
            <td align="left">{{$orderDetail->description}}</td>
            <td align="center">{{$orderDetail->quantity}}</td>
            <td align="right">{{number_format($orderDetail->price,2)}}</td>
            {{--<td align="center">{{$orderDetail->discount}}%</td>--}}
            <td align="right">
                {{number_format($orderDetail->quantity * $orderDetail->price * (1 - $orderDetail->discount / 100),2)}}</td>
            <?php if (empty($orderDetail->deleted_at)) $total += ($orderDetail->price * $orderDetail->quantity * (1 - $orderDetail->discount / 100)); ?>
        </tr>
    @endforeach
</table>
<hr>
<table width="100%">
    <tr>
        <td align="right">
            <table width="100%" style="font-size: 12px">
                @if($order->discount>0)
                    <tr>
                        <th style="text-align: right;padding-right: 20px">Grand Total:</th>
                        <th style="text-align: right">{{number_format($total,2)}}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;padding-right: 20px">Discount ({{$order->discount}}%):</th>
                        <th style="text-align: right">{{number_format($order->discount*$total/100,2)}}</th>
                    </tr>
                @endif
                <tr>
                    <th style="text-align: right;padding-right: 20px">Net Amount:</th>
                    <th style="text-align: right">{{number_format($total*(1-$order->discount/100),2)}}</th>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>