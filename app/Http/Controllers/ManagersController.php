<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use Facade\FlareClient\Http\Response;

class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

   

    public function login(Request $request)
    {

        $account = $request->account;
        $pattan = "/^[a-zA-Z][0-9a-zA-z]+@\w+/";
        if (preg_match($pattan, $account)) {
            $row = Manager::where('account', $request->account)->get();
            if ($row->count() == 1 && $row[0]->password == sha1($request->password)) {



                // date_default_timezone_set("Asia/Taipei");
                // $manager->createTime =  date("U");
                // $manager->updateTime =  date("U");



                $token=md5($row[0]->managerID.date("U"));

                $res = ['stats' => 1, 'msg' => '登入成功','data'=>['token'=>$token]];
                
                // return response()->json($res)->withCookie(cookie('token',$token,3600));
                // return redirect('/');

            } else {
                $res = ['stats' => 0, 'msg' => 'account or password  error'];
            }
        }else{
            $res = ['stats' => 0, 'msg' => '帳號為信箱格式'];
        }

        echo json_encode($res);
    }

    public function logout()
    {
        session()->forget('manager');
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $manager = new Manager();
        $error = [];


        //account 檢驗
        $account = $request->account;
        $pattan = "/^[a-zA-Z][0-9a-zA-z]+@\w+/";
        if (preg_match($pattan, $account)) {
            $re = Manager::where('account', $request->account)->count();
            if(!$re){
                $manager->account = $request->account;
            }else{
                $error[] = "信箱重複";
            }
        } else {
            $error[] = "請輸入信箱格式";
        }


        //password 檢驗
        if (strlen($request->password) > 7 && strlen($request->password) < 17) {
            $a = preg_match("/\d+/", $request->password);
            $b = preg_match("/[a-z]+/", $request->password);
            $c = preg_match("/[A-Z]+/", $request->password);

            if ($a && $b && $c) {
                $manager->password = sha1($request->password);
            } else {
                $error[] = "須至少1個大寫字母、1個小寫字母及1個數字以上";
            }
        } else {
            $error[] = "密碼長度須介於8~16字元";
        }


        //name 檢驗
        $name = $request->name;
        if (strlen(trim($name)) > 0) {
            $manager->name = $request->name;
        } else {
            $error[] = "name 不得為空";
        }

        if (count($error) > 0) {
            echo json_encode(['status' => 0, 'msg' => implode("，",$error)]);
        } else {

            $manager->managerID =  md5($manager->count() + 1);

            date_default_timezone_set("Asia/Taipei");
            $manager->createTime =  date("U");
            $manager->updateTime =  date("U");

            $manager->save();
            unset($manager);


            echo json_encode(['status' => 1, 'msg' => '註冊成功']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
