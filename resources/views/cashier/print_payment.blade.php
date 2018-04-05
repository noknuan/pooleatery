<b><a href="{{url("cashier/pdfreceipt")}}" target="_blank">Print Invoice</a></b>
<center>
    <img src="{{asset('images/logo.png')}}" height="80px" width="150px"/>
    <h1 style="font-size:20px;margin:0">The Pool Eatery</h1>
    <i style="font-size:11px;width:90%;display:block">Address: 100 Leaigmuang Road Pakpeak Muang Kanchanaburi</i>
    <h3 style="padding: 0px;margin: 0px">Receipt</h3>
</center>
<hr style="size:2px;border:inset;margin-top: 0px;padding-top: 0px">
<table style="width:100%;font-size:12px">
    <tr>
        <td width="80px" style="text-align:right">Receipt #:</td>
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
        <th width="20px">No(ลำดับ)</th>
        <th>Description(รายการ)</th>
        <th style="width:8%;text-align: center">Qty(จำนวน)</th>
        <th style="width:16%;text-align: right">Price(ราคา)</th>
        <th style="width:18%;text-align: right">Total(รวมเงิน)</th>
    </tr>
    <tr style="font-size:14px">
        <th colspan="6" align="left">
            <hr>
        </th>
    </tr>
    <?php $total = 0; $i = 1;?>
    @foreach($order->order_details()->select(DB::raw("description,sum(quantity) as quantity,price,discount"))->groupBy('product_id')->groupBy('price')->groupBy('description')->groupBy('discount')->orderBy('description')->get() as $orderDetail)
        <tr style="font-size:11px;@if(!empty($orderDetail->deleted_at)) text-decoration: line-through; @endif">
            <td align="center">{{$i++}}</td>
            <td align="left">{{$orderDetail->description}}</td>
            <td align="center">{{$orderDetail->quantity}}</td>
            <td align="right"> {{number_format($orderDetail->price,2)}}</td>
            <td align="right">
                 {{number_format($orderDetail->quantity * $orderDetail->price* (1 - $orderDetail->discount / 100),2)}}</td>
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
                        <th style="text-align: right;padding-right: 20px">Grand Total(ยอดรวมทั้งสิ้น):</th>
                        <th style="text-align: right">{{number_format($total,2)}}</th>
                    </tr>
                    <tr>
                        <th style="text-align: right;padding-right: 20px">Discount(ส่วนลด) ({{$order->discount}}%):</th>
                        <th style="text-align: right">{{number_format($order->discount*$total/100,2)}}</th>
                    </tr>
                @endif
                <tr>
                    <th style="text-align: right;padding-right: 20px">Net Amount(รวมทั้งสิ้น):</th>
                    <th style="text-align: right">{{number_format($total*(1-$order->discount/100),2)}}</th>
                </tr>
                @if(Session::get('usd')>0)
                    <tr>
                        <th style="text-align: right;padding-right: 20px">Cash in (บาท):</th>
                        <th style="text-align: right">{{number_format(Session::get('usd'),2)}}</th>
                    </tr>
                @endif
                @if(Session::get('change_us')>0)
                    <tr>
                        <th style="text-align: right;padding-right: 20px">Cash Return (เงินทอน):</th>
                        <th style="text-align: right">
                            {{number_format(Session::get('change_us'),2)}}</th>
                    </tr>
                @endif
            </table>
        </td>
    </tr>
</table>
<hr/>

<script>
    //    window.print();
    //    window.close();
</script>