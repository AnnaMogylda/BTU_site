<?php

class StatsAdmin extends Home {

    /*Отображение модуля статистики продаж*/
    public function fetch() {
        return $this->design->fetch('pro_only.tpl');
    }
    
}
