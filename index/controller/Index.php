<?php
namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\Category;
use app\common\model\Article;


class Index extends Base
{
    public function index()
    {
    	//1.页面标题
    	

        // //1.设置页面的TDK信息(title,descoription,keywords)
       
        $this->view->title = '首页';
       

    	//2.栏目名称: 因为每个页面中都有导航,在模板中直接获取更方便
        //你也可以写在Base.php控制器的初始化方法中,也可以创建自定义函数解决:common.php
    	// $this->view->cates = Category::order('cate_order','asc')->select();

    	//3.新闻列表
    	$this->view->news = Article::all(function($query){
    		$query->where('cate_id',2)->order('create_time','desc')->limit(10);
    	});

    	//4.产品列表
    	$this->view->products = Article::all(function($query){
    		$query->where('cate_id',3)->order('create_time','desc')->limit(10);;
    	});


        return $this->view->fetch();
    }


}
