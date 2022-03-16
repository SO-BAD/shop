<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MenuCategories;
use App\Models\MenuItems;


class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editItemSh(Request $req)
    {
        $row = MenuItems::where('itemID', $req->itemID)->first();
        if ($row->count()) {
            $row->toggle = ($row->toggle + 1) % 2;
            $msg = ($row->toggle == 1) ? "上架" : "下架";
            $row->save();
            $res = ['status' => 1, 'msg' => $msg . '成功'];
        } else {
            $res = ['status' => 0, 'msg' => '查無資料'];
        }
        echo json_encode($res);
    }

    public function editItem(Request $req)
    {
        $error = [];
        if (trim($req->name) == "") {
            $error[] .= "name不得為空";
        }
        if ($req->price < 1) {
            $error[] .= "價格需大於0";
        }
        $orderBy = MenuItems::where('orderBy', $req->orderBy)->get();
        if ($orderBy->count() == 0) {
            $error[] .= "排序查無資料";
        }

        if (count($error)) {
            $res = ['status' => 0, 'msg' => implode(",", $error)];
        } else {
            $row = MenuItems::where('itemID', $req->itemID)->first();
            if ($row->count()) {

                if ($req->orderBy != $row->orderBy) {
                    $swData = MenuItems::where('orderBy', $req->orderBy)->first();
                    $swData->orderBy = $row->orderBy;
                    $swData->save();

                    $row->orderBy = $req->orderBy;
                }

                $row->name = $req->name;
                $row->price = $req->price;
                $row->save();
                $res = ['status' => 1, 'msg' => '修改完成'];
            } else {
                $res = ['status' => 0, 'msg' => '查無資料'];
            }
        }

        echo json_encode($res);
    }


    public function showItem(Request $req)
    {
        $row = MenuItems::where('itemID', $req->itemID)->first();

        if ($row->count()) {
            $res = ['status' => 1, 'msg' => '取得資料', 'data' => ['name' => $row->name, 'orderBy' => $row->orderBy, 'price' => $row->price]];
        } else {
            $res = ['status' => 0, 'msg' => '查無資料'];
        }
        echo json_encode($res);
    }


    public function showItems()
    {
        $data = MenuItems::all();
        return view("menus.editItem", ['data' => $data]);
        // return MenuItems::all();
    }

    public function showMenus()
    {
        $categories = MenuCategories::all();
        $items = MenuItems::all();
        return view("menus.editMenu", ['categories' => $categories, 'items' => $items]);
        // return MenuItems::all();
    }

    public function showOnMenus()
    {
        // $categories = MenuCategories::where("toggle", 1)->orderBy("orderBy", "DESC")->get();
        // $items = MenuItems::where("toggle", 1)->orderBy("orderBy", "DESC")->get();
        // $data = MenuItems::where("toggle", 1)->orderBy("orderBy", "DESC")->get();
        // $data = MenuItems::where("toggle", 1)->get();
        $data = DB::select("select items.name as iName, items.price,items.orderBy, cate.name from menuitems as items join menucategories as cate on items.categoryID = cate.categoryID AND items.toggle = 1 AND cate.toggle = 1 order by cate.orderBy, items.orderBy ");






        // return view("menus.showOnMenus", ['categories' => $categories, 'items' => $items]);
        return view("menus.showOnMenus", ['data' => $data]);







    }

    public function getOnMenus()
    {
        $categories = MenuCategories::where("toggle", 1)->orderBy("orderBy", "DESC")->get();
        $items = MenuItems::where("toggle", 1)->orderBy("orderBy", "DESC")->get();
        $res = ['status' => 1, "msg" => "成功取得菜單內容", "data" => []];
        foreach ($categories as $category) {
            $data = [
                "categoryID" => $category['categoryID'],
                "name" => $category['name'],
                "menuItems" => [],
            ];
            foreach ($items as $item) {
                if ($category['categoryID'] == $item['categoryID']) {
                    $data['menuItems'][] = [
                        'name' => $item['name'],
                        'price' => $item['price'],
                    ];
                }
            }
            $res['data'][] = $data;
        }
        echo json_encode($res);
    }


    public function delItem(Request $req)
    {
        $row = MenuItems::where('itemID', $req->itemID);
        if ($row->count()) {
            $row->delete();
            $res = ['status' => 1, 'msg' => '刪除成功'];
        } else {
            $res = ['status' => 0, 'msg' => '查無資料'];
        }
        echo json_encode($res);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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


        if ($category['name'] == "") {
            $error[] = "category不得為空";
        }


        foreach ($items as $item) {

            if ($item['name'] == "" || $item['price'] == "") {
                $error[] = "item不得為空";
            }
            if (in_array($item['name'], $ck_reItem)) {
                $error[] = $item['name'] . "名稱重複";
            }

            if (MenuItems::where('name', $item['name'])->count()) {
                $error[] = $item['name'] . "名稱重複";
            };

            if ($item['price'] < 1) {
                $error[] = $item['name'] . "金額須大於0";
            }
            $ck_reItem[]  = $item['name'];
        }








        if (count($error)) {
            $res = ['status' => 0, 'msg' => implode(",", $error)];
        } else {
            date_default_timezone_set("Asia/Taipei");




            $name = MenuCategories::where('name', $category['name']);
            if ($name->count()) {
                $menuCategoryId = $name->first()->categoryID;
            } else {
                $id = MenuCategories::max('id');

                $menuCategoryId = ( $id== 0) ? 1 : ($id + 1);

                $menuCategory = new MenuCategories();
                $menuCategory->categoryID = md5($menuCategoryId);
                $menuCategory->orderBy = $menuCategoryId;
                $menuCategory->name = $category['name'];
                $menuCategory->toggle = $category['toggle'];
                $menuCategory->createdTime = date("U");
                $menuCategory->updatedTime = date("U");


                $menuCategory->save();
            }







            $menuItemId = MenuItems::max('id') +1;

            $itemMaxOrderBy = MenuItems::max('orderBy');
            $saveData = [];
            foreach ($items as $key => $item) {
                
                $categoryID = (strlen($menuCategoryId) == 32) ? $menuCategoryId : md5($menuCategoryId);
                $saveData[] = ['itemID'=>md5($menuItemId + $key),
                'categoryID'=>$categoryID,
                'name'=> $item['name'],
                'price'=> $item['price'],
                'orderBy'=> ($itemMaxOrderBy + $key +1),
                'toggle'=> $item['toggle'],
                'createdTime'=> date("U"),
                'updatedTime'=> date("U"),
            ];
            
            // $menuItem = new MenuItems();
                // $menuItem->itemID = md5(($menuItemId + $key));
                // $menuItem->categoryID = (strlen($menuCategoryId) == 32) ? $menuCategoryId : md5($menuCategoryId);

                // $menuItem->name = $item['name'];
                // $menuItem->price = $item['price'];
                // $menuItem->orderBy = ($itemMaxOrderBy + $key +1);
                // $menuItem->toggle = $item['toggle'];
                // $menuItem->createdTime = date("U");
                // $menuItem->updatedTime = date("U");
                // $menuItem->save();
            }
            MenuItems::insert($saveData);

            $res = ['status' => 1, 'msg' => "菜單建立成功"];
        }
        echo json_encode($res);
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
    public function edit(Request $req)
    {
        //
        $category = $req->data['category'];
        // print_r($category);
        $items = $req->data['items'];
        // print_r($items);    

        $error = [];
        $ck_reItem = [];
        $ck_ewOrderBy = [];

        if ($category['name'] == "" || $category['orderBy'] == "") {
            $error[] = "category不得為空";
        }

        $rowGet = MenuCategories::where('name', $category['name'])->get();
        $row = MenuCategories::where('name', $category['name'])->first();

        if ($rowGet->count() && $row->categoryID != $category['categoryID']) {
            $error[] = "category repeat";
        }


        foreach ($items as $item) {
            if (($item['name'] == "" || $item['price'] == "" || $item['orderBy'] == "") && $item['itemID'] != "") {
                $error[] = "修改不得為空";
            }
            if (($item['name'] == "" || $item['price'] == "") && $item['itemID'] == "") {
                $error[] = "新增不得為空";
            }

            if (in_array($item['name'], $ck_reItem)) {
                $error[] = $item['name'] . "名稱重複";
            }

            if (in_array($item['orderBy'], $ck_ewOrderBy)) {
                $error[] = $item['name'] . "排序重複";
            }

            if ($item['price'] < 1) {
                $error[] = $item['name'] . "金額須大於0";
            }
            $ck_reItem[]  = $item['name'];

            if ($item['orderBy'] != "")
                $ck_ewOrderBy[] = $item['orderBy'];
        }



        if (count($error)) {
            $res = ['status' => 0, 'msg' => implode(",", $error)];
        } else {


            $category2 = MenuCategories::where("orderBy", $category['orderBy']);
            if ($category2->count()) {
                $category2 = MenuCategories::where("orderBy", $category['orderBy'])->first();
                $category2->orderBy = $category['originOrderBy'];
                $category2->updatedTime = date("U");
                $category2->save();
            }

            try {
                $category1 = MenuCategories::where("categoryID", $category['categoryID'])->first();
                $category1->orderBy = $category['orderBy'];
                $category1->name = $category['name'];
                $category1->toggle = $category['toggle'];
                $category1->updatedTime = date("U");
                $category1->save();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            $saveData = [];
            $maxItemID = MenuItems::max('id') +1 ;
            $maxItemOrderBy = MenuItems::max('orderBy') +1;
            foreach ($items as $item) {
                if ($item['del']) {
                    $nowItem = MenuItems::where('itemID', $item['itemID'])->first();
                    $nowItem->delete();
                } else if ($item['itemID'] == "") {

                    $saveData[] = [
                                    'itemID'=>md5($maxItemID),
                                    'categoryID'=>$category['categoryID'],
                                    'name'=>$item['name'],
                                    'price'=>$item['price'],
                                    'orderBy'=>$maxItemOrderBy,
                                    'toggle'=>$item['toggle'],
                                    'createdTime'=>date("U"),
                                    'updatedTime'=>date("U"),
                                    ];
                    $maxItemID++;
                    $maxItemOrderBy++;

                    // $nowItem = new MenuItems();

                    // $nowItem->itemID = md5(MenuItems::max('id') + 1);
                    // $nowItem->categoryID = $category['categoryID'];
                    // $nowItem->name = $item['name'];
                    // $nowItem->price = $item['price'];
                    // $nowItem->orderBy = (MenuItems::max('orderBy') + 1);

                    // $nowItem->toggle = $item['toggle'];
                    // $nowItem->createdTime = date("U");
                    // $nowItem->updatedTime = date("U");

                    // $nowItem->save();

                } else if ($item['itemID'] != "") {
                    $nowItem = MenuItems::where('itemID', $item['itemID'])->first();
                    $nowItem->name = $item['name'];
                    $nowItem->price = $item['price'];
                    $nowItem->orderBy = $item['orderBy'];
                    $nowItem->toggle = $item['toggle'];
                    $nowItem->updatedTime = date("U");

                    $nowItem->save();
                }
            }
            if(count($saveData))
                MenuItems::insert($saveData);



            $res = ['status' => 1, 'msg' => "菜單編輯成功"];
        }
        echo json_encode($res);
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
    public function showCategories()
    {
        $categories = MenuCategories::all();
        return view("menus.delCategory", ['categories' => $categories]);
    }

    public function del(Request $req)
    {
        //
        $rows = MenuItems::where("categoryID", $req->categoryID);
        if ($rows) {
            for ($i = 0; $i < $rows->get()->count(); $i++) {
                $row = MenuItems::where("categoryID", $req->categoryID)->first();
                $row->delete();
            }
        }

        $rows = MenuCategories::where("categoryID", $req->categoryID);
        if ($rows->get()->count()) {
            $row = MenuCategories::where("categoryID", $req->categoryID)->first();
            $row->delete();
            $res = ['status' => 1, 'msg' => '刪除成功'];
        } else {

            $res = ['status' => 0, 'msg' => '查無資料'];
        }
        echo json_encode($res);
    }
}
 