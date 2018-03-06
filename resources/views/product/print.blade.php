<link href="{{ asset('bootstrap-3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <h1 class="page-header">Product List </h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="80px" style="text-align: center"> Code</th>
            <th> Name</th>
            <th style="text-align: right">Unitprice</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $key=>$category)
            <tr style="background: whitesmoke">
                <th colspan="3">{{$category->name}}</th>
            </tr>
            @foreach($category->products as $product)
                <tr>
                    <td align="center">{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td align="right">$ {{$product->unitprice}}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>