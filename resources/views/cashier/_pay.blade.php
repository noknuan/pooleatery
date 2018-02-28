<div class="modal-body">
    <div class="row">
        <div class="col-md-7">
            <table class="table">
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                @if(count($order)>0)
                    <tbody>
                    <?php $total = 0; ?>
                    @foreach($order->order_details()->select(DB::raw("description,sum(quantity) as quantity,price,discount"))->groupBy('product_id')->groupBy('price')->groupBy('description')->groupBy('discount')->orderBy('description')->get() as $orderDetail)
                        <tr @if(!empty($orderDetail->deleted_at)) style="text-decoration: line-through;" @endif>
                            <td>
                                {{$orderDetail->description}}
                            </td>
                            <td>
                                {{$orderDetail->quantity}}
                            </td>
                            <td align="right">$ {{number_format($orderDetail->price,2)}}</td>
                            <td align="right">
                                $ {{number_format($orderDetail->price * $orderDetail->quantity* (1 - $orderDetail->discount / 100),2)}}</td>
                        </tr>
                        <?php if (empty($orderDetail->deleted_at)) $total += ($orderDetail->price * $orderDetail->quantity * (1 - $orderDetail->discount / 100)); ?>
                    @endforeach
                    </tbody>
                @endif
            </table>
            @if(count($order)>0)
                <div style="text-align: right;float: right;border-top: solid 1px whitesmoke;">
                    <table width="100%">
                        <tr>
                            <th style="text-align: right;padding-right: 20px">Discount:</th>
                            <th style="text-align: right">{{$order->discount}} %</th>
                        </tr>
                        <tr>
                            <th style="text-align: right;padding-right: 20px">Total:</th>
                            <th style="text-align: right">$ {{number_format($total*(1-$order->discount/100),2)}}</th>
                        </tr>
                    </table>
                </div>
            @endif
        </div>
        <div class="col-md-5">
            <div class="form-group required" id="form-usd-error">
                {!! Form::label("usd","Cash in USD",["class"=>"control-label"]) !!}
                {!! Form::text("usd",0,["class"=>"form-control required","id"=>"focus","autocomplete"=>"off"]) !!}
                <span id="usd-error" class="help-block"></span>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <p id="msg" style="display: none;color: blue;float: left;">{{env('success_msg')}}</p>
    {!! Form::button("<i class='glyphicon glyphicon-remove'></i> Close",["class"=>"btn
    btn-primary","data-dismiss"=>"modal"])!!}
    {!! Form::button("<i class='glyphicon glyphicon-floppy-disk'></i> Save",["type" => "submit","class"=>"btn
    btn-primary","id"=>"btn_save"])!!}
</div>