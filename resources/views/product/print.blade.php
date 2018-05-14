<style>
    *{ font-family: DejaVu Sans !important;}
    .page-break {
        page-break-after: always;
    }
</style>
<?php $i = 1;?>
<h1>Product List </h1>
    <table style="width:100%">
        <thead>
        <tr style="font-size:14px; ">
            <th width="20%" style="text-align: center" bgcolor="#a9a9a9"> No</th>
            <th width="50%" style="text-align: center" bgcolor="#a9a9a9"> Name</th>
            <th width="30%" style="text-align: center" bgcolor="#a9a9a9">Unit Price (Bath) </th>
        </tr>
        </thead>
        <tbody style="font-size: 12px">

        @foreach($categories as $key=>$category)
            <tr>
                <th colspan="3">{{$category->name}}</th>
            </tr>
            @foreach($category->products as $product)
                <tr>
                    <td align="center">{{$i++}}</td>
                    <td>{{$product->name}}</td>
                    <td align="right">{{$product->unitprice}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><hr></td>
            </tr>
        @endforeach
        </tbody>
    </table>
<h4>Total: {{$i-1}} records</h4>


