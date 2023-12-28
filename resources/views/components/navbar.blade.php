@php
    $user = session('user');

    $name = isset($user) ? $user->name : null;
    $profile = isset($user) ? $user->profile : null;
    $groups = isset($profile) ? $profile->groups : [];

    $truncatedName = strlen($name) > 16 ? substr($name, 0, 16) . '...' : $name;

    $utilLinks = [
        [
            "link" => "https://www.booking.com",
            "label" => "Hotéis"
        ],
        [
            "link" => "https://www.cnm.org.br",
            "label" => "Portal CNM"
        ],
        [
            "link" => "https://www.alepa.pa.gov.br/noticias.asp",
            "label" => "Portal ALEPA"
        ],
    ];
@endphp

@if(isset($user))
    @foreach($groups as $key => $permissions)
        <ul id="{{$key}}" class="dropdown-content">
            @foreach($permissions as $permission)
                <li>
                    <a href="/sie{{$permission->link}}">{{$permission->description}}</a>
                </li>
            @endforeach
        </ul>
    @endforeach
@endif

<ul class="dropdown-content" id="util-links">
    @foreach($utilLinks as $utilLink)
        <li>
            <a href="/sie{{$utilLink['link']}}">{{$utilLink['label']}}</a>
        </li>
    @endforeach
</ul>

<nav style="background-color: var(--blue)">
  <div class="nav-wrapper">
    <div class="row">
        <div class="col s12">
            <a href="/sie/home" class="brand-logo hide-on-med-and-down">Sistema de Informações Estratégicas</a>
            <a href="/sie/home" class="brand-logo hide-on-large-only">SIE</a>

            @if(isset($user))
                <a href="#" data-target="mobile-menu" class="sidenav-trigger">
                    <i class="material-icons">menu</i>
                </a>

                <ul class="right hide-on-med-and-down nav-options">
                    <li>
                        <a href="/sie/home">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="#" class="dropdown-trigger" data-target="util-links">
                            Links úteis
                            <i data-feather="chevron-down"></i>
                        </a>
                    </li>

                    @foreach($groups as $key => $permissions)
                        <li>
                            <a href="#" class="dropdown-trigger" data-target="{{$key}}">
                                {{$key}}
                                <i data-feather="chevron-down"></i>
                            </a>
                        </li>
                    @endforeach

                    <li><a href="/sie/destroy/session">Sair</a></li>
                </ul>

                <div class="right" id="greeting-container">
                    <span class="user-info">{{$truncatedName}}</span>
                    <span class="profile">({{$profile->description}})</span>
                </div>
            @else
                <ul class="right">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/sie/login">Login</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
  </div>
</nav>

<ul class="sidenav" id="mobile-menu">
    @if(isset($user))
        <li><a href="/sie/home">Home</a></li>

        @foreach($groups as $key => $permissions)
            <li>
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">
                            {{$key}}
                            <i data-feather="chevron-down"></i>
                        </div>

                        <div class="collapsible-body">
                            <ul>
                                @foreach($permissions as $permission)
                                    <li>
                                        <a href="/sie{{$permission->link}}">{{$permission->description}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        @endforeach

        <li>
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header">
                        Links úteis
                        <i data-feather="chevron-down"></i>
                    </div>

                    <div class="collapsible-body">
                        <ul>
                            @foreach($utilLinks as $utilLink)
                                <li>
                                    <a href="{{$utilLink['link']}}">{{$utilLink['label']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li><a href="/sie/destroy/session">Sair</a></li>
    @else
        <li><a href="/sie/login">Login</a></li>
    @endif
</ul>

<script type="text/javascript">
    $('.dropdown-trigger').dropdown({
        alignment: 'right',
        coverTrigger: false
    })

    feather.replace({
        width: 14,
        height: 14
    })
</script>
