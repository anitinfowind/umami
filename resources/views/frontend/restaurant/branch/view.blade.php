@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="dashboard-container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="add-product-div">
                                    <span>
                                        <a href="{{ url('branch') }}">
                                            <button type="button" class="btn add-product">
                                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                                            </button>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div class="form-group col-md-12">
                                    <label class = 'control-label cate-label'>Manager Info</label>

                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <th>{{ trans('labels.frontend.user.profile.first_name') }}</th>
                                            <td>{{ $branchDetails->user->firstName() }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('labels.frontend.user.profile.last_name') }}</th>
                                            <td>{{ $branchDetails->user->lastName() }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('labels.frontend.user.profile.email') }}</th>
                                            <td>{{ $branchDetails->user->email() }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('Phone No') }}</th>
                                            <td>{{ $branchDetails->user->phoneNo() }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('Profile Image') }}</th>
                                            <td>
                                                @if($branchDetails->user->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.$branchDetails->user->slug.DS
                                                .$branchDetails->user->image()))
                                                    <img class="media-object" src="{{ USER_PROFILE_IMAGE_URL.$branchDetails->user->slug.DS.$branchDetails->user->image() }}">
                                                @else
                                                    <img class="media-object" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class = 'control-label cate-label'>Branch Info</label>

                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <th>Location</th>
                                            <td>{{ $branchDetails->restaurantLocation->location() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td>{{ $branchDetails->restaurantLocation->country() }}</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ $branchDetails->restaurantLocation->state() }}</td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>{{ $branchDetails->restaurantLocation->city() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Zip Code</th>
                                            <td>{{ $branchDetails->restaurantLocation->zipCode() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone No</th>
                                            <td>{{ $branchDetails->phone() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{!! $branchDetails->description() !!}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>
                                                @if($branchDetails->restaurantCategory->isNotEmpty())
                                                    @foreach($branchDetails->restaurantCategory as $restaurantCategory)
                                                        <h6>
                                                            <span>{{ $restaurantCategory->category->name() }}</span>
                                                        </h6>
                                                    @endforeach
                                                @else
                                                    <h6>
                                                        <span>No Category Available</span>
                                                    </h6>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Service Type</th>
                                            <td>
                                                @if($branchDetails->restaurantServiceType->isNotEmpty())
                                                    <?php $serviceTypeIds = [];?>
                                                    @foreach($branchDetails->restaurantServiceType as $restaurantServiceType)
                                                        <?php $serviceTypeIds[] =  $restaurantServiceType->service_type_id; ?>
                                                    @endforeach

                                                    @foreach(serviceType() as $key => $service)
                                                        @if(isset($serviceTypeIds) && in_array($key,  $serviceTypeIds))
                                                            @foreach($branchDetails->restaurantServiceType as $restaurantServiceType)
                                                                @if($key == $restaurantServiceType->service_type_id)
                                                                    <h6><span>{{ $service }}</span></h6>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <h6>
                                                        <span>No Services Available</span>
                                                    </h6>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Opening</th>
                                            <td>
                                                @if($branchDetails->restaurantTime->isNotEmpty())
                                                    <?php $week = [];?>
                                                    @foreach($branchDetails->restaurantTime as $restaurantTime)
                                                        <?php $week[] =  $restaurantTime->day; ?>
                                                    @endforeach
                                                @endif
                                                @foreach(weekDay() as $key => $day)
                                                    @if(isset($week) && in_array($key,  $week))
                                                        @foreach($branchDetails->restaurantTime as $restaurantTime)
                                                            @if($key == $restaurantTime->day)
                                                                <h6>
                                                                    <span>{{ $day }} - </span>
                                                                    {{ date('h:i A', strtotime($restaurantTime->open)) }} -
                                                                    {{ date('h:i A', strtotime($restaurantTime->close)) }}
                                                                </h6>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <h6><span>{{ $day }} - </span> {{ ucfirst(strtolower(CLOSE)) }}</h6>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Image</th>
                                            <td>
                                                <div class="photo-gallery">
                                                    <ul>
                                                        @if($branchDetails->restaurantImage->isNotEmpty())
                                                            @foreach($branchDetails->restaurantImage as $restaurantImage)
                                                                @if($restaurantImage->image() !=='' && File::exists(RESTAURANT_ROOT_PATH.$restaurantImage->image()))
                                                                    <?php $image = RESTAURANT_URL.$restaurantImage->image(); ?>
                                                                @else
                                                                    <?php $image = WEBSITE_IMG_URL.'no-image.png'; ?>
                                                                @endif
                                                                <li>
                                                                    <img src="{{ $image }}">
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                <img src="{{ WEBSITE_IMG_URL.'no-image.png' }}">
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection