@extends('frontend.layouts.layout')
@section('content')
@include('frontend.includes.new.chefs_slider')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Chef</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">Chef Team</h1>

<section class="chef-search-sec">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-auto">
        <div class="sec-head">
          <h4>Chef Team</h4>
          <!-- <a href="javascript:;"><i class="fas fa-location-arrow"></i> Use my location</a>  --> 
        </div>
      </div>
      <div class="col-auto"> 
        <!--<div class="view-all-btn"> <a href="">view all</a> </div>--> 
      </div>
    </div>
    @if($chefslist->isNotEmpty())
    <div class="product-section d-flex"> @foreach($chefslist as $chefs)
      @if(!empty($chefs->image) && File::exists(CHEF_ROOT_PATH.$chefs->image))
      <?php $image = CHEF_URL.$chefs->image; ?>
      @else
      <?php $image = WEBSITE_IMG_URL.'ch1.jpg'; ?>
      @endif
      
      <?php
	  $userSlugUrl='#';
	  if(isset($chefs->getRestautentName->UserSlug->slug)){
		  $userSlugUrl= url('user-detail/'.$chefs->getRestautentName->UserSlug->slug);
	   }
     $restaurant_link = 'javascript:;';
     if(isset($chefs->getRestautent->slug))
      $restaurant_link = url('restaurant-detail/' . $chefs->getRestautent->slug);
	  ?>
      
      
      <div class="custome-col-3">
        <div class="food-box relative">
          <div class="food-pic relative"> 
            <a href="{{ $restaurant_link }}" class111="chef_details"><img class="chefs_image" src="{{$image}}" alt="{{$chefs->name}}"> </a>
          </div>
          <div class="food-name d-flex align-items-center justify-content-between">
            <div class="foodname-lft chef-name2">
              <h4>{{ $chefs->name ?? ''  }}</h4>
              <?php if($chefs->description!=''){ ?>
              <!--<a href="{{url('chef-detail/'.$chefs->slug)}}">
              <p> {!! Str::limit($chefs->description,40)!!}</p>
              </a>-->
              <?php } ?>
              <p><i class="fas fa-map-marker-alt"></i>{{ $chefs->getRestautent->restaurantLocation->city ?? '' }} <?php if(isset($chefs->getRestautent->restaurantLocation->country)){if($chefs->getRestautent->restaurantLocation->country!=''){ echo ','.$chefs->getRestautent->restaurantLocation->country;}} ?></p>
              <?php if(isset($chefs->getRestautent->name)){ ?>
			  <?php  if($chefs->getRestautent->name!=''){ ?>
              <p class="name-edit"><a href="javascript:;"><i class="fas fa-edit"></i>{{ $chefs->getRestautent->name ?? ''  }}</a></p>
              <?php } ?>
              <?php } ?>
               
            </div>
            <!-- <div class="foodname-rgt out-rating-qty">
              <p>4.1</p>
            </div> -->
            <!-- htmlspecialchars() -->
            
            <div class="json_data" style="display: none;"><?php echo json_encode(['title' => $chefs->name, 'description' => str_replace("<","&lt;",str_replace(">","&gt;",$chefs->description)), 'image' => $image]); ?></div>
          </div>
          <!-- <div class="food-time-rvw-box">
            <div class="food-time d-flex align-items-center justify-content-between">
              {!! $chefs->description !!}
            </div>
          </div> -->

          <div class="food-time-rvw-box">
            <!-- <div class="food-time align-items-center justify-content-between">
              <div class="food-time-rgt d-flex justify-content-between">
                <ul class="d-flex rvw-stars">
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                </ul>
                <p class="text-right">4225 ratings</p>
              </div>
            </div> -->
            <p class="box-ftr-text">{!! Str::limit($chefs->description,82) !!}</p>
        </div>

        </div>
      </div>
      @endforeach </div>
    
    @else
    <h3 class="text-center"> Chefs Not Available. </h3>
    @endif </div>
</section>



<!-- Modal -->
<div id="chefModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Chef Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<?php 
$site_settings=App\Models\Settings\Site_setting::all();
$site_settings2 = [];
foreach ($site_settings as $key => $value) {
    $site_settings2[$value->key] = $value->value;
}
$site_settings = $site_settings2;
?>

@include('frontend.includes.new.home_counter')


<script type="text/javascript">
  $(document).ready(function(){

    $(document).on('click', '.chef_details', function(e){
      e.preventDefault();
      //console.log($(this).closest('.food-box').find('.food-name .json_data').html());
      var json_data = JSON.parse($(this).closest('.food-box').find('.food-name .json_data').html());
      var html = `<div class="row">
      <div class="col-md-12 mb-3"><img src="` + json_data.image + `" class="img-fluid" /></div>
      <div class="col-md-12">
        <h4>` + json_data.title + `</h4>
        ` + json_data.description.replace(/&lt;/g, "<").replace(/&gt;/g, ">") + `
      </div>
      </div>`;
      $('#chefModal .modal-body').html(html);
      $('#chefModal').modal('show');
    });

  });
</script>

@endsection