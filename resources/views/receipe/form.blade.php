<h2 class="page-header">{{isset($recipe)?'Add':'Edit'}} Recipe</h2>
@if(isset($recipe))
    {!! Form::model($recipe,["id"=>"frm","class"=>"form-horizontal","method"=>"put"]) !!}
@else
    {!! Form::open(["id"=>"frm","class"=>"form-horizontal"]) !!}
@endif
<div class="form-group">
    {!! Form::label("item_id","Item Name",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::select("item_id",\App\Item::orderBy('name')->pluck('name','id'),null,["class"=>"form-control required","id"=>"name"]) !!}
    </div>
</div>
<div class="form-group required" id="form-quantity-error">
    {!! Form::label("quantity","Quantity",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::text("quantity",null,["class"=>"form-control required","id"=>"focus"]) !!}
        <span id="quantity-error" class="help-block"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label("unit","Unit",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::text("unit",null,["class"=>"form-control","id"=>"unit","readonly"]) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-6 col-md-push-3">
        <a href="javascript:ajaxLoad('recipe')" class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i>
            Back</a>
        {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
    btn-primary","id"=>"btn_save"])!!}
    </div>
</div>
{!! Form::close() !!}
<script>
    $('#name').on('change', function () {
        getUnits($(this).val());
    });
    function getUnits(item_id) {
        $.ajax({
            url: "{{url('item/unit')}}/" + item_id,
            success: function (data) {
                $('#unit').val(data);
            }
        });
    }
    $(document).ready(function () {
        getUnits($('#name').val());
    });
</script>