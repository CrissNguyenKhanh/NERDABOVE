<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th> Tên Menu</th>
        <th>Từ Khóa</th>
        <th>Ngày Tạo</th>
        <th>Người Tạo</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($menus) && is_object($menus))
            @foreach($menus as $menu)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $menu->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                   
                </td>
                <td>
    
                </td>
             
                <td>
 
                </td>
                <td class="text-center">

                </td>
                <td class="text-center js-switch-{{ $menu->id }}"> 
                    <input type="checkbox" value="{{ $menu->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($menu->publish == 2) ? 'checked' : '' }} data-modelId="{{ $menu->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('user.edit', $menu->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('user.delete', $menu->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
