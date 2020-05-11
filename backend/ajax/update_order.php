<?php

if(!$h->managers->access('orders')) {
    exit();
}

$h->design->set_templates_dir('backend/design/html');
$h->design->set_compiled_dir('backend/design/compiled');

$result = array();
/*Принимаем метки, с которыми нужно сделать действие*/
if($h->request->method("post")) {
    $order_id = $h->request->post("order_id", "integer");
    $state = $h->request->post("state", "string");
    $label_id = $h->request->post("label_id", "integer");

    if(empty($order_id) || empty($state)){
        $result['success ']= false;
    } else {
        switch ($state) {
            case "add" : {
                $h->orderlabels->add_order_labels($order_id, (array)$label_id);
                $result['success'] = true;
                break;
            }
            case "remove": {
                $h->orderlabels->delete_order_labels($order_id, (array)$label_id);
                $result['success'] = true;
                break;
            }
        }
        $order = new stdClass();
        $order->labels = $h->orderlabels->get_order_labels((array)$order_id);
        $h->design->assign("order", $order);
        $result['data'] = $h->design->fetch("labels_ajax.tpl");

    }

} else {
    $result['success ']= false;
}
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
print json_encode($result);