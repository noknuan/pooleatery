<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Change from Table <b
                style="color: red">{{\App\Table::find(Session::get('table_id'))->name}} </b> to</h4>
</div>
<div class="modal-body">
    <div class="row">
        @foreach($tables as $table)
            <div class="tbl {{$table->status}}"
                 onclick="ajaxLoad('cashier/switch-table/{{$table->id}}?ids='+getSelectedRows(),'orderList');$('#modal').modal('hide');">{{$table->name}}
            </div>
        @endforeach
    </div>
</div>