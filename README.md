# 代码开发规范
FIG 制定的 PHP 规范，简称 PSR，是 PHP 开发的事实标准。FIG 是 Framework Interoperability Group (框架可互用小组) 的缩写，由几位开源框架的开发者成立于 2009 年。该组织的目的在于：以最低程度的限制，来统一各个项目的编码规范，避免各家自行发展的风格阻碍了程序设计师开发的困扰。PSR 是 Proposing a Standards Recommendation (提出标准建议) 的缩写。

PSR 原来有五个规范，分别是：
- PSR-0 (Autoloading Standard) 自动加载标准。
- PSR-1 (Basic Coding Standard) 基础编码标准。
- PSR-2 (Coding Style Guide) 编码风格向导。
- PSR-3 (Logger Interface) 日志接口。
- PSR-4 (Improved Autoloading) 自动加载的增强版，可以替换掉 PSR-0 了。

> PHP 源文件缩进采用 4 个空格

> 很多编辑器使用 Tab 作为缩进。会造成空格性问题。

> 纯 PHP 代码的源文件关闭标签 ?> 必须省略

> PHP 解析器在对文件进行解释的时候，会有性能提升。并且，这能一定程序避免在 ?> 之后有多余的空格导致程序报错。

> 命名空间(namespace)的声明后面必须有一行空行

## 空行会让代码看起来更加清晰容易阅读。
``` php
<?php
	namespace core;

	use common;
```

所有的导入(use)声明必须放在命名空间(namespace)声明的下面
这样会让代码结构变得清晰容易阅读。
	

- 一句声明中，必须只有一个导入(use)关键字

- PHP 允许一行代码当中允许使用多个 use 关键字导入一个类。但是，这会使代码阅读造成障碍。

错误：
```php
<?php
namespace core;

	use common, library;
```

正确：

```php 
<?php
	namespace core;

	use common;
	use library;
```

## php代码的书写

- 变量、方法、类等命名必须要有意义
- 避免循环嵌套的写法
- 成员属性有三种访问修饰符：public、protected、private。不能使用老式的 var 来声音成员属性。
- 成员方法访问修饰符必须显示声明不能省略
- 方法的参数有多个的时候，每个参数的逗号后面必须加个空格
- 类的方法排序为 public、protected、private
- 类名命名必须为大驼峰（ShopOrder）
- 方法名命名必须为小驼峰（shopOrder）
- 参数、变量命名也许必须使用小驼峰
- 类名必须和文件名一致
- 所有方法的起始花括号必须另起一行。

错误：
```php
<?php

	class MySQL
	{
    		public function fetchOne() {
        
    		}
    }
```
正确：
```php
<?php

	class MySQL
	{
    		public function fetchOne() 
    		{
        
    		}
    }
```
> 数组书写
```php
$object->callFunc([
    'userId'   => 1,
    'username' => 'sam',
    'age'      => 20,
    'sex'      => 'male'
]);
```
> 方法参数注释
 **
 * 管理后台获取优惠券发送记录。
 *
 * @author 7031 2018-02-23
 * @modify 7031 2019-02-25 修复了 SQL 性能问题。
 *
 * @param int    $couponId      优惠券ID。
 * @param string $username      用户名。
 * @param string $mobilephone   用户手机号。
 * @param int    $page          当前分页页码。
 * @param int    $count         每页显示条数。
 * @param array  $data          请求参数。
 *
 * @return array
 */

## 路由规范
>路由书写必须遵守RESTful api设计规范
```php
// 商品路由组
    Route::prefix('good')->namespace('Admin\Good')->group(function () {
        Route::get('/', 'MainController@getList');
        Route::get('info', 'MainController@getInfo');
        Route::post('/', 'MainController@postCreate');
        Route::delete('/', 'MainController@delete');
    });
```
- 创建 【post】
- 修改 【put】
- 删除 【delete】
- 获取 【get】
- 不用大写
- 用中杠-不用下杠_
- 参数列表要encode
- URI中的名词表示资源集合，使用复数形式
## 状态码规范
 > 状态码	使用场景

- 400 bad request	常用在参数校验
- 401 unauthorized	未经验证的用户，常见于未登录。如果经过验证后依然没权限，应该 403（即 authentication 和 authorization 的区别）

- 403 forbidden	无权限
- 404 not found	资源不存在
- 500 internal server error
	非业务类异常
- 503 service unavaliable	由容器抛出，自己的代码不要抛这个异常

## 框架使用规范
- 控制器只负责处理简单的逻辑，复杂的业务放在Model里处理，同时也方便代码复用。
- 请求参数使用可框架自带验证器处理
- 权限认证使用可框架中间件处理
- 扩展尽量使用composer安装，方便更新与维护
- 数据表要使用框架的数据迁移功能备份
