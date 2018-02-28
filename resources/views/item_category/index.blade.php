<h1 class="page-header">Item Category
    <div class="pull-right">
        <a href="javascript:ajaxLoad('item_category/create')" class="btn btn-primary pull-right"><i
                    class="glyphicon glyphicon-plus-sign"></i> New</a>
    </div>
</h1>
<div class="col-sm-4 form-group">
    <div class="input-group">
        <input class="form-control" id="search" value="{{ Session::get('item_category_search') }}"
               onkeydown="if (event.keyCode == 13) ajaxLoad('{{url('item_category')}}?ok=1&search='+this.value)"
               placeholder="Search..."
               type="text">

        <div class="input-group-btn">
            <button type="button" class="btn btn-default"
                    onclick="ajaxLoad('{{url('item_category')}}?ok=1&search='+$('#search').val())"><i
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
            <a href="javascript:ajaxLoad('item_category?field=name&sort={{Session::get("item_category_sort")=="asc"?"desc":"asc"}}')">
                Name
            </a>
            <i style="font-size: 12px"
               class="glyphicon  {{ Session::get('item_category_field')=='name'?(Session::get('item_category_sort')=='asc'?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt'):'' }}">
            </i>
        </th>
        <th width="140px"></th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    @foreach($item_categories as $key=>$item_category)
        <tr>
            <td align="center">{{$i++}}</td>
            <td>{{$item_category->name}}</td>
            <td style="text-align: center">
                <a class="btn btn-primary btn-xs" title="Edit"
                   href="javascript:ajaxLoad('item_category/update/{{$item_category->id}}')">
                    <i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a class="btn btn-danger btn-xs" title="Delete"
                   href="javascript:if(confirm('Are you sure want to delete?')) ajaxDelete('item_category/delete/{{$item_category->id}}','{{csrf_token()}}')">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pull-right">{!! str_replace('/?','?',$item_categories->render()) !!}</div>
<div class="row">
    <i class="col-sm-12">
        Total: {{$item_categories->total()}} records
    </i>
</div>