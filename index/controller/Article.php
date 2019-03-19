<?php 
namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\Article as ArtModel;
use app\common\model\Category;

class Article extends Base 
{
	
	/**
	 * 编辑思路
	 * 1. 通过请求分发操作: dispatch()请用户请求定位到指定模板上
	 * 2. 页面类型分为二类: 单页面和列表页;
	 * 		单页面:适合关于我们,联系我们,专题,单面广告等
	 * 	 	列表页:适合展示更多的分类信息,相当于将信息分类后再逐一展示
	 * 3. 所以对应的模板也应该有二个:show()用来展示信息详情页,
	 * 		art_list.hmlt用来展示列表
	 * 4. 信息详情页的模板是单页面与列表页共用的
	 */
	public function dispatch()
	{
		//获取到当前分类id:从URL上直接以GET方式获取
		$cateId = $this->request->param('cate_id');	

		//根据分类id获取到分类名称,并将它设置为当前页面的标题
		// $title = Category::where('cate_id',$cateId)->value('cate_name');
		// 为了简化代码,我们还创建了一个公共函数,可根据id直接获取分类名称
		$title = getCateName($cateId);	

		//将当前分类名称做为页面标题赋值给模板变量
		$this->view->title = $title;

		//关键步骤: 获取分类类型,执行模板调度:0:单页面, 1: 列表页
		$cateType = getCateType($cateId);

		switch ($cateType) {
			case 0:  //单页面

				//获取页面的内容详情
				$content = ArtModel::where('cate_id',$cateId)->value('art_content');

				//将内容直接赋值给模板变量
				$this->view->content = $content;

				//调用模板:show()
				return $this->view->fetch('show');

				break;

			case 1:  //列表页

				//如果当前是单页面:即详情页
				//如果当前的URL中存在文档id,说明当前是通过列表页在访问详情页,即单页面展示内容
				if ($artId=$this->request->param('art_id')) {

					//因为当前URL中存在文档id参数:art_id,所以可以根据id获取到对应的文档内容
					$content = ArtModel::where('art_id',$artId)->value('art_content');

					//设置文档标题
					$title = ArtModel::where('art_id',$artId)->value('art_title');

					//将文档标题赋值给模板变量
					$this->view->title = $title;

					//将文档内容赋值给模板变量
					$this->view->content = $content;

					//渲染单页面模板: show.html
					return $this->view->fetch('show');

					break;
				}
				
				//默认为列表页,即URL中只有cate_id参数,没有文档id: art_id参数
				//根据当前的分类id来获取数据,因为一个栏目下会有多个文档对应,是典型的一对多关系,所以必然返回数组
				//所以,我们以分页数据的形式来展示数据: 每页10条,按发布时间降序显示,确保最新信息在最前面
				$artList = ArtModel::where('cate_id',$cateId)->order('create_time','desc')->paginate(10);

				//创建分页变量
				$page = $artList->render();

				//因为分类变量默认是在当前的模板扩展名之后添加?page=*,会自动删除掉当前分类id
				//这会导致只有第一页能正常显示,从第二页面全部失效,所以我们需要重写分页跳转地址
				//例如:将默认的:qiye.io/article/dispatch?page=2, 
				//修改成:qiye.io/article/dispatch?cate_id=$cateId&page=2
				//其实就是将原来url中的page,进行字符串拼装与替换,这步非常重要哟
				$page = str_ireplace('page','cate_id='.$cateId.'&page',$page);

				//将分类数据赋值给模板变量
				$this->view->artList = $artList;

				//将分类变量赋值给模板变量
				$this->view->page = $page;

				//调用列表模板art_list.html显示分页数据
				return $this->view->fetch('art_list');
				
				break;
		}
	}
}
