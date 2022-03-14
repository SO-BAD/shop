@extends('layouts.layout')



@section('title')
<h1>edit Menu</h1>
@stop



@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mx-auto">
            @csrf
            <div class="">
                <div class="d-flex text-center ">
                    <div style="width:10% ;color:red;">
                    </div>
                    <div style="width:10%">Name</div>
                    <div style="width:10%"></div>
                    <div style="width:10%">Price</div>
                    <div style="width:20%">orderBy</div>
                    <div style="width:10%">
                        是否上架
                    </div>
                    <div style="width:10%">
                        刪除
                    </div>
                </div>
            </div>
            @foreach($categories as $k =>$category)
            <div class="mb-5">
                <input type="hidden" value="{{ $category['categoryID'] }}">
                <div class="d-flex text-center category mb-3">
                    <div style="width:10% ;color:red;"> CATEGORY
                    </div>
                    <div style="width:10%"><input class="name" style="width:100%" value="{{ $category['name']}}"></div>
                    <div style="width:10%"></div>
                    <div style="width:10%"><input class="originOrderBy" type="hidden" value="{{ $category['orderBy']}}"></div>
                    <div style="width:20%"><input class="orderBy"  type ="number"style="width:50%;display:block;margin:auto;" value="{{ $category['orderBy']}}"></div>
                    <div style="width:10%">
                        <input type="checkbox" class="toggle" {{ ($category['toggle'] ==1)? "checked":"" }}>
                    </div>
                    <div style="width:10%"></div>
                    <div style="width:20%" onclick="add(this)">增加item</div>
                </div>
                @foreach($items as $key =>$item)
                @if($category['categoryID'] == $item['categoryID'])
                <div class="item" style="display:flex; text-align:center;">
                    <div style="width:10%"> item
                    </div>
                    <div style="width:10%"><input class="name" style="width:100%" value="{{ $item['name']}}"></div>
                    <div style="width:10%">price</div>
                    <div style="width:10%"><input class="price"  type ="number"style="width:100%" value="{{ $item['price']}}"></div>
                    <div style="width:20%"><input class="orderBy"  type ="number"style="width:50%;display:block;margin:auto;" value="{{ $item['orderBy']}}"></div>
                    <div style="width:10%">
                        <input class="originOrderBy" type="hidden" value="{{ $item['orderBy']}}">   
                        <input type="checkbox" class="toggle" {{ ($item['toggle'] ==1)? "checked":"" }}>
                    </div>
                    <div style="width:10%"><input type="checkbox" class="del" ></div>
                    <input type="hidden" class="itemID" value="{{ $item['itemID']}}">
                </div>
                @endif
                @endforeach
                <button class="btn btn-primary mx-auto d-block" onclick="edit(this)">修改</button>
            </div>
            @endforeach

        </div>
    </div>
</div>

<script>
    function edit(obj) {
        let category = $(obj).siblings(".category").find(".name").val();
        let data = {
            category: {
                'name': $(obj).siblings(".category").find(".name").val(),
                'toggle': ($(obj).siblings(".category").find(".toggle").prop("checked")) ? 1 : 0,
                'originOrderBy': $(obj).siblings(".category").find(".originOrderBy").val(),
                'orderBy': $(obj).siblings(".category").find(".orderBy").val(),
                'categoryID': $(obj).siblings("input[type='hidden']").val(),
            },
            items: [],
        }
        let l = $(obj).siblings(".item").length;
        for (let i = 0; i < l; i++) {
            let item = {
                name: $(obj).siblings(".item").eq(i).find(".name").val(),
                price: $(obj).siblings(".item").eq(i).find(".price").val(),
                itemID: $(obj).siblings(".item").eq(i).find(".itemID").val(),
                toggle: ($(obj).siblings(".item").eq(i).find(".toggle").prop("checked")) ? 1 : 0,
                originOrderBy: $(obj).siblings(".item").eq(i).find(".originOrderBy").val(),
                orderBy: $(obj).siblings(".item").eq(i).find(".orderBy").val(),
                del: ($(obj).siblings(".item").eq(i).find(".del").prop("checked")) ? 1 : 0,
            };
            data.items.push(item);
        }

        console.log(data.items);

        $.ajax({
            url: "{{route('editMenu')}}",
            type: 'post',
            data: {
                data,
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success: function(res) {
                res = JSON.parse(res);
                console.log(res);
                alert(res.msg)
                if(parseInt(res.status) == 1){
                    location.reload();
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
    }

    function add(obj) {
        let item =`<div class="item" style="display:flex; text-align:center;">
                    <div style="width:10%"> add_Item
                    </div>
                    <div style="width:10%"><input class="name" style="width:100%" value=""></div>
                    <div style="width:10%">price</div>
                    <div style="width:10%"><input class="price" type ="number"style="width:100%" value=""></div>
                    <div style="width:20%"><input class="orderBy" type ="hidden" style="width:50%;display:block;margin:auto;" value=""></div>
                    <div style="width:10%">
                        <input class="originOrderBy" type="hidden" value="a">   
                        <input type="checkbox" class="toggle">
                    </div>
                    <input type="hidden" class="itemID" value="">
                </div>`;
        let l = $(obj).parent().siblings(".item").length;
        $(obj).parent().siblings(".item").eq((l-1)).after(item);
    }
</script>


@stop