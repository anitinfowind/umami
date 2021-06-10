<div class="btn-group">
    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.chefs.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'Chefs' ) }}
            </a>
        </li>
            <li>
                <a href="{{ route( 'admin.chefs.create' ) }}">
                    <i class="fa fa-plus"></i> {{ trans( 'Add New Chef' ) }}
                </a>
            </li>
    </ul>
</div>
<div class="clearfix"></div>
