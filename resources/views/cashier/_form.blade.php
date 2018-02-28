<div class="modal-body">
    <div class="row">
        <div class="form-group required" id="form-description-error">
            {!! Form::label("description","Description",["class"=>"control-label"]) !!}
            {!! Form::text("description",null,["class"=>"form-control required","id"=>"focus","autocomplete"=>"off"]) !!}
            <span id="description-error" class="help-block"></span>
        </div>
        <div class="form-group required" id="form-quantity-error">
            {!! Form::label("quantity","Quantity",["class"=>"control-label"]) !!}
            {!! Form::text("quantity",null,["class"=>"form-control required","autocomplete"=>"off"]) !!}
            <span id="quantity-error" class="help-block"></span>
        </div>
        <div class="form-group required" id="form-price-error">
            {!! Form::label("price","Price",["class"=>"control-label"]) !!}
            {!! Form::text("price",null,["class"=>"form-control required","autocomplete"=>"off"]) !!}
            <span id="price-error" class="help-block"></span>
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::button("<i class='glyphicon glyphicon-remove'></i> Close",["class"=>"btn
    btn-primary","data-dismiss"=>"modal"])!!}
    {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
    btn-primary","id"=>"btn_save"])!!}
</div>