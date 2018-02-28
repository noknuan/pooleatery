<h2 class="page-header">{{isset($user)?'Edit':'New'}}User</h2>
@if(isset($user))
    {!! Form::model($user,["id"=>"frm","class"=>"form-horizontal","method"=>"put"]) !!}
@else
    {!! Form::open(["id"=>"frm","class"=>"form-horizontal"]) !!}
@endif
<div class="row">
    <div class="form-group required" id="form-username-error">
        {!! Form::label("username","Username",["class"=>"control-label col-md-2"]) !!}
        <div class="col-md-5">
            {!! Form::text("username",null,["class"=>"form-control required","id"=>"focus"]) !!}
            <span id="username-error" class="help-block"></span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label("role","Role",["class"=>"control-label col-md-2"]) !!}
        <div class="col-md-5">
            {!! Form::select("role",['Admin'=>'Admin','Cashier'=>'Cashier'],null,["class"=>"form-control"]) !!}
        </div>
    </div>
    <div class="form-group" id="form-password-error">
        {!! Form::label("password","Password",["class"=>"control-label col-md-2"]) !!}
        <div class="col-md-5">
            {!! Form::password("password",["class"=>"form-control required"]) !!}
            <span id="password-error" class="help-block"></span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label("password_confirmation","Confirm password",["class"=>"control-label col-md-2"]) !!}
        <div class="col-md-5">
            {!! Form::password("password_confirmation",["class"=>"form-control"]) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label("active","Active",["class"=>"control-label col-md-2"]) !!}
        <div class="col-md-5">
            {!! Form::checkbox("active",1,null,["style"=>"width:25px;height:25px"]) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-5 col-md-push-2">
            <a href="javascript:ajaxLoad('{{url('user')}}')"
               class="btn btn-danger"><i
                        class="glyphicon glyphicon-backward"></i> Back</a>
            {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
        btn-primary","id"=>"btn_save"])!!}
        </div>
    </div>
</div>
{!! Form::close() !!}