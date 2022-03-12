@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-6 mx-auto mt-5 ">
            <form method="post">
            @csrf
                <h1>login</h1>
                <div class="form-group">
                    <label for="account">Account</label>
                    <input type="text" name ="account"class="form-control" id="account" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">請輸入信箱</small>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password"  name ="password"class="form-control" id="password">
                </div>
                <div class="form-group">
                </div>
                <button type="button" class="btn btn-primary submit" onclick ="s()">Submit</button>
                <a  class="btn btn-primary" href="{{route('index')}}">返回</a>
            </form>

        </div>
    </div>
</div>

<script>
    function s(){
         $.post("{{ route('login')}}",
         {account:$("#account").val(),
            password:$("#password").val(),
            _token:'{{csrf_token()}}'
        },
         (res)=>{
             res = JSON.parse(res)
            if(parseInt(res.stats)==1){
                localStorage.setItem('token',res.data.token);
            }else{
                console.log(res.msg);
            }
        })
    }
    
        // var form = new FormData(document.querySelector("form"));
        // $.post("/login",form,(res)=>{
        //     console.log(res);
        // })
        
        // $.ajax({
        //     url:"/login",
        //     data:form,
        //     type:'post',
        //     processData:false,
        //     contentType:false,
        //     cache:false,
        //     success:function(res){
        //         console.log(res);
        //     },
        //     error:function(res){
        //         console.log(res);
        //     }
        // })
        
    
</script>


@stop