<?php

if(!$h->managers->access('design')) {
    exit();
}

// Проверка сессии для защиты от xss
if(!$h->request->check_session()) {
    trigger_error('Session expired', E_USER_WARNING);
    exit();
}
$content = $h->request->post('content');
$style = $h->request->post('style');
$theme = $h->request->post('theme', 'string');

/*Сохранение стилей из админки*/
$file = $h->config->root_dir.'design/'.$theme.'/css/'.$style;

if(pathinfo($style, PATHINFO_EXTENSION) != 'css' || $file != realpath($file)) {
    exit();
}

if(is_file($file) && is_writable($file) && !is_file($h->config->root_dir.'design/'.$theme.'/locked')) {
    file_put_contents($file, $content);

    $css_version = ltrim($h->settings->css_version, '0');
    if (!$css_version) {
        $css_version = 0;
    }
    $h->settings->css_version = str_pad(++$css_version, 6, 0, STR_PAD_LEFT);

}

$result = true;
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");
$json = json_encode($result);
print $json;
