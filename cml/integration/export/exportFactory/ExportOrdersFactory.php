<?php

namespace Integration1C\Export\ExportFactory;


class ExportOrdersFactory implements ExportFactoryInterface
{
    
    /**
     * @param $h \Home
     * @param $integration_1c \Integration1C\Integration1C
     * @return \Integration1C\Export\ExportOrders
     */
    public function create_export($h, $integration_1c) {
        return new \Integration1C\Export\ExportOrders($h, $integration_1c);
    }
}