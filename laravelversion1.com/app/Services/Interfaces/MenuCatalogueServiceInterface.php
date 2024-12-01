<?php

namespace App\Services\Interfaces;

/**
 * Interface AttributeServiceInterface
 * @package App\Services\Interfaces
 */
interface MenuCatalogueServiceInterface
{
    public function paginate($request,$languageId);
}
