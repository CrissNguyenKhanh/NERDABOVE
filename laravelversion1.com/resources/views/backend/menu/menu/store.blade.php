@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    $url = ($config['method'] == 'create') ? route('menu.store') : route('menu.update', $user->id);
@endphp
<form action="{{ $url }}" method="post" class="box menuContainer">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
  
        @include('backend.menu.menu.component.catalogue')
       
         <hr>
    
         @include('backend.menu.menu.component.list')
     




      
        <hr>
    
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
        </div>
    </div>
</form>
@include('backend.menu.menu.component.popup')

<!-- Button trigger modal -->

  
  <!-- Modal -->
 