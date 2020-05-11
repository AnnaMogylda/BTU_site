<?php

namespace Integration1C\Export;


abstract class Export
{

    /**
     * @var \Home()
     */
    protected $h;

    /**
     * @var \Integration1C\Integration1C()
     */
    protected $integration_1c;

    /**
     * ImportProducts constructor.
     * @param $h \Home()
     * @param $integration_1c \Integration1C\Integration1C()
     */
    public function __construct($h, $integration_1c) {
        $this->h = $h;
        $this->integration_1c = $integration_1c;
    }
    
    /**
     * @return string
     */
    abstract public function export();
    
}
