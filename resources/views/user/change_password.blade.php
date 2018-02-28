@if(Session::pull('change_password'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <b><i class="glyphicon glyphicon-ok-sign"></i> Congratulation!</b> You have successfully changed your password.
    </div>
@endif
<h3 class="page-header">Change Password</h3>
{!! Form::model($user,["id"=>"createForm","class"=>"form-horizontal","method"=>"put"]) !!}
<div class="form-group required" id="form-old_password-error">
    {!! Form::label("old_password","Old Password",["class"=>"control-label col-md-3"]) !!}
    <div class="col-md-6">
        {!! Form::password("old_password",["class"=>"form-control required","id"=>"focus"]) !!}
        <div id="old_password-error" class="help-block"></div>
    </div>
</div>
<div class="form-group" id="form-password-error">
    {!! Form::label("password","Password",["class"=>"control-label col-md-3"]) !!}
    <div class="col-md-6">
        {!! Form::password("password",["class"=>"form-control required"]) !!}
        <div id="password-error" class="help-block"></div>
    </div>
</div>
<div class="form-group">
    {!! Form::label("password_confirmation","Confirm password",["class"=>"control-label col-md-3"]) !!}
    <div class="col-md-6">
        {!! Form::password("password_confirmation",["class"=>"form-control"]) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-6 col-md-push-3">
        {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
        btn-primary","id"=>"btn_save"])!!}
    </div>
</div>
{!! Form::close() !!}
<script>
    $("#createForm").submit(function (event) {
        $("#btn_save").attr('disabled', 'disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Saving...");
        event.preventDefault();
        var form = $(this);
        var data = form.serialize();
        var url = form.attr("action");
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            success: function (data) {
                if (data.fail) {
                    $('input.required, textarea.required').each(function () {
                        index = $(this).attr('name');
                        if (index in data.errors) {
                            $("#form-" + index + "-error").addClass("has-error");
                            $("#" + index + "-error").html(data.errors[index]);
                        }
                        else {
                            $("#form-" + index + "-error").removeClass("has-error");
                            $("#" + index + "-error").empty();
                        }
                    });
                } else {
                    $(".has-error").removeClass("has-error");
                    $(".help-block").empty();
                    var url = window.location.href;
                    var controllerAction = url.substr(url.indexOf('#') + 1);
                    ajaxLoad(controllerAction);
                }
                $("#focus").focus();
                $("#btn_save").removeAttr('disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Save");
            },
            error: function (xhr, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
        return false;
    });
</script>