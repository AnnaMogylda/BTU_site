<?php

    if(!$h->managers->access('products')) {
        exit();
    }
    $limit = 100;

    /*Принимаем строку запроса*/
    $keyword = $h->request->get('query', 'string');
    $feature_id = $h->request->get('feature_id', 'string');

    $features_values = $h->features_values->get_features_values(array(
        'feature_id' => $feature_id,
        'keyword'    => $keyword
    ));

    $suggestions = array();
    foreach ($features_values as $fv) {
        $suggestion = new stdClass();
        $suggestion->value = $fv->value;
        $suggestion->data = $fv;
        $suggestions[] = $suggestion;
    }

    $res = new stdClass;
    $res->query = $keyword;
    $res->suggestions = $suggestions;
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    print json_encode($res);
