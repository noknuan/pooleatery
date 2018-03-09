<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant Management System</title>
    <!-- Styles -->
    <link href="{{ asset('bootstrap-3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sale.css') }}" rel="stylesheet">
</head>
<body style="background: grey">
<div class="modal fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="modal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content container-fluid">
        </div>
    </div>
</div>
<div class="modal fade " id="modal_open" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content container-fluid">
        </div>
    </div>
</div>
<div class="modal fade " id="modal_pay" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content container-fluid">
        </div>
    </div>
</div>
<div class="container-fluid" style="background: #ffffff;border-bottom: 5px solid #c4c4bf">
    <img src="/images/logo.png" height="80px" width="170px"/>
    <div class="pull-right" style="padding-top: 10px;font-size: 16px">
      <br>  Hi, {{ucwords(Auth::user()->username)}}  <a href="{{url('/logout')}}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"><br><i class="glyphicon glyphicon-log-out"></i>Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST"
              style="display: none;">
            {{ csrf_field() }}
        </form>

    </div>
</div>
@yield('content')
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
<script>
    $('#modal, #modal_open, #modal_pay').on('shown.bs.modal', function () {
        $('#focus').focus().select();
    });
    $('#modal, #modal_open, #modal_pay').on('hidden.bs.modal', function (e) {
        $(this).removeData('bs.modal');
    });
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
                if (xhr.responseText == 'Unauthorized.')
                    location.reload();
                else
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
</script>
</body>
</html>