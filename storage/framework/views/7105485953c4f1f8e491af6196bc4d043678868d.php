<?php $__env->startSection('title', trans('labels.backend.sliders.management')); ?>

<?php $__env->startSection('page-header'); ?>
    <h1><?php echo e(trans('Sliders')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <?php echo $__env->make('backend.sliders.partials.sliders-header-buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="sliders-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo e(trans('Image')); ?></th>
                            <th><?php echo e(trans('Status')); ?></th>
                            <th><?php echo e(trans('labels.backend.sliders.table.createdat')); ?></th>
                            <th><?php echo e(trans('Updated At')); ?></th>
                            <th><?php echo e(trans('labels.general.actions')); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('after-scripts'); ?>
    <?php echo e(Html::script(mix('js/dataTable.js'))); ?>


    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var dataTable = $('#sliders-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo e(route("admin.sliders.get")); ?>',
                    type: 'post'
                },
                columns: [
                    {data: 'slider_image', name: '<?php echo e(config('module.sliders.table')); ?>.slider_image'},
                    {data: 'status', name: '<?php echo e(config('module.sliders.table')); ?>.status'},
                    {data: 'created_at', name: '<?php echo e(config('module.sliders.table')); ?>.created_at'},
                    {data: 'updated_at', name: '<?php echo e(config('module.sliders.table')); ?>.updated_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\umami\resources\views/backend/sliders/index.blade.php ENDPATH**/ ?>