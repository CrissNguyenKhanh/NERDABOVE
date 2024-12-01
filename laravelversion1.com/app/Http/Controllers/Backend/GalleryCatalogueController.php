<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\GalleryCatalogueServiceInterface  as GalleryCatalogueService;
use App\Repositories\Interfaces\GalleryCatalogueRepositoryInterface  as GalleryCatalogueRepository;
use App\Http\Requests\StoreGalleryCatalogueRequest;
use App\Http\Requests\UpdateGalleryCatalogueRequest;
use App\Http\Requests\DeleteGalleryCatalogueRequest;
use App\Classes\Nestedsetbie;
use Auth;
use App\Models\Language;
use Illuminate\Support\Facades\App;
class GalleryCatalogueController extends Controller
{

    protected $galleryCatalogueService;
    protected $galleryCatalogueRepository;
    protected $nestedset;
    protected $language;

    public function __construct(
        GalleryCatalogueService $galleryCatalogueService,
        GalleryCatalogueRepository $galleryCatalogueRepository
    ){
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });

        $this->galleryCatalogueService = $galleryCatalogueService;
        $this->galleryCatalogueRepository = $galleryCatalogueRepository;
    }

    private function initialize(){
        $this->nestedset = new Nestedsetbie([
            'table' => 'gallery_catalogues',
            'foreignkey' => 'gallery_catalogue_id',
            'language_id' =>  $this->language,
        ]);
    } 
 
    public function index(Request $request){
        $this->authorize('modules', 'gallery.catalogue.index');
        $galleryCatalogues = $this->galleryCatalogueService->paginate($request, $this->language);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'GalleryCatalogue',
        ];
        $config['seo'] = __('messages.galleryCatalogue');
        $template = 'backend.gallery.catalogue.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'galleryCatalogues'
        ));
    }

    public function create(){
        $this->authorize('modules', 'gallery.catalogue.create');
        $config = $this->configData();
        $config['seo'] = __('messages.galleryCatalogue');
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'backend.gallery.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
        ));
    }

    public function store(StoreGalleryCatalogueRequest $request){
        if($this->galleryCatalogueService->create($request, $this->language)){
            return redirect()->route('gallery.catalogue.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('gallery.catalogue.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'gallery.catalogue.update');
        $galleryCatalogue = $this->galleryCatalogueRepository->getGalleryCatalogueById($id, $this->language);
        $config = $this->configData();
        $config['seo'] = __('messages.galleryCatalogue');
        $config['method'] = 'edit';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'backend.gallery.catalogue.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'galleryCatalogue',
        ));
    }

    public function update($id, UpdateGalleryCatalogueRequest $request){
        if($this->galleryCatalogueService->update($id, $request, $this->language)){
            return redirect()->route('gallery.catalogue.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('gallery.catalogue.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'gallery.catalogue.destroy');
        $config['seo'] = __('messages.galleryCatalogue');
        $galleryCatalogue = $this->galleryCatalogueRepository->getGalleryCatalogueById($id, $this->language);
        $template = 'backend.gallery.catalogue.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'galleryCatalogue',
            'config',
        ));
    }

    public function destroy(DeleteGalleryCatalogueRequest $request, $id){
        if($this->galleryCatalogueService->destroy($id)){
            return redirect()->route('gallery.catalogue.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('gallery.catalogue.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData(){
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]
          
        ];
    }

}
