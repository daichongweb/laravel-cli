<?php

namespace App\Service;

use App\Exceptions\AppException;

/**
 * 基类服务器 BaseService
 * @author daichongweb <daichongweb@foxmail.com>
 */
abstract class BaseService
{
    protected $model;
    protected $delete = true;
    private $_create = false;

    public function __construct($model = null)
    {
        if (!$model) {
            $model = $this->model();
            $this->_create = true;
        }
        $this->model = $model;
        return $this;
    }

    /**
     * 是否创建操作
     * @return boolean
     */
    protected function isCreate()
    {
        return $this->_create;
    }

    //保存前操作
    protected function beforSave()
    {
    }

    //创建前操作
    protected function beforCreate()
    {
    }

    //保存后操作
    protected function afterSave()
    {
    }

    //创建后操作
    protected function afterCreate()
    {
    }

    public function save()
    {
        if ($this->isCreate()) {
            $beforResult = $this->beforCreate();
            if ($beforResult === false) {
                return NULL;
            }
            $this->callBeforCreate();
        }
        $beforResult = $this->beforSave();
        if ($beforResult === false) {
            return NULL;
        }
        $this->callBeforSave();

        $this->model->save();

        if ($this->isCreate()) {
            $this->afterCreate();
            $this->callAfterCreate();
        }
        $this->afterSave();
        $this->callAfterSave();

        $this->_create = false;
        return $this->model;
    }

    //删除前操作
    protected function beforDelete()
    {
    }

    //删除后操作
    protected function afterDelete()
    {
    }

    public function delete()
    {
        if (!$this->delete) {
            throw new AppException('无法删除', 500);
        }
        $this->beforDelete();
        $this->callBeforDelete();
        $this->model->delete();
        $this->afterDelete();
        $this->callAfterDelete();
    }

    public function getModel()
    {
        return $this->model;
    }

    //保存前
    private $beforSaveFuns = [];
    protected function setBeforSave(\Closure $fun)
    {
        $this->beforSaveFuns[] = $fun;
    }
    private function callBeforSave()
    {
        foreach ($this->beforSaveFuns as $value) {
            call_user_func($value);
        }
    }

    //保存后
    private $afterSaveFuns = [];
    protected function setAfterSave(\Closure $fun)
    {
        $this->afterSaveFuns[] = $fun;
    }
    private function callAfterSave()
    {
        foreach ($this->afterSaveFuns as $value) {
            call_user_func($value);
        }
    }

    //创建前
    private $beforCreateFuns = [];
    protected function setBeforCreate(\Closure $fun)
    {
        $this->beforCreateFuns[] = $fun;
    }
    private function callBeforCreate()
    {
        foreach ($this->beforCreateFuns as $value) {
            call_user_func($value);
        }
    }

    //创建后
    private $afterCreateFuns = [];
    protected function setAfterCreate(\Closure $fun)
    {
        $this->afterCreateFuns[] = $fun;
    }
    private function callAfterCreate()
    {
        foreach ($this->afterCreateFuns as $value) {
            call_user_func($value);
        }
    }

    //删除前
    private $beforDeleteFuns = [];
    protected function setBeforDelete(\Closure $fun)
    {
        $this->beforDeleteFuns[] = $fun;
    }

    private function callBeforDelete()
    {
        foreach ($this->beforDeleteFuns as $value) {
            call_user_func($value);
        }
    }

    //删除后
    private $afterDeleteFuns = [];
    protected function setAfterDelete(\Closure $fun)
    {
        $this->afterDeleteFuns[] = $fun;
    }

    private function callAfterDelete()
    {
        foreach ($this->afterDeleteFuns as $value) {
            call_user_func($value);
        }
    }
}
