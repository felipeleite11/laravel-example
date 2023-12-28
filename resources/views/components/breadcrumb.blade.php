<nav class="breadcrumbs transparent z-depth-0 animate__animated animate__fadeIn">
    <div class="nav-wrapper">
        <div class="col s12">
            @foreach($pages as $page)
                @if(isset($page['link']))
                    <a href="{{$page['link']}}" class="breadcrumb">
                        {{$page['title']}}
                    </a>
                @else
                    <span class="breadcrumb">
                        {{$page['title']}}
                    </span>
                @endif
            @endforeach
        </div>
    </div>
</nav>
