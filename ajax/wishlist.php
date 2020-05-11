<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Home.php');
    define('IS_CLIENT', true);
    $h = new Home();
    $limit = 500;
    $id = $h->request->get('id', 'integer');

    /*Создаем массив с товрами в списке избранного*/
    if(!empty($_COOKIE['wished_products'])) {
        $products_ids = explode(',', $_COOKIE['wished_products']);
        $products_ids = array_reverse($products_ids);
    } else {
        $products_ids = array();
    }

    /*Действия над товаром в списке избранного*/
    if($h->request->get('action', 'string') == 'delete') {
        $key = array_search($id, $products_ids);
        unset($products_ids[$key]);
    } else {
        array_push($products_ids, $id);
        $products_ids = array_unique($products_ids);
    }
    $products_ids = array_slice($products_ids, 0, $limit);
    $products_ids = array_reverse($products_ids);

    /*Записываем список избранного в куки*/
    if(!count($products_ids)) {
        unset($_COOKIE['wished_products']);
        setcookie('wished_products', '', time()-3600, '/');
    } else {
        setcookie('wished_products', implode(',', $products_ids), time()+30*24*3600, '/');
    }
    $h->design->assign('wished_products', $products_ids);

    /*Определяем язык*/
    $language = $h->languages->get_language($h->languages->lang_id());
    $h->design->assign('language', $language);
    $h->design->assign('lang_link', $h->languages->get_lang_link());
    $h->translations->debug = (bool)$h->config->debug_translation;
    $h->design->assign('lang', $h->translations->get_translations(array('lang'=>$language->label)));
    
    header("Content-type: text/html; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");

    $result['info'] = $h->design->fetch('wishlist_informer.tpl');
    $result['cnt'] = count($products_ids);
    print json_encode($result);
