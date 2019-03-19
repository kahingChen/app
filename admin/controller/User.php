<?php 
namespace app\admin\controller;
use app\common\controller\Base;
use app\common\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;

class User extends Base
{
	//前置方法
	protected $beforeActionList = [
		//判断用户是否已登录?
		'islogined' => ['only'=>'login']
	];

	//用户登录
	public function login()
	{
		return $this->view->fetch();
	}

	//处理用户登录
	public function doLogin()
	{
		$email = Request::param('email');

		$password = sha1(Request::param('password'));

		$user = UserModel::get(1);

		if ($user['email']!=$email) {
			$res = ['status'=>0, 'msg'=>'邮箱错误'];
		} elseif ($user['password'] != $password) {
			$res = ['status'=>0, 'msg'=>'密码错误'];
		} else {
			$res = ['status'=>1, 'msg'=>'登陆成功'];
			//登录成功,将用户名设置到session会话中
			Session::set('user_name', $user['user_name']);
		}
		return $res;	
	}

	//用户退出
	public function logout()
	{
		//删除会话信息
		Session::delete('user_name');

		//跳转到用户登录界面
		$this->redirect('login');
	}


	//用户信息列表
	public function index()
	{
		//获取用户信息
		$user = UserModel::get(1);

		//将用户信息赋值到模板
		$this->view->assign('user', $user);

		//渲染用户列表模板
		return $this->view->fetch();
	}

	//沉浸用户编辑模板
	public function adminEdit()
	{
		//获取管理员信息
		$user = UserModel::get(1);

		//将管理员信息赋值到模板
		$this->view->assign('user', $user);

		//渲染管理员列表模板
		return $this->view->fetch();
	}

	//执行编辑保存操作
	public function doEdit()
	{
		//获取用户提交的数据
		$user = Request::param();
		
		//设置更新的字段
		$data = ['email' => $user['email'], 'password' => $user['password']];

		//设置更新条件
		$where = ['user_id' => 1];

		//更新用户表
		UserModel::update($data, $where);
	}
}