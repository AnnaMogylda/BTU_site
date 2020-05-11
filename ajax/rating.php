<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Home.php');
    define('IS_CLIENT', true);
    $h = new Home();
    if(isset($_POST['id']) && is_numeric($_POST['rating'])) {
        $product_id = intval(str_replace('product_', '', $_POST['id']));
        $rating = floatval($_POST['rating']);

        if(!isset($_SESSION['rating_ids'])) $_SESSION['rating_ids'] = array();
        if(!in_array($product_id, $_SESSION['rating_ids'])) {
            $query = $h->db->placehold('SELECT rating, votes FROM __products WHERE id = ? LIMIT 1',  $product_id);
            $h->db->query($query);
            $product = $h->db->result();
            if(!empty($product)) {
                $rate = ($product->rating * $product->votes + $rating) / ($product->votes + 1);
                $query = $h->db->placehold("UPDATE __products SET rating = ?, votes = votes + 1 WHERE id = ?", $rate, $product_id);
                $h->db->query($query);
                $_SESSION['rating_ids'][] = $product_id;
                echo $rate;
            }
            else echo -1;
        }
        else echo 0;
    }
    else echo -1;
    