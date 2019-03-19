<?php 
namespace app\admin\controller;
use app\common\controller\Base;
use app\common\model\Category as CategoryModel;

class Category extends Base
{
	protected $beforeActionList = ['isLogin'];

	//分类列表与操作入口
	public function index()
	{
		//获取分类数据
		$cates = CategoryModel::all(function($query){
			$query->order('cate_id','asc');
		});
		
		//将分类数据赋值到模板show.html
		$this->view->cates = $cates;

		//渲染分类模板
		return $this->view->fetch();
	}

	//渲染分类编辑模板
	public function cateEdit()
	{
		//获取要修改的分类id: cateId
		$cateId =$this->request->param('cateId');

		//根据当前分类id,获取对应的分类名称,返回的是json对象
		$cate = CategoryModel::get($cateId);		

		//模板赋值:分类名,分类id,分类排序
		$this->view->cate = $cate;

		//渲染分类编辑模板
		return $this->view->fetch();
	}

	public function doEdit()
	{
		//根据分类id查询分类模型,并返回分类模板的实例对象
		$cate = CategoryModel::get($this->request->param('cate_id'));

		//直接更新分类实例的对应字段信息:以对象属性方式
		$cate->cate_name = $this->request->param('cate_name');
		$cate->cate_order = $this->request->param('cate_order');
		$cate->cate_type = $this->request->param('cate_type');

		//更新模型并判断是否成功?
		if ($cate->save()) {

			//可以返回状态0/1之间切换来测试前端的提示信息
			return ['status'=>1, 'msg'=>'更新成功'];
		}
	}

	//渲染添加分类模板
	public function cateAdd()
	{
		//因为不涉及查询,所以不用模板赋值,直接渲染分类添加界面即可
		return $this->view->fetch();
	}

	//执行添加分类操作
	public function doAdd()
	{
		$cate = new CategoryModel();

		//直接更新分类实例的对应字段信息:以对象属性方式
		$cate->cate_name = $this->request->param('cate_name');
		$cate->cate_order = $this->request->param('cate_order');
		$cate->cate_type = $this->request->param('cate_type');

		//更新模型并判断是否成功?
		if ($cate->save()) {

			//可以返回状态0/1之间切换来测试前端的提示信息
			return ['status'=>1, 'msg'=>'添加成功'];
		}
	}

	//执行删除操作
	public function delete()
	{
		if(CategoryModel::destroy($this->request->param('cate_id')))
		{	
			//如果删除成功,将成功提示返回客户端,错误提示由客户端自行设置
			return ['status'=>1, 'msg'=>'删除成功'];
		}
	}
	


}