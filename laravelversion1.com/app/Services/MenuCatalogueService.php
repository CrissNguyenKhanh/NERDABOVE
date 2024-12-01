<?php

namespace App\Services;

use App\Services\Interfaces\MenuCatalogueServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;




/**
 * Class menuCatalogueCatalogueService
 * @package App\Services
 */
class MenuCatalogueService extends BaseService implements MenuCatalogueServiceInterface
{


    protected $menuCatalogueRepository;
    

    public function __construct(
        MenuCatalogueRepository $menuCatalogueRepository,
    ){
        $this->menuCatalogueRepository = $menuCatalogueRepository;
    }

    public function paginate($request, $languageId){
        
       
        return [];
    }

    public function create($request){
        DB::beginTransaction();
   
        try{
     $payload = $request->only('name' , 'keyword');
    $payload['keyword'] =Str::slug($payload['keyword']);
        $menuCatalogue = $this->menuCatalogueRepository->create($payload);

            DB::commit();
            return [
                'name'=>$menuCatalogue->name,
                'id'=>$menuCatalogue->id
            ];
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

   

    public function destroy($id, $languageId){
        DB::beginTransaction();
        try{
        
            $this->nestedset();
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    



    private function paginateSelect(){
        return [
            'menu_catalogues.id', 
            'menu_catalogues.publish',
            'menu_catalogues.image',
            'menu_catalogues.level',
            'menu_catalogues.order',
            'tb2.name', 
            'tb2.canonical',
        ];
    }

    

}
