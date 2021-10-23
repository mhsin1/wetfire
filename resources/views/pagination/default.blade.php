
@if ($paginator->lastPage() > 1)
<div class="category-page-wrapper">
    <div class="result-inner">Showing {{$paginator->firstItem()}} to {{$paginator->lastItem()}} of {{$paginator->total()}}</div>
    <div class="pagination-inner">
        <ul class="pagination">
            <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"><a href="category.html">&lt;</a></li>

            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="pagination-url" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li><a href="{{ $paginator->url($paginator->currentPage()+1) }}">&gt;</a></li>
        </ul>
    </div>
</div>
@endif
