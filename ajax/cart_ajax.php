<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Home.php');
    define('IS_CLIENT', true);
    $h = new Home();
    /*Определяем пользователя*/
    if(isset($_SESSION['user_id']) && $user = $h->users->get_user(intval($_SESSION['user_id']))) {
        $h->design->assign('user', $user);
    }
    
    $action = $h->request->get('action');
    $variant_id = $h->request->get('variant_id', 'integer');
    $amount = $h->request->get('amount', 'integer');
    /*Действия над товарами в корзине*/
    switch($action) {
        case 'update_citem':
            $h->cart->update_item($variant_id, $amount);
            break;
        case 'remove_citem':
            $h->cart->delete_item($variant_id);
            break;
        case 'add_citem':
            $h->cart->add_item($variant_id, $amount);
            break;
        default:
            break;
    }

    /*Определяем язык*/
    $language = $h->languages->get_language($h->languages->lang_id());
    $h->design->assign('language', $language);
    $h->design->assign('lang_link', $h->languages->get_lang_link());
    $h->translations->debug = (bool)$h->config->debug_translation;
    $h->design->assign('lang', $h->translations->get_translations(array('lang'=>$language->label)));

    $cart = $h->cart->get_cart();
    $h->design->assign('cart', $cart);
    /*Определяем валюту*/
    $currencies = $h->money->get_currencies(array('enabled'=>1));
    if(isset($_SESSION['currency_id'])) {
        $currency = $h->money->get_currency($_SESSION['currency_id']);
    } else {
        $currency = reset($currencies);
    }
    $h->design->assign('currency',    $currency);

    /*Выбираем доступные способы доставки и оплаты*/
    $deliveries = $h->delivery->get_deliveries(array('enabled'=>1));
    $h->design->assign('deliveries', $deliveries);
    foreach($deliveries as $delivery) {
        $delivery->payment_methods = $h->payment->get_payment_methods(array('delivery_id'=>$delivery->id, 'enabled'=>1));
    }
    $h->design->assign('all_currencies', $h->money->get_currencies());

    /*Рабтаем с товарами в корзине*/
    if (count($cart->purchases) > 0) {
        $coupon_code = trim($h->request->get('coupon_code', 'string'));
        if(empty($coupon_code)) {
            $h->cart->apply_coupon('');                
        } else {
            $coupon = $h->coupons->get_coupon((string)$coupon_code);
            if(empty($coupon) || !$coupon->valid) {
                $h->cart->apply_coupon($coupon_code);
                $h->design->assign('coupon_error', 'invalid');
            } else {
                $h->cart->apply_coupon($coupon_code);
            }
        }
        if($h->coupons->count_coupons(array('valid'=>1))>0) {
            $h->design->assign('coupon_request', true);
        }
        $cart = $h->cart->get_cart();
        $h->design->assign('cart', $cart);
        $result = array('result'=>1);
        $result['cart_informer'] = $h->design->fetch('cart_informer.tpl');
        $result['cart_purchases'] = $h->design->fetch('cart_purchases.tpl');
        $result['cart_deliveries'] = $h->design->fetch('cart_deliveries.tpl');
        $result['currency_sign'] = $currency->sign;
        $result['total_price'] = $h->money->convert($cart->total_price, $currency->id);
        $result['total_products'] = $cart->total_products;
    } else {
        $result = array('result'=>0);
        $result['cart_informer'] = $h->design->fetch('cart_informer.tpl');
        $result['content'] = $h->design->fetch('cart.tpl');
    }
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");        
    print json_encode($result);
