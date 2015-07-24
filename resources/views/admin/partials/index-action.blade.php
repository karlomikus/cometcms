<div class="row">
    <div class="col-md-6">
        <a href="{{ url('admin/'. $module .'/new') }}" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Create</a>
    </div>
    <form class="col-md-6" method="get" action="{{ url('admin/'. $module) }}">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Enter search term..." value="{{ !empty($searchTerm) ? $searchTerm : "" }}" tabindex="1">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                @if(!empty($searchTerm))
                    <a class="btn btn-primary" href="{{ url('admin/'. $module .'') }}"><i class="glyphicon glyphicon-remove"></i></a>
                @endif
            </span>
        </div>
    </form>
</div>
<hr>