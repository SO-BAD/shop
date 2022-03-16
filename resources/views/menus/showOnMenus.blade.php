@extends('layouts.layout')



@section('title')
<h1>Show On Menu</h1>
@stop



@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mx-auto" id="origin">
            <div>
                <button onclick="get()">json</button>
            </div>
            <div class="">
                <div class="d-flex text-center ">
                    <div style="width:10% ;color:red;">
                    </div>
                    <div style="width:10%">Name</div>
                    <div style="width:10%"></div>
                    <div style="width:10%">Price</div>
                    <div style="width:20%">orderBy</div>
                </div>
            </div>
            <pre>
            {{ print_r($data) }}
            </pre>
        </div>
        <div class="col-12 mx-auto" id="app">

            
        </div>
    </div>
</div>

<script>
    function get() {
        $.ajax({
            url: "{{route('getOnMenus')}}",
            type: 'get',
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success: function(res) {
                res = JSON.parse(res);
                console.log(res);
                // $("#origin").remove();
                // vue(res.data);
            },
            error: function(res) {
                console.log(res);
            }
        });
    }

    function vue(data) {
        let content = `<div v-for="category in arr" class="mb-5">
                <h3 style="background:gainsboro;">@{{ category.name }}</h3>
                <div v-for="item in category.menuItems">
                    <li>
                        @{{ item.name }}
                        @{{ item.price }}
                    </li>
                </div>
            </div>`;
        $("#app").html(content);
        let v = {
            data() {
                return {
                    arr: data,
                }
            }
        };

        Vue.createApp(v).mount("#app");
    }
</script>


@stop