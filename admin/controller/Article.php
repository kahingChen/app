<?php 
namespace app\admin\controller;
use app\common\controller\Base;
use app\common\model\Article as ArtModel;
class Article extends Base 
{
	//前置方法
	//所有操作都必须执行'isLogin'操作:检测是否已登录
	protected $beforeActionList = ['isLogin'];
	
	//首页文档列表
	public function index()
	{	

		$arts=ArtModel::order('create_time','desc')->paginate(8);
		$this->view->arts = $arts;
		return $this->view->fetch();
	}


	//渲染添加文档界面
	public function artAdd()
	{
		return $this->view->fetch();
	}

	//执行添加操作
	public function doAdd()
	{
		//获取用户要添加的数据
		$data = $this->request->param();

		//将数据添加到表中,并判断是否添加成功,如失败由客户端处理
		if (ArtModel::create($data,true)) {
			return ['status'=>1, 'msg'=>'添加成功'];
		}
	}

	//渲染编辑文档界面
	public function artEdit()
	{
		//编辑是基于查询的,所以必须先获取到要编辑的文档id
		$artId = $this->request->param('art_id');

		//获取到要更新的记录信息,并赋值给模板变量art
		$this->view->art = ArtModel::get($artId);

		//渲染文档编辑模板
		return $this->view->fetch();
	}


	//处理编辑数据的保存
	public function doEdit()
	{
		$data = $this->request->param();
		
		if(ArtModel::update($data)) {
			return ['status'=>1, 'msg'=>'更新成功'];
		}
	}


	public function del()
	{
		$artId = $this->request->param('art_id');

		if (ArtModel::destroy($artId)) {
			return ['status'=>1, 'msg'=>'删除成功'];
		}
	}

	public function delAll()
	{
		$idList = $this->request->param('id_list');
		$idList = json_decode($idList);
		if (ArtModel::destroy($idList)) {
			return ['status'=>1, 'msg'=>'删除成功'];
		}
	}



	//处理富文本编辑器中的图片上传
	public function upload()
	{
		//接收图片信息,创建文件对象
		$file = $this->request->file('img');

		//将文件移动到目录目录中,并将结果返回给客户端处理
		if($info = $file->validate(['ext'=>'jpg,jpeg,png,gif'])->move('upload')){

			//客户端要求返回的必须是JSON格式数据,默认没有加上上传目录,需要手工添加一下
			return json(['errno'=>0, 'data'=>['/upload/'.$info->getSaveName()]]);
		} else {

			//处理出错信息,其实客户端也会处理的,可省略
			return $file->getError();
		}
	}

}