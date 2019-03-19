<?php 
namespace app\common\model;
use think\Model;

//配置软件功能
//1.导入模型中的软删除类
use think\model\concern\SoftDelete;

class Article extends Model
{
	//2.导入软删除的trait类
	use SoftDelete;

	//配置数据库连接参数
	protected $connection = 'db_qiye';

	//配置模型绑定的数据表
	protected $table = 'article';

	//配置数据表的主键id
	protected $pk = 'art_id';

	//开启自动时间戳功能
	protected $autoWriteTimestamp = true;

	//设置添加时间的字段名称
	protected $createTime = 'create_time';

	//设置自动更新的字段名称
	protected $updateTime = 'update_time';

	//如果时间字段为整型的时间戳,获取时会自动转换,可自定义格式
	protected $dateFormat = 'Y/m/d H:i:s';

	//3.设置支持软删除功能的时间字段名称
	protected $deleteTime = 'delete_time';

	//4.设置软删字段的默认值(5.1.9+),低于该版本请将删除字段值设置为:NULL
	protected $defaultSoftDelete = 0;

	
}















