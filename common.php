<?php
//获取文件列表
function directory_map($source_dir, $directory_depth = 0, $hidden = FALSE)
{
	if ($fp = @opendir($source_dir))
	{
		$filedata	= array();
		$new_depth	= $directory_depth - 1;
		$source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

		while (FALSE !== ($file = readdir($fp)))
		{
			// Remove '.', '..', and hidden files [optional]
			if ( ! trim($file, '.') OR ($hidden == FALSE && $file[0] == '.'))
			{
				continue;
			}

			if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file))
			{
				$filedata[$file] = directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
			}
			else
			{
				$filedata[] = $file;
			}
		}
		closedir($fp);
		return $filedata;
	}
	return FALSE;
}
//过滤文件
function filter_file($file_list){
	global $filter_pass_file;
	foreach($file_list as $key=>$value){
		if(is_array($value)){
			$value = filter_file($value);
			$file_list[$key] = $value;
		}else{
			if(!preg_match('/(?:\.js|\.css)$/',$value) || 
			preg_match('/(?:min\.js|min\.css)$/',$value) ||
			in_array($value,$filter_pass_file)
			){
				unset($file_list[$key]);
			}
		}
	}
	return $file_list;
}
//压缩文件
function compress_file($file_list,$path){
	static $report_list = array();
	
	foreach($file_list as $key=>$value){
		if(is_array($value)){
			compress_file($value,$path.$key.DIRECTORY_SEPARATOR);
		}else{
			$file_name = $path.$value;
			$compressed_name = $path.get_compresse_name($value);
			$command = sprintf(COMPRESSOR_COMMAND,$file_name,$compressed_name);
			//echo $command;echo '<br />';
			exec($command);
			$report_list[] = array(
				'file' => $file_name,
				'handled'=>$compressed_name,
				'command' => $command,
			);
			
		}
	}
	return $report_list;
}
//获取压缩后的文件名
function get_compresse_name($file,$ext='.min'){
	if(preg_match('/\.js$/',$file)){
		$file = preg_replace('/(\.js)$/', $ext."$1", $file);
	}
	if(preg_match('/\.css$/',$file)){
		$file = preg_replace('/(\.css)$/', $ext."$1", $file);
	}
	return $file;
}
//获取后缀名
function get_ext($file){ 
	return substr(strrchr($file, '.'), 0);
} 
function repair_dir_separator($path){
	if(substr($path, -1)!==DIRECTORY_SEPARATOR){
		$path = $path.DIRECTORY_SEPARATOR;
	}
	return $path;
}

