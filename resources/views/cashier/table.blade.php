<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="padding-bottom: 4px">Select Table</h4>
    <img src="{{asset('images/free.PNG')}}" height ="20px" width="20px"/> Free
    <img src="{{asset('images/busy.PNG')}}" height="20px" width="20px"/> Busy
    <img src="{{asset('images/invoice.PNG')}}" height="20px" width="20px"/> Print Invoice
</div>
<div class="modal-body">
    <div class="row">
        @foreach($tables as $table)
            <div class="tbl {{$table->status}}"
                 onclick="ajaxLoad('cashier/select-table/{{$table->id}}','orderList');$('#modal').modal('hide');">{{$table->name}}
            </div>
        @endforeach
    </div>
</div>
<div class="modal-footer">
    {!! Form::button("<i class='glyphicon glyphicon-remove'></i> Close",["class"=>"btn btn-danger","data-dismiss"=>"modal"])!!}
</div>