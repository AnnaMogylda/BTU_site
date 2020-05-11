<?php

class SettingsFeedAdmin extends Home {

    /*Настройки выгрузки в яндекс*/
    public function fetch() {
        return $this->design->fetch('pro_only.tpl');
    }

}
