<div class="btn-group">
    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.diet.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'List' ) }}
            </a>
        </li>
            <li>
                <a href="{{ route( 'admin.diet.add' ) }}">
                    <i class="fa fa-plus"></i> {{ trans( 'Add New' ) }}
                </a>
            </li>
    </ul>
</div>
<div class="clearfix"></div>
