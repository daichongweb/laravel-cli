<?php

namespace App\Http\Controllers\Web\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\MainRequest;
use App\Exceptions\AppException;
use App\Helper\AjaxHelper;
use App\Models\Shop\MainModel;
use App\Service\Shop\MainService;

class MainController extends Controller
{
    public function index(MainRequest $request)
    {
        if ($request->getCurrentValidator()->fails()) {
            throw new AppException($request->getCurrentValidator()->errors()->first());
        }
        $id = $request->input('id');
        $name = $request->input('name');
        $model = null;
        if ($id) {
            $model = MainModel::find($id);
            if (!$model) throw new AppException('商品不存在');
        }
        $shopServer = new MainService($model);
        $shopServer->setName($name);
        $request = $shopServer->save();
        // $request->id; // 获得自增id
        if ($request) {
            return AjaxHelper::success('操作成功');
        }
        throw new AppException('网络错误');
    }
}
