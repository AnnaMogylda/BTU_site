<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
	session_start();
	require_once('../../api/Home.php');
	$h = new Home();
	$manager = $h->managers->get_manager();
	if ($manager) {
		$file = $h->request->get('file', 'string');
		$file = preg_replace("/[^A-Za-z0-9_]+/", "", $file);
		$folder = $h->request->get('folder', 'string');
		$ext = $h->request->get('ext', 'string');
		if ($file && $folder && $ext) {
			$file = $folder.'/'.$file.'.'.$ext;
			if (file_exists($file)) {
				if ($ext == 'csv') {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($file));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					readfile($file);
				} elseif ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'tif' || $ext == 'bmp' || $ext == 'bmp') {
					header('Content-type: image');
					print file_get_contents($file);
				}
				exit();
			}
		}
	}
	exit();