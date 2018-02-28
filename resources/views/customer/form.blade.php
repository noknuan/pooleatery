<h2 class="page-header">{{isset($customer)?'Edit':'New'}} Customer</h2>
@if(isset($customer))
    {!! Form::model($customer,["id"=>"frm","class"=>"form-horizontal","method"=>"put"]) !!}
@else
    {!! Form::open(["id"=>"frm","class"=>"form-horizontal"]) !!}
@endif
<div class="form-group required" id="form-name-error">
    {!! Form::label("name","Name",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::text("name",null,["class"=>"form-control required","id"=>"focus"]) !!}
        <span id="name-error" class="help-block"></span>
    </div>
</div>
<div class="form-group required" id="form-discount-error">
    {!! Form::label("discount","Discount",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::text("discount",null,["class"=>"form-control required"]) !!}
        <span id="discount-error" class="help-block"></span>
    </div>
</div>
<div class="form-group">
    <div class="col-md-5 col-md-push-2">
        <a href="javascript:ajaxLoad('customer')" class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i>
            Back</a>
        {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
    btn-primary","id"=>"btn_save"])!!}
    </div>
</div>
{!! Form::close() !!}