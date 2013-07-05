<?php

define('YUICOMPRESSOR_FOLDER',realpath('jar').DIRECTORY_SEPARATOR);
define('YUICOMPRESSOR_FILENAME','yuicompressor-2.4.jar');
define('JAVA_BIN_PATH','E:\developer\jdk\bin\\');
define('COMPRESSOR_COMMAND',JAVA_BIN_PATH.'java -jar '.YUICOMPRESSOR_FOLDER.YUICOMPRESSOR_FILENAME.' %s -o %s --charset utf-8');



$filter_pass_file = array(
	'jquery-1.9.0.js',
);
