<?php 
namespace app\admin\controller;
use app\common\controller\Base;
use app\common\model\User;
// use think\Db;

class Index extends Base
{
	//前置方法
	//所有操作都必须执行'isLogin'操作:检测是否已登录
	protected $beforeActionList = ['isLogin'];

	//渲染后台首页模板
	public function index()
	{
		
		//测试数据库是否连接成功?使用自定义的数据库连接参数
		// dump(Db::connect('db_qiye')->table('user')->find(1));
		// 测试模型操作是否正常?
		// User::update(['password'=>'123'],['user_id'=>1]);
		
		//因为后台模板中的静态资源文件的目录较长且不统一,使用__ADMIN__进行替换

		//可以在控制器中动态过滤或替换内容
		// $filter = function($content) {
		// 	return str_replace('./', '/static/admin/', $content);
		// };

		// return $this->view->filter($filter)->fetch();
		
		//考虑到多个模板文件都要用到字符串替换,所以写到了模板的配置文件中
		//applicaiton\admin\config/template.php
		return $this->view->fetch();
	}
	

	//渲染welcome欢迎页面
	public function welcome()
	{
		//欢迎页面是由框架加载进来的,无法直接使用字符替换功能,所以使用动态方式处理
		$filter = function($content) {
			return str_replace('__ADMIN__', '/static/admin', $content);
		};

		//替换静态资源路径后渲染模板
		return $this->view->filter($filter)->fetch();
	}

	//用来查询系统变量
	public function server()
	{
		dump($_SERVER);
	}
}