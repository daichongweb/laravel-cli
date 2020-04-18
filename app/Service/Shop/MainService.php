<?php

namespace App\Service\Shop;

use App\Models\Shop\MainModel;
use App\Service\BaseService;

class MainService extends BaseService
{
    protected static function model()
    {
        $model = new MainModel();
        return $model;
    }

    public function setName($name)
    {
        $this->model->name = $name;
        return $this;
    }

    // 添加之前执行的方法
    protected function beforCreate()
    {
    }
}
