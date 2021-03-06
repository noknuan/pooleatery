@extends('layouts.cashier')
@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="col-md-4" style="padding: 1%">
            @foreach($menuCategories as $menuCategory)
               <div class="menu" @if($menuCategory->id==(Session::has('menuCategory_id')?Session::get('menuCategory_id'):env('DEFAULT_MENU_CATEGORY'))) active  @endif"
                     onclick="$('.menu').removeClass('active');$(this).addClass('active');ajaxLoad('cashier/products?menuCategory_id={{$menuCategory->id}}','productList')">{{$menuCategory->name}}
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <input type="text" id="search" class="form-control" placeholder="Type your search item here..."
                   style="border: 1px solid whitesmoke;height: 40px;border-radius: 0px;background: lightyellow;font-size: 16px"
                   onfocus="$(this).val('')"
                   onfocusout="$(this).val('Type your search item here...')"
                   onkeyup="ajaxLoad('cashier/products?search='+this.value,'productList')"/>
            <div id="productList">
                <ul class="list-group"
                    style="height: 500px;overflow-y: auto;border: 2px outset;background: #ffe9f9">
                    @foreach(\App\Product::where('product_category_id',Session::get('menuCategory_id'))->orderBy('name')->get() as $menu)
                        <li class="list-group-item"
                            style="font-size: 16px;padding:0px;height: 80px"
                            onclick="if($('#table_id').text()=='Table #') $.alert({  icon: 'glyphicon glyphicon-warning-sign',title: 'Warning Alert!', content: 'Please select Table first before making order.',type:'red',typeAnimated: true,buttons: {
                                    tryAgain: {
                                    text: 'Try again',
                                    btnClass: 'btn-red',
                                    action: function(){
                                    }
                                    },
                                    }});  else ajaxLoad('cashier/order/{{$menu->id}}','orderList')">
                            <img src="{{$menu->image!='' && File::exists('images/products/'.$menu->image)?'/images/products/'.$menu->image:'/images/default.jpg'}}"
                                 class="pull-left" width="80px" height="70px"
                                 style="margin: 5px 5px 0px 5px"/>
                            <div style="margin:20px">
                                <span style="color: red;font-size: 15px"
                                      class="pull-right">{{number_format($menu->unitprice,2)}} (บาท)</span>
                                <div>{{$menu->name}}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    <div class="col-md-4" id="orderList" style="padding: 1px 1px 1px 1px">
        @include('cashier._order')
    </div>
    </div>

@endsection