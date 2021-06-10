@extends('backend.layouts.app')

@section('page-header')
    <h1>
        Product Reviews
        <small></small>
    </h1>
@endsection
   
@section('content')
  <div class="box box-info">
      <div class="box-header with-border">
              <h3 class="box-title">Product Reviews</h3>

              <div class="box-tools pull-right">
               
              </div><!--box-tools pull-right-->
          </div><!--box-header with-border-->
          <div class="box-body">
          <div class="table-responsive data-table-wrapper">
              <table id="example" class="table table-condensed table-hover table-bordered" data-order111="[[ 3, &quot;desc&quot; ]]">
                  <thead>
                      <tr>
                          <th>Product</th>
                          <th>Restaurant</th>
                          <th>User</th>
                          <th>Ratings</th>
                          <th>Comment</th>
                          <th>Date</th>
                          <th>{{ trans('labels.general.actions') }}</th>
                      </tr>
                  </thead>
                  <tbody>
                        @foreach($product_reviews as $rev)
                          <tr>
                            <td>{!! $rev->product->title !!}</td>
                            <td>{!! $rev->product->restaurant->name !!}</td>
                            <td>{!! $rev->user->first_name . ' ' . $rev->user->last_name !!}</td>
                            <td>
                              <?php
                              echo '<p>Food: ' . $rev->rate_food . '/5</p>';
                              echo '<p>Shipping: ' . $rev->rate_shipping . '/5</p>';
                              echo '<p>Packaging: ' . $rev->rate_packaging . '/5</p>';
                              echo '<p>Instructions: ' . $rev->rate_instructions . '/5</p>';
                              ?>
                            </td>
                            <td>{!! nl2br($rev->comment) !!}</td>
                            <td>{{ date('m-d-Y', strtotime($rev->created_at)) }}</td>
                              
                              <td>
                                <div class="json_data" style="display: none;">{!! json_encode($rev) !!}</div>
                                <div class="btn-group dropup">
                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                  <span class="glyphicon glyphicon-option-vertical"></span>
                              </button>
                                <ul class="dropdown-menu dropdown-menu-right"> 
                                
                                <li><a class="edit_review" href="javascript:;" review_id="{{ $rev->id }}"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top"></i>Edit</a></li>
                                <li><a class="delete_review" href="javascript:;" review_id="{{ $rev->id }}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top"></i>Delete</a></li>
                                </ul>
                               </div>
                              </td>
                          </tr>
                        @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Review</h4>
      </div>
      <div class="modal-body">
        <div class="review_form_block">
          <?php
          $reviews_for = [
            ['title' => 'Food', 'key' => 'food'],
            ['title' => 'Shipping', 'key' => 'shipping'],
            ['title' => 'Packaging', 'key' => 'packaging'],
            ['title' => 'Instructions', 'key' => 'instructions']
          ];
          foreach ($reviews_for as $key => $value) {
            ?>
            <div class="revparam">
              <span>{{ $value['title'] }}:</span>
              <?php
              for($i = 1; $i <= 5; $i++) {
                echo '<label><input type="radio" name="rate_' . $value['key'] . '" value="' . $i . '" />';
                  for($j = 1; $j <= $i; $j++) {
                    echo ' <i class="fa fa-star"></i>';
                  }
                echo '</label>';
              }
              ?>
            </div>
          <?php } ?>
          <label>Your Review</label>
          <div class="form-group">
            <textarea class="form-control" name="comment"></textarea>
          </div>
          <input type="hidden" name="review_id" value="" />
          <a href="javascript:;" class="btn btn-primary update_review">Update Review</a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>
@endsection


@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
    <script type="text/javascript">
      $(document).ready(function() {

        $(document).on('click', '.edit_review', function(){
          var review_id = $(this).attr('review_id');
          var json_data = JSON.parse($(this).closest('td').find('.json_data').html());
          $('#myModal input[name="rate_food"][value="' + json_data.rate_food + '"]').prop('checked', true);
          $('#myModal input[name="rate_shipping"][value="' + json_data.rate_shipping + '"]').prop('checked', true);
          $('#myModal input[name="rate_packaging"][value="' + json_data.rate_packaging + '"]').prop('checked', true);
          $('#myModal input[name="rate_instructions"][value="' + json_data.rate_instructions + '"]').prop('checked', true);
          $('#myModal textarea[name="comment"]').val(json_data.comment);
          $('#myModal input[name="review_id"]').val(json_data.id);
          $("#myModal").modal();
          return false;
        });

        $(document).on('click', '.update_review', function(){
          var rate_food = $('#myModal input[name="rate_food"]:checked').val();
          var rate_shipping = $('#myModal input[name="rate_shipping"]:checked').val();
          var rate_packaging = $('#myModal input[name="rate_packaging"]:checked').val();
          var rate_instructions = $('#myModal input[name="rate_instructions"]:checked').val();
          var comment = $.trim($('#myModal textarea[name="comment"]').val());
          var review_id = $('#myModal input[name="review_id"]').val();
          var review_data = {'rate_food': rate_food, 'rate_shipping': rate_shipping, 'rate_packaging': rate_packaging, 'rate_instructions': rate_instructions, 'comment': comment};
          $.ajax({
            method: "POST",
            url: "{{ url('admin/update_review') }}",
            data: {'review_id': review_id, 'review_data': JSON.stringify(review_data)},
            success: function (data) {
              location.reload();
            }
          });
        });

        $(document).on('click', '.delete_review', function(){
          if(!confirm('Are you sure to delete this review?'))
            return false;
          var review_id = $(this).attr('review_id');
          $.ajax({
            method: "POST",
            url: "{{ url('admin/delete_review') }}",
            data: {'review_id': review_id},
            success: function (data) {
              //console.log(data.data.sales_report_payments);
              location.reload();
            }
          });
        });

      });
    </script>
@endsection