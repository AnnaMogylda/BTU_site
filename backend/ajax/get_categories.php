<?php

if(!$h->managers->access('categories')) {
    exit();
}

$h->design->set_templates_dir('backend/design/html');
$h->design->set_compiled_dir('backend/design/compiled');
$lang_id  = $h->languages->lang_id();
$lang_sql = $h->languages->get_query(array('object'=>'category'));
$result = array();

// Перевод админки
$backend_translations = new stdClass();
$manager = $h->managers->get_manager();
$file = "backend/lang/".$manager->lang.".php";
if (!file_exists($file)) {
    foreach (glob("backend/lang/??.php") as $f) {
        $file = "backend/lang/".pathinfo($f, PATHINFO_FILENAME).".php";
        break;
    }
}
require_once($file);
$h->design->assign('btr', $backend_translations);

/*Выборка категории и её деток*/
if($h->request->get("category_id")) {
    $category_id = $h->request->get("category_id", 'integer');
    $categories = $h->categories->get_category($category_id);
    $h->design->assign('categories_ajax', $categories->subcategories);
    $result['success'] = true;
    $result['cats'] = $h->design->fetch("categories_ajax.tpl");
} else {
    $result['success ']= false;
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
print json_encode($result);
