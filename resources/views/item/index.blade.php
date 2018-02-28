<h1 class="page-header">Item
    <div class="pull-right">
        <a href="javascript:ajaxLoad('item/create')" class="btn btn-primary pull-right"><i
                    class="glyphicon glyphicon-plus-sign"></i> New</a>
    </div>
</h1>
<div class="col-md-3 form-group">
    {!! Form::select('category',['-1'=>'All Categories']+App\ItemCategory::orderBy('name')->pluck('name','id')->toArray() ,Session::get('item_category'),['class'=>'form-control','style'=>'height:auto','onChange'=>'ajaxLoad("'.url("item").'?category="+this.value)']) !!}
</div>
<div class="col-sm-4 form-group">
    <div class="input-group">
        <input class="form-control" id="search" value="{{ Session::get('item_search') }}"
               onkeydown="if (event.keyCode == 13) ajaxLoad('{{url('item')}}?ok=1&search='+this.value)"
               placeholder="Search..."
               type="text">

        <div class="input-group-btn">
            <button type="button" class="btn btn-default"
                    onclick="ajaxLoad('{{url('item')}}?ok=1&search='+$('#search').val())"><i
                        class="glyphicon glyphicon-search"></i>
            </button>
        </div>
    </div>
</div>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th width="50px" style="text-align: center">No</th>
        <th>
            <a href="javascript:ajaxLoad('item?field=name&sort={{Session::get("item_sort")=="asc"?"desc":"asc"}}')">
                Name
            </a>
            <i style="font-size: 12px"
               class="glyphicon  {{ Session::get('item_field')=='name'?(Session::get('item_sort')=='asc'?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt'):'' }}">
            </i>
        </th>
        <th>Category</th>
        <th>Unit</th>
        <th width="140px"></th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    @foreach($items as $key=>$item)
        <tr>
            <td align="center">{{$i++}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->item_category_id?$item->item_category->name:''}}</td>
            <td>{{$item->unit}}</td>
            <td style="text-align: center">
                <a class="btn btn-primary btn-xs" title="Edit"
                   href="javascript:ajaxLoad('item/update/{{$item->id}}')">
                    <i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a class="btn btn-danger btn-xs" title="Delete"
                   href="javascript:if(confirm('Are you sure want to delete?')) ajaxDelete('item/delete/{{$item->id}}','{{csrf_token()}}')">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pull-right">{!! str_replace('/?','?',$items->render()) !!}</div>
<div class="row">
    <i class="col-sm-12">
        Total: {{$items->total()}} records
    </i>
</div>