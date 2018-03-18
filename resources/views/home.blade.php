<div class="row-fluid">
    <div class="col-md-7">
        <h3 class="page-header">Top 20 Product</h3>
        <table class="table">
            <thead>
            <tr bgcolor="#a9a9a9">
                <th> No</th>
                <th> Description</th>
                <th style="text-align: center"> Quantity</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1;?>
            @foreach($orderDetails as $orderDetail)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{!! $orderDetail->product_id?$orderDetail->description:'<b>'.$orderDetail->description.'</b>'!!}</td>
                    <td align="center">{{$orderDetail->total}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-5">
        <h3 class="page-header">Daily Sale Summary</h3>
        <table class="table">
            <thead>
            <th bgcolor="#a9a9a9">Category</th>
            <th style="text-align: right" bgcolor="#a9a9a9">Net Amount</th>
            </thead>
            <tbody>
            @foreach($sale as $key=>$value)
                <tr>
                    <td>{{$key}}</td>
                    <td align="right"> {{number_format($value['total'],2)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<br/><br/><br/><br/>
