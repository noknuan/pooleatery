<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Open Order</h4>
</div>
{!! Form::open(["id"=>"updateForm"]) !!}
@include("cashier._form")
{!! Form::close() !!}
<script>
    $("#updateForm").submit(function (event) {
        $("#btn_save").attr('disabled', 'disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Saving...");
        event.preventDefault();
        $("#updateForm input").css("pointer-events", "none");
        $('.loading').show();
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
                    $("#modal_open").find('form')[0].reset();
                    $('#modal_open').modal('hide');
                    $("#orderList").html(data);
                }
                $('.loading').hide();
                $("#btn_save").removeAttr('disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Save");
                $("#updateForm input").css("pointer-events", "");
            },
            error: function (xhr, textStatus, errorThrown) {
                alert(textStatus);
                $("#btn_save").removeAttr('disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Save");
                $("#updateForm input").css("pointer-events", "");
            }
        });
        return false;
    });
</script>