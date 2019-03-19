<?php 
namespace app\admin\controller;
use app\common\controller\Base;
use app\common\model\Article;

class Trash extends Base 
{
	//前置方法
	//所有操作都必须执行'isLogin'操作:检测是否已登录
	protected $beforeActionList = ['isLogin'];
	//回收站中的文档列表与操作入口
	public function index()
	{
		$arts = Article::onlyTrashed()->paginate(8);
		$this->view->arts = $arts;
		return $this->view->fetch();
	}

	//真实单条删除记录
	public function delTrue()
	{
		$artId = $this->request->param('art_id');

		if (Article::destroy($artId, true)) {
			return ['status'=>1, 'msg'=>'删除成功'];
		}
	}

	//真实批量删除记录
	public function delTrueAll()
	{
		$idList = $this->request->param('id_list');
		$idList = json_decode($idList);
		if (Article::destroy($idList,true)) {
			return ['status'=>1, 'msg'=>'删除成功'];
		}
	}

	//恢复软删除的单个文档
	public function restore()
	{
		$artId = $this->request->param('art_id');
		$art = Article::onlyTrashed()->where('art_id',$artId)->find();
		if ($art->restore()) {
			return ['status'=>1, 'msg'=>'恢复成功'];
		}
	}

	//批量恢复软删除的文档
	public function resAll()
	{
		$idList = $this->request->param('id_list');
		$idList = json_decode($idList);
		$arts = Article::onlyTrashed()->select($idList);
		foreach ($arts as $art) {
			$art->restore();
		}
		return ['status'=>1, 'msg'=>'恢复成功'];
		
	}
}

