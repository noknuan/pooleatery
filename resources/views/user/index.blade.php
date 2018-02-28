<h2 class="page-header">User Management
    <div class="pull-right">
        <a href="javascript:ajaxLoad('user/create')" class="btn btn-primary pull-right"><i
                    class="glyphicon glyphicon-plus-sign"></i> New</a>
    </div>
</h2>
<div class="col-md-3 form-group">
    {!! Form::select('role',['-1'=>'All Roles','Admin'=>'Admin','Cashier'=>'Cashier'],Session::get('user_role'),['class'=>'form-control','style'=>'height:auto','onChange'=>'ajaxLoad("'.url("user").'?role="+this.value)']) !!}
</div>
<div class="col-md-4 form-group">
    <div class="input-group">
        <input class="form-control" id="search" value="{{ Session::get('user_search') }}"
               onkeydown="if (event.keyCode == 13) ajaxLoad('{{url('user')}}?ok=1&search='+this.value)"
               placeholder="Search..."
               type="text">

        <div class="input-group-btn">
            <button type="button" class="btn btn-default"
                    onclick="ajaxLoad('{{url('user')}}?ok=1&search='+$('#search').val())"><i
                        class="glyphicon glyphicon-search"></i>
            </button>
        </div>
    </div>
</div>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th width="50px" style="text-align: center">No</th>
        <th class="hidden-xs hidden-sm">
            <a href="javascript:ajaxLoad('user?field=username&sort={{Session::get("user_sort")=="asc"?"desc":"asc"}}')">
                Username
            </a>
            <i style="font-size: 12px"
               class="glyphicon  {{ Session::get('user_field')=='username'?(Session::get('user_sort')=='asc'?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt'):'' }}">
            </i>
        </th>
        <th class="hidden-xs hidden-sm">Role</th>
        <th width="50" align="center">Active</th>
        <th width="140px"></th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    @foreach($users as $key=>$user)
        <tr>
            <td align="center">{{$i++}}</td>
            <td>{{$user->username}}</td>
            <td class="hidden-xs hidden-sm">{{$user->role}}</td>
            <td align="center">
                {!!$user->active?"<i  style='color:green' class='glyphicon glyphicon-ok'></i>":"<i style='color: red'
                                                                                                 class='glyphicon glyphicon-remove'></i>"!!}
            </td>
            <td style="text-align: center">
                <a class="btn btn-primary btn-xs" title="Edit"
                   href="javascript:ajaxLoad('user/update/{{$user->id}}')">
                    <i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a class="btn btn-danger btn-xs" title="Delete"
                   href="javascript:if(confirm('Are you sure want to delete?')) ajaxDelete('user/delete/{{$user->id}}','{{csrf_token()}}')">
                    <i class="glyphicon glyphicon-trash"></i> Delete
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pull-right">{!! str_replace('/?','?',$users->render()) !!}</div>
<div class="row">
    <i class="col-sm-12">
        Total: {{$users->total()}} records
    </i>
</div>