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
    @yield('title')
    @if(session('manager'))
    歡迎， {{session('manager')}}
    <button class="logout" type="button" onclick="logout()">登出</button>
    <p>請選擇管理項目</p>


    <a href="{{route('addMenuPage')}}">新增菜單</a>




    @else
    <a href="{{ route('loginPage')}}">登入</a>
    <a href="{{ route('register')}}">註冊</a>
    @endif
    @yield('content')


</body>

</html>