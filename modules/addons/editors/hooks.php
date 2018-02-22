<?php
if (!defined('WHMCS')) {
	die('This file cannot be accessed directly');
}
// NeWorld Manager 开始

// 引入文件
require  ROOTDIR . '/modules/addons/NeWorld/library/class/NeWorld.Common.Class.php';

// NeWorld Manager 结束


function Editor_AdminAreaHeadOutputHook_Hook($vars) {
	$editors = array();
	$results = \Illuminate\Database\Capsule\Manager::table('tbladdonmodules')->where('module', 'editors')->get();
	foreach ($results as $result) {
		$setting = $result->setting;
		$value = $result->value;
		$editors[$setting] = $value;
	}
	
	// NeWorld Manager 开始
	try
	{
	    // 实例化模块类
	    $addons = new NeWorld\Addons('editors');
	
	    // 授权返回内容（一个数组，包含有 code/time/info 三个键，分别代表“额外代码”、“验证时间”、“授权信息”）
	    $addons = $_SESSION['NeWorld'][$addons->license];
	    // 返回信息
	// NeWorld Manager 结束
	
	if ($editors['editor'] == 'Simditor') {
		if (!$_REQUEST['noeditor']) {
			$hook .= '<link rel="stylesheet" type="text/css" href="../modules/addons/editors/includes/simditor/styles/simditor.css" />
<link rel="stylesheet" type="text/css" href="../modules/addons/editors/includes/simditor/styles/simditor-markdown.css" />
<script type="text/javascript" src="../modules/addons/editors/includes/simditor/scripts/module.min.js"></script>
<script type="text/javascript" src="../modules/addons/editors/includes/simditor/scripts/hotkeys.min.js"></script>
<script type="text/javascript" src="../modules/addons/editors/includes/simditor/scripts/simditor.js"></script>
<script type="text/javascript" src="../modules/addons/editors/includes/simditor/scripts/marked.js"></script>
<script type="text/javascript" src="../modules/addons/editors/includes/simditor/scripts/to-markdown.js"></script>
<script type="text/javascript" src="../modules/addons/editors/includes/simditor/scripts/simditor-markdown.js"></script>';
		}
		$hook .= "<script>
jQuery(function() {
	var editor, toolbar;
    toolbar = ['title', 'bold', 'color', '|', 'ol', 'ul', 'blockquote', 'code', '|', 'table', 'link', 'image', 'indent', 'outdent', '|', 'markdown'];
	return editor = new Simditor({
		textarea: $('.tinymce:first'),
		toolbar: toolbar,
		markdown: true,
		tabIndent: true,
		toolbarFloat: true,
		toolbarFloatOffset: 0,
		toolbarHidden: false,
		pasteImage: false
	});
});
</script>";
	}
		
	// NeWorld Manager 开始
	}
	catch (Exception $e)
	{
	    // 返回信息
	    $hook = '<div class="gracefulexit">' . $e->getMessage() . '</div>';
	}
	// NeWorld Manager 结束
		
	return $hook;
}


if (stristr($_SERVER['PHP_SELF'], 'supportkb') || stristr($_SERVER['PHP_SELF'], 'supportannouncements') || stristr($_SERVER['PHP_SELF'], 'configemailtemplates') || stristr($_SERVER['PHP_SELF'], 'sendmessage')) {
	add_hook('AdminAreaHeadOutput', 1, 'Editor_AdminAreaHeadOutputHook_Hook');
}