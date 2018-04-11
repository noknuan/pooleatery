<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Select Table</h4>
    Status:
    <img src="{{asset('images/free.png')}}" height="20px" width="20px"/> Free
    <img src="{{asset('images/busy.png')}}" height="20px" width="20px"/> Busy
    <img src="{{asset('images/invoice.png')}}" height="20px" width="20px"/> Print Invoice
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