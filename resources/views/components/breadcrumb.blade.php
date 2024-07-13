<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">{{ $title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @php($i = 0)
                    @foreach ($path as $item)
                        @php($i++)
                        <li class="breadcrumb-item @if($i == count($path)) {{ 'active' }} @endif">
                            @if (!empty($item['link']))
                                <a href="{{ $item['link'] }}">{{ $item['title'] }}</a> 
                            @else
                                {{ $item['title'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>

        </div>
    </div>
</div>