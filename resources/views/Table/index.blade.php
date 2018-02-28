<h1 class="page-header">Table
    <div class="pull-right">
        <a href="javascript:ajaxLoad('table/create')" class="btn btn-primary pull-right"><i
                    class="glyphicon glyphicon-plus-sign"></i> New</a>
    </div>
</h1>
<div class="col-sm-4 form-group">
    <div class="input-group">
        <input class="form-control" id="search" value="{{ Session::get('table_search') }}"
               onkeydown="if (event.keyCode == 13) ajaxLoad('{{url('table')}}?ok=1&search='+this.value)"
               placeholder="Search..."
               type="text">

        <div class="input-group-btn">
            <button type="button" class="btn btn-default"
                    onclick="ajaxLoad('{{url('table')}}?ok=1&search='+$('#search').val())"><i
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
            <a href="javascript:ajaxLoad('table?field=name&sort={{Session::get("table_sort")=="asc"?"desc":"asc"}}')">
                Name
            </a>
            <i style="font-size: 12px"
               class="glyphicon  {{ Session::get('table_field')=='name'?(Session::get('table_sort')=='asc'?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt'):'' }}">
            </i>
        </th>
        <th width="140px"></th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    @foreach($tables as $key=>$table)
        <tr>
            <td align="center">{{$i++}}</td>
            <td>{{$table->name}}</td>
            <td style="text-align: center">
                <a class="btn btn-primary btn-xs" title="Edit"
                   href="javascript:ajaxLoad('table/update/{{$table->id}}')">
                    <i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a class="btn btn-danger btn-xs" title="Delete"
                   href="javascript:if(confirm('Are you sure want to delete?')) ajaxDelete('table/delete/{{$table->id}}','{{csrf_token()}}')">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pull-right">{!! str_replace('/?','?',$tables->render()) !!}</div>
<div class="row">
    <i class="col-sm-12">
        Total: {{$tables->total()}} records
    </i>
</div>