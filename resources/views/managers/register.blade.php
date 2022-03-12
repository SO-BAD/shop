@extends('layouts/layout')

@section('content')
    
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-6 mx-auto mt-5 ">
            <form method ="post">
                @csrf
                <h1>Reg</h1>
                <div class="form-group">
                    <label for="account">account</label>
                    <input name = "account"type="text" class="form-control" id="account">
                    <small id="accountHelp" class="form-text text-muted">

                    </small>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name = "password"type="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name = "name"type="text" class="form-control" id="name">
                    <small id="nameHelp" class="form-text text-muted">

                    </small>
                </div>
                <div class="form-group">
                </div>
                <button type="button" class="btn btn-primary" onclick="reg()">Submit</button>
                <a  class="btn btn-primary" href="{{route('index')}}">返回</a>
            </form>

        </div>
    </div>
</div>

<script>   
    function reg(){
        $.post("{{ route('register')}}",
        {account:$("#account").val(),
         password:$("#password").val(),
         name:$("#name").val(),
        _token:'{{csrf_token()}}'},
        (res)=>{
            console.log(JSON.parse(res));
        })
    }

</script>
@stop