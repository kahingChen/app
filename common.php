<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// 
// <?php
//admin模块的公共函数文件
use think\Db;

//获取用户名
function getUserName()
{
	return Db::connect('db_qiye')->table('user')->value('user_name');
}

//获取当前时间
function getCurrentTime()
{
	return date('Y-m-d H:i:s', time());
}

//获取MySQL版本号
function getMysqlVersion()
{
	return Db::connect('db_qiye')->query('SELECT VERSION() AS version')[0]['version'];
}

//获取ip对应的城市:使用淘宝ip地址库
function getCity()
{
	$ip = $_SERVER['REMOTE_ADDR']; //获取客户端IP地址
	// $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
	$url = 'http://ip.taobao.com/service/getIpInfo.php?ip=183.160.0.134';
	$res =json_decode(file_get_contents($url, true), true);
	return $res['data']['city'];
}

//获取数据表中记录数量
function getRecNum($table)
{
	//删除字段为0表示是正常数据(即没有被删除过的数据)
	return Db::connect('db_qiye')->table($table)->where('delete_time',0)->count();
}

//获取已删除的记录数量
function getTrashNum($table) 
{
	//如果使用模型应该使用: onlyTrashed()方法来过滤掉所有正常数据,仅留下已删除数据
	return Db::connect('db_qiye')->table($table)->where('delete_time','<>',0)->count();
}


//根据分类id,获取分类名称
function getCateName($cateId)
{
	return Db::connect('db_qiye')->table('category')->where('cate_id',$cateId)->value('cate_name');
}

//根据分类id,获取分类类型:单页面还是列表页? 0:单页面,1:列表页
function getCateType($cateId)
{
	return Db::connect('db_qiye')->table('category')->where('cate_id',$cateId)->value('cate_type');
}


