@extends('layouts.layout')



@section('title')
<h1>del category</h1>
@stop



@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mx-auto">
            @csrf
            @foreach($categories as $category)
            <div style="display:flex;">
                <div style="width:10%">{{ $category['name'] }}</div>
                <div style="width:10%">
                    <input type="hidden" value="{{ $category['categoryID'] }}">
                    <button onclick="del(this)">刪除</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function del(obj) {
        let ck = confirm("確定刪除");
        if (ck) {
            $.ajax({
                url: "{{route('delCategory')}}",
                type: 'post',
                data: {
                    categoryID: $(obj).siblings("input[type='hidden']").val(),
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
    }
</script>


@stop