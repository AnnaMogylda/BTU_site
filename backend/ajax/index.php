<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    chdir('../../');
    require_once('api/Home.php');
    $h = new Home();
    $manager = $h->managers->get_manager();
    if ($manager) {
        $file = $h->request->get('file', 'string');
        $file = preg_replace("/[^A-Za-z0-9_]+/", "", $file);
        if ($file) {
            require_once(dirname(__FILE__).'/'.$file.'.php');
        }
    }