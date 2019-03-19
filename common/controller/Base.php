<?php 
namespace app\common\controller;
use think\Controller;
use think\facade\Session;
use think\facade\Request;
use app\common\model\Site;

/**
 * 公共控制器
 * 1.项目所有控制器都应该继承它
 * 2.将一些公共操作或初始化操作放在这里面供所有控制器类共享
 */
class Base extends Controller
{
	//创建一个属性:站点信息,供所有控制器的操作直接使用
	protected $site = null;
	protected function initialize()
    {	
    
    	parent::initialize();

    	//1.设置页面的TDK信息(title,descoription,keywords)
        $this->site = Site::get(1);
        $this->view->site_name = $this->site->site_name;
        $this->view->desc = $this->site->desc;
        $this->view->keywords = $this->site->keywords;

    	$this->filter(function($content) {
			return str_replace(
				[
					'__ADMIN__',
					'__INDEX__'
				], 
				[
					'/static/admin',
					'/static/index'
				], $content);
		});

	}

	//判断用户是否已登录?应该放在公共控制器供所有控制器共享
	protected function isLogin()
	{
		//如果没有登录,并且当前操作不是登录,则提示用户登录并跳转到登录页面
		if (!Session::has('user_name')){
			$this->redirect('user/login');
		}		

	}

	//判断用户是否已经登录了?如果已登录,应该提示用户不要重复登录
	protected function islogined()
	{
		if(Session::has('user_name')) {
			$this->error('不要重复登录');
		}
	}
    	
    
}