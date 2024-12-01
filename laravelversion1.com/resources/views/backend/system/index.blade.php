@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
@php
$url = isset($config['method']) && $config['method'] == 'translate' 
    ? route('system.save.translate', ['languageId' => $languageId]) 
    : route('system.store');

@endphp
<form action="{{$url }}" method="post" class="box">
    @csrf
    
                            <div class="wrapper wrapper-content animated fadeInRight">
                                
                                    <div class=" uk-flex uk-flex-middle">
                                        @foreach ($languages as $language)
                                        @if (session('app_locale') === $language->canonical)
                                           
                                        @endif
                                     
                                        <a class="image img-cover system-flag"
                                            href="{{ route('system.translate', [ 'languageId' => $language->id ]) }}">

                                            <img src="{{ $language->image }}" alt="">

                                            </a>
                                    @endforeach
                                    </div>
                       
                                @foreach ($systemConfig as $key => $val)
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="panel-head">
                                                <div class="panel-title">{{ $val['label'] }}</div>
                                                <div class="panel-description">
                                                    {{ $val['description'] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="ibox">
                                                @if (!empty($val['value']))
                                                    <div class="ibox-content">
                                                        @foreach ($val['value'] as $keyVal => $item)
                                                            @php
                                                                $name = $key . '_' . $keyVal;
                                                            @endphp
                                                            <div class="row mb15">
                                                                <div class="col-lg-12">
                                                                    <div class="form-row">
                                                                        <label for="{{ $name }}"
                                                                            class=" uk-flex uk-flex-space-between">
                                                                            <span>{{ $item['label'] }} </span>
                                                                            {!! renderSystemLink($item) !!}
                                                                            {!! renderSystemTitle($item) !!}

                                                                        </label>
                                                                        @switch($item['type'])
                                                                            @case('text')
                                                                                {!! renderSystemInput($name, $systems) !!}
                                                                            @break

                                                                            @case('images')
                                                                                {!! renderSystemImages($name, $systems) !!}
                                                                            @break

                                                                            @case('textarea')
                                                                                {!! renderSystemTextarea($name, $systems) !!}
                                                                            @break

                                                                            @case('select')
                                                                                {!! renderSystemSelect($item, $name, $systems) !!}
                                                                            @break

                                                                            @case('editor')
                                                                                {!! renderSystemEditor($name, $systems) !!}
                                                                            @break

                                                                            @default
                                                                                <p>Type không được hỗ trợ: {{ $item['type'] }}
                                                                                </p>
                                                                        @endswitch
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <hr>
                                <div class="text-right mb15">
                                    <button class="btn btn-primary" type="submit" name="send" value="send">
                                        Lưu lại
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Tab 1 -->

                    <!-- Tab 2 -->
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <!-- Content for Tab 2 -->
                            <p>This is the content of the second tab.</p>
                        </div>
                    </div>
                    <!-- End of Tab 2 -->
                </div>
            </div>
        </div>
    </div>
</form>
