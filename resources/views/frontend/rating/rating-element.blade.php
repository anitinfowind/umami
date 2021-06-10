<div class="table-responsive">
 <table id="example"class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Product Image</th>
        <th>Title</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Date</th>
      </tr>
    </thead>
     <tbody>
          @foreach($product_reviews as $key=>$rating)
          
           <?php 
           $ext = '';
           $img_file = '';
           if(isset($rating->product->singleProductImage->image)) {
            $info = pathinfo(PRODUCT_ROOT_PATH.$rating->product->singleProductImage->image);
            $ext = $info['extension'];
            if($rating->product->singleProductImage->image !=='' && File::exists(PRODUCT_ROOT_PATH.$rating->product->singleProductImage->image))
              $img_file = PRODUCT_URL.$rating->product->singleProductImage->image;
           }
           ?>
          <tr>
             <td>
                @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                  @if($img_file != '')
                      <img class="media-object" src="{{ $img_file }}">
                  @else
                    <img class="media-object" src="{{ WEBSITE_IMG_URL }}no-product-image.png">
                  @endif
                @elseif($ext != '')
                 <video width="150px" height="80px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                 <source src="{{ $img_file }}" type="video/mp4">
                 </video>
                @endif  
            </td>
            <td>
              <a href="{{ url('product-detail',($rating->product->slug ?? '')) }}">
                {{ $rating->product->title ?? '' }}
              </a>
            </td>
            <td>
           <!-- <div class="rating-stars user">
                <div class="rating-star">
                  <i class="fa fa-star user"></i> 
                </div>
              </div> -->
              <?php
              echo 'Food: ';
              for($i = 1; $i <= $rating->rate_food; $i++) { echo '<i class="fa fa-star user" style="font-size: 14px;"></i> '; }
              echo '<br />';
              echo 'Shipping: ';
              for($i = 1; $i <= $rating->rate_shipping; $i++) { echo '<i class="fa fa-star user" style="font-size: 14px;"></i> '; }
              echo '<br />';
              echo 'Packaging: ';
              for($i = 1; $i <= $rating->rate_packaging; $i++) { echo '<i class="fa fa-star user" style="font-size: 14px;"></i> '; }
              echo '<br />';
                echo 'Instructions: ';
              for($i = 1; $i <= $rating->rate_instructions; $i++) { echo '<i class="fa fa-star user" style="font-size: 14px;"></i> '; }
              ?>
            </td>
             <td>{!! nl2br($rating->comment) !!}</td>
            <td>{{ date('m-d-Y', strtotime($rating->created_at)) }}</td>
          </tr>
          
        @endforeach
     </tbody>
  </table>
</div>
<link rel="stylesheet" type="text/css" href="{{url('css/dataTables.bootstrap4.min.css')}}">
<script type="text/javascript" src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable();
} );
</script>