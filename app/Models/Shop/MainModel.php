<?php

namespace App\Models\Shop;

use App\Models\BaseModel;

class MainModel extends BaseModel
{
    protected $table = "shop";

    public $timestamps = true; // 自动更新时间

    const UPDATED_AT = 'update_date'; // 修改修改时间名称
}
