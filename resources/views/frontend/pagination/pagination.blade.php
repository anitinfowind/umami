<?php $link_limit = 6; ?>
@if ($paginator->lastPage() > 1)
    <div class="table-footer">
        <div class="row">
            <div class="col-md-12">
                <ul class="pagination justify-content-end">
                    <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ ($paginator->currentPage() == 1) ? 'javascript:void(0)' : str_replace('/?', '?', $paginator->url($paginator->currentPage
                        ()-1))  }}"><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</a>
                    </li>
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <?php
                            $half_total_links = floor($link_limit / 2);
                            $from = $paginator->currentPage() - $half_total_links;
                            $to = $paginator->currentPage() + $half_total_links;
                            if ($paginator->currentPage() < $half_total_links) {
                                $to += $half_total_links - $paginator->currentPage();
                            }
                            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                            }
                        ?>
                        @if ($from < $i && $i < $to)
                                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                                    <a class="page-link" href="{{ str_replace('/?', '?', $paginator->url($i))  }}">{{ $i }}</a>
                                </li>
                        @endif
                    @endfor
                    <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'javascript:void(0)' : str_replace('/?', '?', $paginator->url
                        ($paginator->currentPage()+1) ) }}" >Next <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif
