<a href="{{ action($action, ['sort' => $name, 'order' => $order == 'asc' ? 'desc' : 'asc', 'page' => $page]) }}">
    {{ $label }} {!! $sortColumn == $name ? ($order == 'asc' ? '<i class="fa fa-caret-down"></i>' : '<i class="fa fa-caret-up"></i>') : '' !!}
</a>