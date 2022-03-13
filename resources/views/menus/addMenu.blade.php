@extends('layouts.layout')



@section('title')
<h1>add cotegory</h1>
@stop



@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mx-auto">
            <div class="">
                @csrf
                category name
                <input type="text" id ="category">
                <input type="radio" name ="categoryToggle" value="1" checked>上架
                <input type="radio" name ="categoryToggle"value="0">未上架
                <div onclick = "addItem()"style="display:inline-block;width:100px; height:30px;font-size:20px; background:#ddd;">新增item</div>
            </div>
            <div class="itemBox">
                <div class="item m-3 p-1" style="border:1px solid black">
                    item name <input type="text" class="itemName"> 
                    <input type="radio" name ="itemToggle1" value="1" checked>上架
                    <input type="radio" name ="itemToggle1"value="0">未上架
                    <br>
                    <br>
                    price <input type="number" min ="0" class="itemPrice"> 
                </div>
            </div>
            <button type ="button" onclick="add()">送出</button>
        </div>
    </div>
</div>

<script>
    function addItem(){
        let radioCount = $("input[type='radio']").length/2;

        let item = `<div class="item m-3 p-1" style="border:1px solid black">
                    item name <input type="text" class="itemName"> 
                    <input type="radio" name ="itemToggle${radioCount}" value="1" checked>上架
                    <input type="radio" name ="itemToggle${radioCount}"value="0">未上架
                    <br>
                    <br>
                    price <input type="number" min ="0" class="itemPrice"> 
                </div>`;
        $(".itemBox").append(item);
    }

    function add(){
        

        let totalData = {
            category:{  
                name:$("#category").val(),
                toggle:document.querySelector("input[name='categoryToggle']:checked").value
            },
            item:[],
        }
        let itemCount = document.querySelectorAll(".item").length;
        for(let i =0;i<itemCount;i++){
            totalData.item.push({
                name:document.querySelectorAll(".itemName")[i].value,
                toggle:document.querySelector("input[name='itemToggle"+(i+1)+"']:checked").value,
                price:document.querySelectorAll(".itemPrice")[i].value,
            })
        }


        // console.log(totalData);
        // $.post("{{route('addMenu')}}",
        // {totalData,
        //     _token:'{{csrf_token()}}'
        // },
        // (res)=>{
        //         console.log(res);
        // })
        $.ajax({
            url:"{{route('addMenu')}}",
            type:'post',
            data:{
                totalData,
                _token:'{{csrf_token()}}',
            },
            beforeSend: function(XMLHttpRequest) {
                //送出前的動作
                XMLHttpRequest.setRequestHeader('Authorization','Bearer '+localStorage.getItem('token'));
                // XMLHttpRequest.setRequestHeader('Authorization','Bearer');
            },
            success:function(res){
                console.log(res);
            },
            error:function(res){
                console.log(res);
            }
        });
    }
</script>


@stop