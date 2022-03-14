@extends('layouts.layout')



@section('title')
<h1>edit Item</h1>
@stop



@section('content')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                name<input type="text" id="name"><br>
                排序<input type="number" id="orderBy"><br>
                價錢<input type="number" id="price">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="edit()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!----------------------------------------------------------------------------------------------------------------->

<div class="container-fluid">
    <div class="row">
        @csrf
        <div class="col-12 mx-auto">
            <div class="d-flex text-center">
                <div style="width:10%;">sn</div>
                <div style="width:10%;">name</div>
                <div style="width:10%;">狀態</div>
                <div style="width:10%;">price</div>
                <div style="width:10%;">排序</div>
                <div style="width:20%;">操作</div>
            </div>
            @foreach($data as $k => $row)
            <div class="d-flex text-center">
                <div style="width:10%;">{{ ($k+1)}}</div>
                <div style="width:10%;">{{ $row['name']}}</div>
                <div style="width:10%;" onclick = "sh(this)">{{ ($row['toggle']==1)? "上架":"未上架" }}</div>
                <div style="width:10%;">{{ $row['price']}}</div>
                <div style="width:10%;">{{ $row['orderBy']}}</div>
                
                <input type="hidden" class="itemID" value="{{$row['itemID']}}">
                <div style="width:20%;">
                    <button onclick="model(this)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    編輯
                    </button>
                    <button onclick="del(this)" class="btn btn-primary"> 刪除</button>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<script>
var itemNowId = '';

function edit(){
    $.ajax({
            url: "{{route('editItem')}}",
            type: 'post',
            data: {
                itemID:itemNowId,
                name:$("#name").val(),
                orderBy:$("#orderBy").val(),
                price:$("#price").val(),
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success: function(res) {
                console.log(res);
                res = JSON.parse(res);
                alert(res.msg)
                if (parseInt(res.status) == 1) {
                    location.reload();
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
}









function model(obj) {
        let itemID = $(obj).parent().siblings(".itemID").val();
        console.log(itemID);
        $.ajax({
            url: "{{route('showItem')}}",
            type: 'post',
            data: {
                itemID,
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success: function(res) {
                console.log(res);
                res = JSON.parse(res);
                alert(res.msg)
                if (parseInt(res.status) == 1) {
                    $("#name").val(res.data.name);
                    $("#orderBy").val(res.data.orderBy);
                    $("#price").val(res.data.price);
                    itemNowId = itemID;
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
    }
    function sh(obj) {
        let itemID = $(obj).siblings(".itemID").val();
        console.log(itemID);
        $.ajax({
            url: "{{route('editItemSh')}}",
            type: 'post',
            data: {
                itemID,
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success: function(res) {
                console.log(res);
                res = JSON.parse(res);
                alert(res.msg)
                if (parseInt(res.status) == 1) {
                    location.reload();
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
    }









    function del(obj) {
        let itemID = $(obj).parent().siblings(".itemID").val();
        //    $(obj).parent().parent().remove();


        $.ajax({
            url: "{{route('delItem')}}",
            type: 'post',
            data: {
                itemID,
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success: function(res) {
                console.log(res);
                res = JSON.parse(res);
                alert(res.msg)
                if (parseInt(res.status) == 1) {
                    $(obj).parent().parent().remove();
                }
            },
            error: function(res) {
                console.log(res);
            }
        });






    }
</script>


@stop