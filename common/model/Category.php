<?php
namespace app\common\model;
use think\model;

class Category extends Model 
{
	//配置数据库连接参数
	protected $connection = 'db_qiye';

	//配置模型绑定的数据表
	protected $table = 'category';

	//配置数据表的主键id
	protected $pk = 'cate_id';

	//获取器: 获取分类栏目的中文名称
	protected function getCateTypeAttr($cateType)
	{
		return $cateType ? '列表页' : '单页面';
	}
	

}