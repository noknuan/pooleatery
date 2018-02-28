<?php
/**
 * Created by PhpStorm.
 * User: Noc
 * Date: 2/28/2018
 * Time: 10:28 AM
 */<h2 class="page-header">{{isset($item)?'Edit':'New'}} Item</h2>
@if(isset($item))
    {!! Form::model($item,["id"=>"frm","class"=>"form-horizontal","method"=>"put"]) !!}
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
<div class="form-group">
    {!! Form::label("item_category_id","Category",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::select("item_category_id",\App\ItemCategory::orderBy('name')->pluck('name','id'),null,["class"=>"form-control","style"=>"height:auto"]) !!}
    </div>
</div>
<div class="form-group required" id="form-unit-error">
    {!! Form::label("unit","Unit",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::text("unit",null,["class"=>"form-control required","id"=>"focus"]) !!}
        <span id="unit-error" class="help-block"></span>
    </div>
</div>
<div class="form-group">
    <div class="col-md-5 col-md-push-2">
        <a href="javascript:ajaxLoad('item')" class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i>
            Back</a>
        {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
    btn-primary","id"=>"btn_save"])!!}
    </div>
</div>
{!! Form::close() !!}