<!--Action Button-->
@if( Active::checkUriPattern( 'admin/products' ) )
    <div class="btn-group">
        <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">Export
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li id="copyButton"><a href="#"><i class="fa fa-clone"></i> Copy</a></li>
            <li id="csvButton"><a href="#"><i class="fa fa-file-text-o"></i> CSV</a></li>
            <li id="excelButton"><a href="#"><i class="fa fa-file-excel-o"></i> Excel</a></li>
            <li id="pdfButton"><a href="#"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
            <li id="printButton"><a href="#"><i class="fa fa-print"></i> Print</a></li>
        </ul>
    </div>
@endif
<!--Action Button-->
<div class="btn-group">
    @if( Active::checkUriPattern( 'admin/products/*/edit' ) )
    <a class="btn btn-warning btn-flat" href="{{ url('admin/products') . (isset($_GET['dt_page']) ? '?dt_page=' . $_GET['dt_page'] : '') }}">Back To List</a>
    @endif
    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.products.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'menus.backend.products.all' ) }}
            </a>
        </li>
        @permission( 'create-product' )
            <li>
                <a href="{{ route( 'admin.products.create' ) }}">
                    <i class="fa fa-plus"></i> {{ trans( 'menus.backend.products.create' ) }}
                </a>
            </li>
            <li>
                <a  href="{{ url( 'admin/product-order' ) }}">
                    
                    <!-- href="{{ url('admin/products/order')}}" -->
                    <i class="fa fa-plus"></i> {{ trans( 'Product Order' ) }}
                </a>
            </li>
        @endauth
    </ul>
</div>
<div class="clearfix"></div>
