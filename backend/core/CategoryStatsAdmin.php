<?php

class CategoryStatsAdmin extends Home {
    
    public function fetch() {
        return $this->design->fetch('pro_only.tpl');
    }
}
