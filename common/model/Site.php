<?php
namespace app\common\model;
use think\Model;

class Site extends Model
{
	//配置数据库连接参数
	protected $connection = 'db_qiye';

	//配置模型绑定的数据表
	protected $table = 'site';

	//配置数据表的主键id
	protected $pk = 'site_id';

	//开启自动时间戳功能
	protected $autoWriteTimestamp = true;

	//设置自动更新的字段名称
	protected $update_time = 'update_time';

	//如果时间字段为整型的时间戳,获取时会自动转换,可自定义格式
	protected $dateFormat = 'Y/m/d H:i:s';

	

}