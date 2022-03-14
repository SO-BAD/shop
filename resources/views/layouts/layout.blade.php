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
            $.getJSON("{{route('logout')}}",{'token':localStorage.getItem('token')}, (res) => {
                console.log(res);
                alert(res.msg);
                location.href = "{{ route('index')}}";
            })
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
</head>

<body>
    @yield('title')
    @if(session('manager'))
    歡迎， {{session('manager')}}
    <button class="logout" type="button" onclick="logout()">登出</button>
    <p>請選擇管理項目</p>


    <a href="{{route('addMenuPage')}}">新增菜單</a>
    <a href="{{route('editMenuPage')}}">修改菜單</a>
    <a href="{{route('delCategoryPage')}}">刪除種類</a>
    <a href="{{route('editItemPage')}}">修改品項</a>




    @else
    <a href="{{ route('loginPage')}}">登入</a>
    <a href="{{ route('register')}}">註冊</a>
    @endif
    @yield('content')


</body>

</html>