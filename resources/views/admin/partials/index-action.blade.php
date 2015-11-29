<section class="index-action">
    <div class="row">
        <form class="col-sm-4" method="get" action="{{ url('admin/'. $module) }}">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="glyphicon glyphicon-search"></i>
                </span>
                <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
                <span class="input-group-btn">
                    @if(!empty($searchTerm))
                        <a class="btn btn-default" href="{{ url('admin/'. $module .'') }}"><i class="glyphicon glyphicon-remove"></i></a>
                    @endif
                </span>
            </div>
        </form>
        <div class="col-sm-8 text-right">
            <a href="{{ url('admin/'. $module .'/new') }}" class="btn btn-action"><i class="fa fa-fw fa-plus-square"></i> Create</a>
        </div>
    </div>
</section>