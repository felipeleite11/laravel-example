@php
    $links = [
        'prev' => [
            'link' => $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl(),
            'disabled' => $paginator->onFirstPage()
        ],
        'next' => [
            'link' => !$paginator->hasMorePages() ? '#' : $paginator->nextPageUrl(),
            'disabled' => !$paginator->hasMorePages()
        ]
    ];
@endphp

@if($paginator->hasPages())
    <div class="paginator">
        <p class="total-items">{{$paginator->total().' '.($paginator[0]->model_description_plural ?? 'itens').' encontrados'}}</p>

        <div class="page-links">
            <p class="current-page">{{'Página '.$paginator->currentPage().' de '.$paginator->lastPage()}}</p>

            <div class="links">
                <a href="{{$links['prev']['link']}}" class="link prev-link {{$links['prev']['disabled'] ? 'disabled' : ''}}">
                    <i class="material-icons tiny">arrow_back</i>
                    Anterior
                </a>

                <a href="{{$links['next']['link']}}" class="link next-link {{$links['next']['disabled'] ? 'disabled' : ''}}">
                    Próxima
                    <i class="material-icons tiny">arrow_forward</i>
                </a>
            </div>
        </div>
    </div>
@endif

