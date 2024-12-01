<?php

namespace App\Repositories;


use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\MenuCatalogues;

/**
 * Class UserService
 * @package App\Services
 */
class MenuCatalogueRepository extends BaseRepository implements MenuCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(
        MenuCatalogues $model
    ){
        $this->model = $model;
    }

    

    

}
