<?php

class SeoPatternsAdmin extends Home {

    public function fetch() {
        return $this->design->fetch('pro_only.tpl');
    }
}
