{{-- https://dev.to/ericchapman/laravel-blade-components-5c9c --}}

@if($open === false)
    <div></div>
@else
    <div id="modal" class="modal">
        <div class="modal-content">
            <h1>{{$title}}</h1>

            @foreach($content as $key => $value)
                <p>{{$key}}: {{$value}}</p>
            @endforeach
        </div>

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">OK</a>
        </div>
    </div>
@endif
