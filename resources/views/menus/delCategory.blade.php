@extends('layouts.layout')



@section('title')
<h1>del category</h1>
@stop



@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mx-auto">
            @csrf
            {{print_r($categories)}}
        </div>
    </div>
</div>

<script>
    function del(){
        $.ajax({
            url: "{{route('delCategory')}}",
            type: 'post',
            data: {
                // itemID,
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success: function(res) {
                console.log(res);
                // res = JSON.parse(res);
                // alert(res.msg)
                // if (parseInt(res.status) == 1) {
                //     location.reload();
                // }
            },
            error: function(res) {
                console.log(res);
            }
        });
    }
</script>


@stop