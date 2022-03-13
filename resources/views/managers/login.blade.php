<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>簡易系統</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="js/jquery-3.6.0.min.js"></script> -->
    <script>
        function logout() {
            $.getJSON("{{route('logout')}}", (res) => {
                console.log(res);
                alert(res.msg);
                location.href = "{{ route('index')}}";
            })
        }
    </script>
</head>

<body>
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
                <button type="button" class="btn btn-primary submit" onclick ="login()">Submit</button>
                <a  class="btn btn-primary" href="{{route('index')}}">返回</a>
            </form>

        </div>
    </div>
</div>

<script>
    function login(){
         $.post("{{ route('login')}}",
         {account:$("#account").val(),
            password:$("#password").val(),
            _token:'{{csrf_token()}}'
        },
         (res)=>{
             console.log(res);
             res = JSON.parse(res)
            if(parseInt(res.stats)==1){
                localStorage.setItem('token',res.data.token);
                alert(res.msg);
                location.href= "{{ route('index')}}";
            }else{
                alert(res.msg);
            }
        })
    }
    
    
</script>


</body>

</html>