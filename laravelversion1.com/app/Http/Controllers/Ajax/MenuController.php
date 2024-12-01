<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\MenuRepositoryInterface  as MenuRepository;
use App\Services\Interfaces\MenuCatalogueServiceInterface  as menuCatalogueService;

use App\Models\Language;
use App\Http\Requests\StoreMenuCatalogueRequest;


class MenuController extends Controller
{
    protected $menuRepository;
    protected $menuCatalogueService;

    public function __construct(
       MenuRepository $menuRepository,
       MenuCatalogueService $menuCatalogueService
    ){
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueService = $menuCatalogueService;

  
    }
    public function createCatalogue(StoreMenuCatalogueRequest $request){
        $menuCatalogues = $this->menuCatalogueService->create($request);
        if ( $menuCatalogues!== FALSE) {
            return response()->json([
                'code' => 0,
                'message' => 'Tạo nhóm menu thành công!',
                'data'=>$menuCatalogues
            ]);
        }
        
        return response()->json([
            'code' => 1,
            'message' => 'Có vấn đề xảy ra, hãy thử lại!'
        ]);

    }

}
