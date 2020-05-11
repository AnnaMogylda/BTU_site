<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Home.php');
    define('IS_CLIENT', true);
    $h = new Home();
    /*Действия над товаром в сравнении*/
    $product_id = $h->request->get('product', 'integer');
    $action = $h->request->get('action');
    if($action == 'add') {
        $h->comparison->add_item(intval($product_id));
    } elseif($action == 'delete') {
        $h->comparison->delete_item(intval($product_id));
    }
    
    $comparison = $h->comparison->get_comparison();
    $h->design->assign('comparison', $comparison);

    /*Определяем язык*/
    $language = $h->languages->get_language($h->languages->lang_id());
    $h->design->assign('language', $language);
    $h->design->assign('lang_link', $h->languages->get_lang_link());
    $h->translations->debug = (bool)$h->config->debug_translation;
    $h->design->assign('lang', $h->translations->get_translations(array('lang'=>$language->label)));
    
    $result = $h->design->fetch('comparison_informer.tpl');
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    print json_encode($result);
