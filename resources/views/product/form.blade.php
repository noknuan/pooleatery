<h2 class="page-header">{{isset($product)?'Edit':'New'}} Product</h2>
@if(isset($product))
    {!! Form::model($product,["id"=>"frm","class"=>"form-horizontal","method"=>"put"]) !!}
@else
    {!! Form::open(["id"=>"frm","class"=>"form-horizontal"]) !!}
@endif
<div class="form-group" id="form-image-error">
    {!! Form::label("image","Image",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        <img id="preview"
             src="{{(isset($product) && $product->image!='' && File::exists('images/products/'.$product->image))?'/images/products/'.$product->image:'/images/default.jpg'}}"
             onerror="this.src='/images/default.jpg'" width="150px" height="130px"
             style="padding: 5px"/>
        {!! Form::file("image",["class"=>"form-control","style"=>"display:none","id"=>"image"]) !!}
        <a href="javascript:changeProfile()">Change</a> |
        <a style="color: red" href="javascript:removeImage()">Remove</a>
        <input type="hidden" style="display: none" value="0" name="remove" id="remove">
        <span id="image-error" class="help-block"></span>
    </div>
</div>
<div class="form-group required" id="form-name-error">
    {!! Form::label("name","Name",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::text("name",null,["class"=>"form-control required","id"=>"focus"]) !!}
        <span id="name-error" class="help-block"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label("product_category_id","Category",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::select("product_category_id",\App\ProductCategory::orderBy('name')->pluck('name','id'),null,["class"=>"form-control","style"=>"height:40px"]) !!}
    </div>
</div>
<div class="form-group required" id="form-unitprice-error">
    {!! Form::label("unitprice","Unitprice",["class"=>"control-label col-md-2"]) !!}
    <div class="col-md-5">
        {!! Form::text("unitprice",null,["class"=>"form-control required"]) !!}
        <span id="unitprice-error" class="help-block"></span>
    </div>
</div>
<div class="form-group">
    <div class="col-md-5 col-md-push-2">
        <a href="javascript:ajaxLoad('product')" class="btn btn-danger"><i class="glyphicon glyphicon-backward"></i>
            Back</a>
        {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
    btn-primary","id"=>"btn_save"])!!}
    </div>
</div>
{!! Form::close() !!}
<script>
    function changeProfile() {
        $('#image').click();
    }
    $('#image').change(function () {
        var imgPath = $(this)[0].value;
        var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
            readURL(this);
        else
            alert("Please select image file (jpg, jpeg, png).")
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $("#remove").val(0);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function removeImage() {
        $('#preview').attr('src', '/images/default.jpg');
        $("#remove").val(1);
    }
</script>