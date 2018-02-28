function ajaxLoad(filename, content) {
    content = typeof content !== 'undefined' ? content : 'content';
    $('.loading').show();
    $.ajax({
        type: "GET",
        url: filename,
        contentType: false,
        success: function (data) {
            $("#" + content).html(data);
            $('.loading').hide();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}
function ajaxDelete(filename, token, content) {
    content = typeof content !== 'undefined' ? content : 'content';
    $('.loading').show();
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $("#" + content).html(data);
            $('.loading').hide();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    ajaxLoad($(this).attr('href'));
});

routie('*', function () {
    var url = window.location.href;
    var p = url.indexOf('#');
    if (p > -1) {
        var controllerAction = url.substr(url.indexOf('#') + 1);
        var pos = controllerAction.indexOf('*');
        var menu = controllerAction;
        if (pos > -1)
            menu = controllerAction.substr(0, pos);
        activeMenu("nav_" + menu.replace('/', '_'));
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        ajaxLoad(controllerAction.replace('*', '/'));
    } else {
        activeMenu("nav_home");
        ajaxLoad('home');
    }
});
function activeMenu(nav) {
    $('.nav li.active').removeClass('active');
    $(".nav ." + nav).addClass('active');
}

$(document).on('submit', 'form#frm', function (event) {
    $("#btn_save").attr('disabled', 'disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Saving...");
    event.preventDefault();
    $("#frm input").css("pointer-events", "none");
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.fail) {
                $('#frm input.required, #frm textarea.required').each(function () {
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
                $('#focus').focus().select();
            } else {
                $(".has-error").removeClass("has-error");
                $(".help-block").empty();
                if (!data.url) {
                    var url = window.location.href;
                    var controllerAction = url.substr(url.indexOf('#') + 1).replace('*', '/');
                    ajaxLoad(controllerAction);
                }
                else
                    ajaxLoad(data.url, data.content);
            }
            $("#btn_save").removeAttr('disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Save");
            $("#frm input").css("pointer-events", "");
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(errorThrown);
            $("#btn_save").removeAttr('disabled').html("<i class='glyphicon glyphicon-floppy-disk'></i> Save");
            $("#frm input").css("pointer-events", "");
        }
    });
    return false;
});
$("#msg").delay(5000).fadeOut();