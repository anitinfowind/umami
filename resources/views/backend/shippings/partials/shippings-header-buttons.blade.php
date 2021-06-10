<div class="btn-group">
    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.shippings.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'shippings' ) }}
            </a>
        </li>
            <li>
                <a href="{{ route('admin.shippings.shippingcharge') }}">
                    <i class="fa fa-plus"></i> {{ trans( 'Shipping Charge Calculation' ) }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.shippings.commission') }}">
                    <i class="fa fa-plus"></i> {{ trans( 'Shipping Commission' ) }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.shippings.freeshipping') }}">
                    <i class="fa fa-plus"></i> {{ trans( 'Free Shipping' ) }}
                </a>
            </li>
    </ul>
</div>
<div class="clearfix"></div>
