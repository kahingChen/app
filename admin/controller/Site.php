<?php 
namespace app\admin\controller;
use app\common\controller\Base;
use app\common\model\Site as SiteModel;
use think\facade\Request;

class Site  extends Base
{
	//前置方法
	//所有操作都必须执行'isLogin'操作:检测是否已登录
	protected $beforeActionList = ['isLogin'];

	//显示站点信息
	public function index()
	{
		//获取网站信息
		$site = SiteModel::get(1);

		//将管理员信息赋值到模板
		$this->view->assign('site', $site);

		//渲染管理员列表模板
		return $this->view->fetch();

	}

	//渲染编辑模板
	public function edit()
	{
		//获取网站信息
		$site = SiteModel::get(1);

		//将管理员信息赋值到模板
		$this->view->assign('site', $site);

		//渲染管理员列表模板
		return $this->view->fetch();
	}

	//执行编辑保存操作
	public function doEdit()
	{
		//获取用户提交的数据
		$siteName = Request::param('site_name');
		$keywords = Request::param('keywords');
		$desc = Request::param('desc');
		
		//设置更新的字段
		$data = ['site_name' => $siteName, 'keywords' => $keywords, 'desc'=>$desc];

		//设置更新条件
		$where = ['site_id' => 1];

		//更新用户表
		SiteModel::update($data, $where);
	}
}