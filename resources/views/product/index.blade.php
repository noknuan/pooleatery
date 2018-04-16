<h1 class="page-header">Product
    <div class="pull-right">
        <a href="javascript:ajaxLoad('product/create')" class="btn btn-success"><i
                    class="glyphicon glyphicon-plus-sign"></i> New</a>
        <a href="{{url('product/print')}}" target="_blank" class="btn btn-primary"><i
                    class="glyphicon glyphicon-print"></i> Print</a>
    </div>
</h1>
<div class="col-md-3 form-group">
    {!! Form::select('category',['-1'=>'All Categories']+App\ProductCategory::orderBy('name')->pluck('name','id')->toArray() ,Session::get('product_category'),['class'=>'form-control','style'=>'height:40px','onChange'=>'ajaxLoad("'.url("product").'?category="+this.value)']) !!}
</div>
<div class="col-sm-4 form-group">
    <div class="input-group">
        <input class="form-control" id="search" value="{{ Session::get('product_search') }}"
               onkeydown="if (event.keyCode == 13) ajaxLoad('{{url('product')}}?ok=1&search='+this.value)"
               placeholder="Search..."
               type="text">

        <div class="input-group-btn">
            <button type="button" class="btn btn-default"
                    onclick="ajaxLoad('{{url('product')}}?ok=1&search='+$('#search').val())"><i
                        class="glyphicon glyphicon-search"></i>
            </button>
        </div>
    </div>
</div>
<table class="table table-bordered table-striped">
    <thead>
    <tr bgcolor="#a9a9a9">
        <th class="hidden-xs hidden-sm" style="text-align: center">Picture</th>
        <th width="80px" style="text-align: center">
            <a href="javascript:ajaxLoad('product?field=id&sort={{Session::get("product_sort")=="asc"?"desc":"asc"}}')">
                Code
            </a>
            <i style="font-size: 12px"
               class="glyphicon  {{ Session::get('product_field')=='id'?(Session::get('product_sort')=='asc'?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt'):'' }}">
            </i>
        </th>
        <th>
            <a href="javascript:ajaxLoad('product?field=name&sort={{Session::get("product_sort")=="asc"?"desc":"asc"}}')">
                Name
            </a>
            <i style="font-size: 12px"
               class="glyphicon  {{ Session::get('product_field')=='name'?(Session::get('product_sort')=='asc'?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt'):'' }}">
            </i>
        </th>
        <th class="hidden-xs hidden-sm">Category</th>
        <th style="text-align: right">Unitprice</th>
        <th width="140px" style="text-align: center">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    @foreach($products as $key=>$product)
        <tr bgcolor="#fffacd">
            <td class="hidden-xs hidden-sm" style="text-align: center">
                <img src="{{$product->image!='' && File::exists('images/products/'.$product->image)?'/images/products/'.$product->image:'/images/default.jpg'}}"
                     width="80px" height="70px"/>
            </td>
            <td align="center" style="vertical-align: middle">{{$product->id}}</td>
            <td style="vertical-align: middle">{{$product->name}}</td>
            <td class="hidden-xs hidden-sm"
                style="vertical-align: middle">{{$product->product_category?$product->product_category->name:''}}</td>
            <td align="right" style="vertical-align: middle">  {{$product->unitprice}}</td>
            <td style="text-align: center;vertical-align: middle">
                <a class="btn btn-info btn-xs" title="Edit"
                   href="javascript:ajaxLoad('product/update/{{$product->id}}')">
                    <i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a class="btn btn-danger btn-xs" title="Delete" href="javascript:$.confirm({
                icon: 'glyphicon glyphicon-warning-sign',
                title: 'Warning Alert!',
                content: 'Are you sure want to delete?',
                type:'red',
                typeAnimated: true,
                buttons: {
                confirm: function () {
                ajaxDelete('product/delete/{{$product->id}}','{{csrf_token()}}')
                },
                cancel: function () {
                },
                }
                });">
                    <i class="glyphicon glyphicon-trash"></i> Delete </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pull-right">{!! str_replace('/?','?',$products->render()) !!}</div>
<div class="row">
    <i class="col-sm-12">
        Total: {{$products->total()}} records
    </i>
</div>