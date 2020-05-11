<?php

class SubscribeMailingAdmin extends Home {
    
    /*Отображение подписчиков сайта*/
    public function fetch() {
        return $this->body = $this->design->fetch('pro_only.tpl');
    }
    
}
