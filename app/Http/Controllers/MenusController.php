<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategories;
use App\Models\MenuItems;

class MenusController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = [];
        $ck_reItem = [];
        $category = $request->all()['totalData']['category'];
        // print_r($category['name']);

        $items = $request->all()['totalData']['item'];

        // print_r($items);

        if (MenuCategories::where('name', $category['name'])->count()) {
            $error[] = "菜單種類重複";
        }

        foreach ($items as $item) {
            if (in_array($item['name'], $ck_reItem)) {
                $error[] = $item['name'] . "名稱重複";
            }

            if (MenuItems::where('name', $item['name'])->count()) {
                $error[] = $item['name'] . "名稱重複";
            };

            if ($item['price'] < 1) {
                $error[] = $item['price'] . "金額須大於0";
            }
            $ck_reItem[]  = $item['name'];
        }

        if (count($error)) {
            $res = ['status' => 0, 'msg' => implode(",", $error)];
            echo json_encode($res);
        } else {
            date_default_timezone_set("Asia/Taipei");
            $menuCategoryId = (MenuCategories::max('id') == 0) ? 1 : (MenuCategories::max('id') + 1);

            $menuCategory = new MenuCategories();
            $menuCategory->categoryID = md5($menuCategoryId);
            $menuCategory->orderBy = $menuCategoryId;
            $menuCategory->name = $category['name'];
            $menuCategory->toggle = $category['toggle'];
            $menuCategory->createdTime = date("U");
            $menuCategory->updatedTime = date("U");


            $menuCategory->save();



           
            $menuItemId = (MenuItems::max('id') == 0) ? 1 : (MenuItems::max('id') + 1);
            foreach ($items as $key=>$item) { 
                $menuItem = new MenuItems();
                $menuItem->itemID = md5(($menuItemId+$key));
                $menuItem->categoryID = md5($menuCategoryId);
                $menuItem->name = $item['name'];
                $menuItem->price = $item['price'];
                $menuItem->orderBy = ($menuItemId+$key);
                $menuItem->toggle = $item['toggle'];
                $menuItem->createdTime = date("U");
                $menuItem->updatedTime = date("U");
                $menuItem->save();
                unset($menuItem);
            }








            $res = ['status'=>1,'msg'=>"菜單建立成功"];
            echo json_encode($res);
        }


        // $menuCategory = new MenuCategories();





        //
        // echo $request->get('status');
        // return response()->json($res, 401);
        // $res = ['status' => 0, 'msg' => 'Unauthorized'];
        //             return response()->json($res, 401);
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
