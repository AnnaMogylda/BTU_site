<?php

class SettingsCounterAdmin extends Home {

    /*Настройки счетчиков*/
    public function fetch() {
        return $this->design->fetch('pro_only.tpl');
    }
}
