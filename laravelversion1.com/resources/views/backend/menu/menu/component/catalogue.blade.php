<div class="row">
    <div class="col-lg-5">
        <div class="panel-head">
            <div class="panel-title">Vị trí Menu</div>
            <div class="panel-description">
                <p>Website có các vị trí hiển thị cho từng menu</p>
                <p>Lựa chọn ví trí mà bạn muốn hiển thị</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="ibox">
            <div class="ibox-content">
               <div class="row">
                <div class="col-lg-12 mb10">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="text-bold">Chọn ví trí hiển thị <span class ="text-danger">(*)</span></div> 
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalLong">
                    Tạo Vị Trí Hiển thị
                      </button> 
                </div>

                </div>
                <div class="col-lg-6">
                    @if(count($menuCatalogues))
                    <select name="menu_catalogue_id" id="" class="setupSelect2">

                        <option value="0">[Chọn ví trí hiển thị]</option>
                        @foreach ($menuCatalogues as $key =>$val)
                        <option value="{{ $val->id }}">{{ $val->name }}</option>

                         
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-lg-6">
                    @if(count($menuCatalogues))
                    <select name="menu_catalogue_id" id="" class="setupSelect2">

                        <option value="none">[Chọn kiểu menu]</option>
                        @foreach (__('module.type') as $key =>$val)
                        <option value="{{ $key }}">{{ $val }}</option>

                         
                        @endforeach
                    </select>
                    @endif
                </div>
               
               </div>
            
             
            </div>
        </div>
    </div>
</div>
