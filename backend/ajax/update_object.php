<?php

// Проверка сессии для защиты от xss
if(!$h->request->check_session()) {
    trigger_error('Session expired', E_USER_WARNING);
    exit();
}

$result = '';
/*Принимаем данные от объекта, который нужно обновить*/
$id = intval($h->request->post('id'));
$object = $h->request->post('object');
$values = $h->request->post('values');

/*В зависимости от сущности, обновляем её*/
switch ($object) {
    case 'product':
        if($h->managers->access('products')) {
            $result = $h->products->update_product($id, $values);
        }
        break;
    case 'variant':
        if($h->managers->access('products')) {
            $result = $h->variants->update_variant($id, $values);
        }
        break;
    case 'category':
        if($h->managers->access('categories')) {
            $result = $h->categories->update_category($id, $values);
        }
        break;
    case 'brands':
        if($h->managers->access('brands')) {
            $result = $h->brands->update_brand($id, $values);
        }
        break;
    case 'feature':
        if($h->managers->access('features')) {
            $result = $h->features->update_feature($id, $values);
        }
        break;
    case 'page':
        if($h->managers->access('pages')) {
            $result = $h->pages->update_page($id, $values);
        }
        break;
    case 'menu':
        if($h->managers->access('pages')) {
            $result = $h->menu->update_menu($id, $values);
        }
        break;
    case 'menu_item':
        if($h->managers->access('pages')) {
            $result = $h->menu->update_menu_item($id, $values);
        }
        break;
    case 'blog':
        if($h->managers->access('blog')) {
            $result = $h->blog->update_post($id, $values);
        }
        break;
    case 'delivery':
        if($h->managers->access('delivery')) {
            $result = $h->delivery->update_delivery($id, $values);
        }
        break;
    case 'payment':
        if($h->managers->access('payment')) {
            $result = $h->payment->update_payment_method($id, $values);
        }
        break;
    case 'currency':
        if($h->managers->access('currency')) {
            if (!empty($values['cents'])) {
                $values['cents'] = 2;
            }
            $result = $h->money->update_currency($id, $values);
        }
        break;
    case 'comment':
        if($h->managers->access('comments')) {
            $result = $h->comments->update_comment($id, $values);
        }
        break;
    case 'user':
        if($h->managers->access('users')) {
            $result = $h->users->update_user($id, $values);
        }
        break;
    case 'label':
        if($h->managers->access('labels')) {
            $result = $h->orders->update_label($id, $values);
        }
        break;
    case 'language':
        if($h->managers->access('languages')) {
            $result = $h->languages->update_language($id, $values);
        }
        break;
    case 'banner':
        if($h->managers->access('banners')) {
            $result = $h->banners->update_banner($id, $values);
        }
        break;
    case 'banners_image':
        if($h->managers->access('banners')) {
            $result = $h->banners->update_banners_image($id, $values);
        }
        break;
    case 'callback':
        if($h->managers->access('callbacks')) {
            $result = $h->callbacks->update_callback($id, $values);
        }
        break;
    case 'feedback':
        if($h->managers->access('feedbacks')) {
            $result = $h->feedbacks->update_feedback($id, $values);
        }
        break;
    case 'managers':
        if($h->managers->access('managers')) {
            $result = $h->managers->update_manager($id, $values);
        } elseif(isset($values['menu_status'])) {
            $result = $h->managers->update_manager($id, array('menu_status'=>$values['menu_status']));
        }
        break;
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
$json = json_encode($result);
print $json;
