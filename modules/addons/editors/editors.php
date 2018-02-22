<?php
if (!defined('WHMCS')) {
	die('This file cannot be accessed directly');
}
// NeWorld Manager 开始

// 引入文件
require  ROOTDIR . '/modules/addons/NeWorld/library/class/NeWorld.Common.Class.php';

// NeWorld Manager 结束

function editors_config() {
	$configarray = array(
		'name' => '后台编辑器',
		'description' => '后台编辑器可以切换 TinyMCE,CKEditor,Simditor ！',
		'version' => '1.1',
		'author' => '<a href="http://neworld.org" target="_blank">NeWorld</a>',
		'fields' 		=> array()
	);
	
	// NeWorld Manager 开始
	try
	{
	    // 实例化模块类
	    $addons = new NeWorld\Addons('editors');
	
	    // 授权返回内容（一个数组，包含有 code/time/info 三个键，分别代表“额外代码”、“验证时间”、“授权信息”）
	    $addons = $_SESSION['NeWorld'][$addons->license];
	
	    // 返回信息
	// NeWorld Manager 结束
	
		$configarray['fields']['editor'] = array(
				'FriendlyName' => '选择编辑器',
				'Type' => 'radio',
				'Options' => 'Simditor,TinyMCE',
				'Default' => 'Simditor'
		);
		
	// NeWorld Manager 开始
	}
	catch (Exception $e)
	{
	    // 返回信息
		$configarray['fields']['license'] = array(
			'FriendlyName' => '授权失败',
			'Type' => 'na',
			'Description' => $e->getMessage()
		);
	}
	// NeWorld Manager 结束

	return $configarray;
}


