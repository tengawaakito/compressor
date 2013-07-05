<?php
require 'config.php';
require 'common.php';
$path = isset($_POST['path'])?$_POST['path']:'';

$path = repair_dir_separator($path);
$report_list = array();
if(!empty($path)){
	$file_list = directory_map($path);
	$file_list = filter_file($file_list);
	$report_list = compress_file($file_list,$path);
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>输入目录名</title>
</head>

<body>
<style type="text/css">
#path{ width:400px; height: 25px; line-height: 25px;}
table{ border-collapse: collapse}
</style>

<table border="1" cellspacing="5" cellpadding="5">
	<?php foreach ($report_list as $key => $value): ?>
	<tr>
		<td><?php echo $key+1?></td>
		<td><?php echo $value['file']?></td>
		<td><?php echo $value['handled']?></td>
		<td><?php echo $value['command']?></td>
	</tr>
	<?php endforeach ?>
	
</table>


	
</body>
</html>
