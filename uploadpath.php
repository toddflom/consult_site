<?php
$config['img_path'] = '/imgupload';
if (isset($_SERVER['DOCUMENT_ROOT'])){
	$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . $config['img_path'];
} else {
	$config['upload_path'] = dirname(__FILE__) . $config['img_path'];
}
echo 'Hello World ';
echo "Image Path: " . $config['img_path'] . "";
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "";
echo 'Dirname: ' .	dirname('/index.html') . "";

echo 'UploadPath: ' . $config['upload_path'] . "";

if (is_dir($config['upload_path'])){
	echo "Is Directory";
	if (is_writable($config['upload_path']) ){
	echo "Is Writable";
} else {
echo "Is NOT writable";
}
} else {
echo "Is Not a Directory";
}

?>