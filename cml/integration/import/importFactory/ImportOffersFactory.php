<?php

namespace Integration1C\Import\ImportFactory;


class ImportOffersFactory implements ImportFactoryInterface
{
    
    /**
     * @param $h \Home
     * @param $integration_1c \Integration1C\Integration1C
     * @return \Integration1C\Import\ImportOffers
     */
    public function create_import($h, $integration_1c) {
        return new \Integration1C\Import\ImportOffers($h, $integration_1c);
    }
}