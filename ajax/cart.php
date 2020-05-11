<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Home.php');
    define('IS_CLIENT', true);
    $h = new Home();
    /*Добавляем товары в корзину*/
    $h->cart->add_item($h->request->get('variant', 'integer'), $h->request->get('amount', 'integer'));
    $cart = $h->cart->get_cart();
    $h->design->assign('cart', $cart);

    /*Определяем валюту*/
	$currencies = $h->money->get_currencies(array('enabled'=>1));
    if(isset($_SESSION['currency_id'])) {
        $currency = $h->money->get_currency($_SESSION['currency_id']);
    } else {
        $currency = reset($currencies);
    }
    $h->design->assign('currency',	$currency);

    /*Определяем язык*/
    $language = $h->languages->get_language($h->languages->lang_id());
    $h->design->assign('language', $language);
    $h->design->assign('lang_link', $h->languages->get_lang_link());
    $h->translations->debug = (bool)$h->config->debug_translation;
    $h->design->assign('lang', $h->translations->get_translations(array('lang'=>$language->label)));
    
    $result = $h->design->fetch('cart_informer.tpl');
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    print json_encode($result);
