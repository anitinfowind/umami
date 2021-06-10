@if( Active::checkUriPattern( 'admin/categories' ) )
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

<div class="btn-group">
    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route( 'admin.categories.index' ) }}">
                <i class="fa fa-list-ul"></i> {{ trans( 'List' ) }}
            </a>
        </li>
        @permission( 'create-category' )
            <li>
                <a href="{{ route( 'admin.categories.create' ) }}">
                    <i class="fa fa-plus"></i> {{ trans( 'Add New Category' ) }}
                </a>
            </li>

            <li>
                <a href="{{ route( 'admin.categories.order' ) }}">
                    <i class="fa fa-plus"></i> {{ trans( 'Category Order' ) }}
                </a>
            </li>
        @endauth
    </ul>
</div>
<div class="clearfix"></div>
