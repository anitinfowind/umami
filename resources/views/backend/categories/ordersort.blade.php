@extends ('backend.layouts.app')
@section ('title', trans('labels.backend.categories.management'))
@section('page-header')
    <h1>{{ trans('Category Order') }}</h1>
@endsection
@section('content')
    <style>
.widget {
    margin-bottom: 0px;
}
.sortable-list-card {
    margin: 0 auto 3px;
    line-height: 29px;
    height: 30px;
}
li.widget-body-content {
    height: 33px;
    background: bisque;
    padding-left: 5%;
    padding-top: 6px;
}
</style>
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.categories.partials.categories-header-buttons')
            </div>
        </div>
        <div class="box-body">
          @if(!empty($categorydata))
          <div class='widget-container' id='tileSort'>
            @foreach($categorydata as $category)
       
            <div class='widget' id='<?=$category->id ?>'>
              <ul class='widget-body-table' style='list-style:none;padding:0px;margin-bottom:5px'>
                <li class='widget-body-content' style="height: 33px;background: #ccc;padding-left: 5%;padding-top: 6px;">
                  <div class='sortable-list-card'>
                    <div class='sortable-list-handle'>
                      <div class='sortable-list-handle-line'></div>
                    </div>
                    <label>
                      {{$category->name}}
                    </label>
                  </div>
                </li>
              </ul>
            </div>
            @endforeach
            
          @else 
           {{'No record found!'}}

           @endif
        </div>
         <input type="submit" class="btn btn-success" name="submit" value="Update" id="saveColumnOrder">
            <input type="hidden" id="orders">
        </div>
    </div>

@endsection
@section('after-scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script type="text/javascript">
       $('#tileSort').sortable({
        //items: "li:not(.ui-state-disabled)",
        cursor: 'move',   
        update: function(event, ui) {
          var tileOrder = $(this).sortable('toArray').toString();
          $("#orders").val(tileOrder);
         }
  });
  $('#saveColumnOrder').click(function(){
    var orderVal = $('#orders').val().trim();  
    $.ajax({
      url:'{{url("admin/categories/sortvideoajax")}}',
      data:{order:orderVal},
      'method':'get',
      dataType:'json',
     // beforeSend:showLoader,
      success:function(resp){       
        if(resp.status == 'success'){
        //  hideLoader();
        //  window.location.reload();
        alert(resp.message);
         // toastr.success(resp.message,{'closeButton':true});
        }
        else{
         // hideLoader();
         alert(resp.message);
          //toastr.error(resp.message,{'closeButton':true});
        }
      },
      error:function(jqXHR,exception){
       // hideLoader();
        alert('Something went wrong');
        //toastr.error('<?=__('Something went wrong')?>',{'closeButton':true});
      }
    });   
  });
</script>
@endsection