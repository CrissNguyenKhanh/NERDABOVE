<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\MenuServiceInterface  as MenuService;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;


use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Language;
class MenuController extends Controller
{
    protected $menuService;
    protected $menuRepository;
    protected $menuCatalogueRepository;
    protected $language;

    public function __construct(
        MenuService $menuService,
        MenuRepository $menuRepository,
        MenuCatalogueRepository $menuCatalogueRepository,
        Language $language


    ){
     
        $this->menuService = $menuService;
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });

    }

    public function index(Request $request){
        $this->authorize('modules', 'menu.index');
        $menus = $this->menuService->paginate($request,21);
      
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Menu'
        ];
        $config['seo'] =  __('messages.menu');
        $template = 'backend.menu.menu.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'menus'
        ));
    }

    public function create(){
        $this->authorize('modules', 'menu.create');
        $menuCatalogues = $this->menuCatalogueRepository->all();
  
        $config = $this->config();
        $config['seo'] = __('messages.menu');
        $config['method'] = 'create';
        $template = 'backend.menu.menu.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'menuCatalogues'
    
        ));
    }

    public function store(StoreMenuRequest $request){
        if($this->menuService->create($request,$this->language)){
            return redirect()->route('menu.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        // $this->authorize('modules', 'menu.update');
        $menu = $this->MenuRepository->findById($id);
        $provinces = $this->provinceRepository->all();
        $config = $this->config();
        $config['seo'] = config('apps.menu');
        $config['method'] = 'edit';
        $template = 'backend.menu.menu.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
            'menu',
        ));
    }

    public function update($id, UpdatemenuRequest $request){
        if($this->MenuService->update($id, $request)){
            return redirect()->route('menu.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'menu.destroy');
        $config['seo'] = config('apps.menu');
        $menu = $this->MenuRepository->findById($id);
        $template = 'backend.menu.menu.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'menu',
            'config',
        ));
    }

    public function destroy($id){
        if($this->MenuService->destroy($id)){
            return redirect()->route('menu.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config(){
        return [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/menu.js'
      
              
            ]
        ];
    }

}
