<h1 class="page-header">Recipe</h1>
<div class="row">
    <div class="col-md-4 form-group">
        {!! Form::select('category',['-1'=>'Select Category']+App\ProductCategory::orderBy('name')->pluck('name','id')->toArray() ,Session::get('recipe_category'),['class'=>'form-control','style'=>'height:40px','onChange'=>'ajaxLoad("'.url("recipe").'?category="+this.value)']) !!}
    </div>
    <div class="col-md-6 form-group">
        {!! Form::select('product_id',$products ,Session::get('recipe_product_id'),['class'=>'form-control','style'=>'height:40px','onChange'=>'ajaxLoad("'.url("recipe").'?product_id="+this.value)']) !!}
    </div>
</div>
@if($product)
    <b style="font-size: 14px;color: red">{{$product->name}}</b>
    <div class="pull-right">
        <a href="javascript:ajaxLoad('recipe/create')" class="btn btn-primary btn-xs"><i
                    class="glyphicon glyphicon-plus-sign"></i> New</a>
    </div>

    <table class="table table-bordered table-striped" style="margin-top: 10px">
        <thead>
        <tr>
            <th width="50px" style="text-align: center">No</th>
            <th>Name</th>
            <th style="text-align: right">Quantity</th>
            <th style="text-align: center">Unit</th>
            <th width="140px"></th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1;?>
        @foreach($product->recipes as $key=>$recipe)
            <tr>
                <td align="center">{{$i++}}</td>
                <td>{{$recipe->item?$recipe->item->name:''}}</td>
                <td align="right">{{$recipe->quantity}}</td>
                <td align="center">{{$recipe->item?$recipe->item->unit:''}}</td>
                <td style="text-align: center">
                    <a class="btn btn-primary btn-xs" title="Edit"
                       href="javascript:ajaxLoad('recipe/update/{{$recipe->id}}')">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>
                    <a class="btn btn-danger btn-xs" title="Delete"
                       href="javascript:if(confirm('Are you sure want to delete?')) ajaxDelete('recipe/delete/{{$recipe->id}}','{{csrf_token()}}')">
                        <i class="glyphicon glyphicon-trash"></i> Delete
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif