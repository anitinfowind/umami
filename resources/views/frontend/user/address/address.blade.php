@extends('frontend.layouts.app')
@section ('title', trans('User add address'))
@section('content')

  <div class="dashboard-wrap">
      <div class="container">
          <div class="row">
              @include('frontend.user.sidebar')
              <div class="col-md-9">
                  <div class="dashboard-container">
                      <div class="m-4">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="add-bx">
                                      <a href="{{ url('add-address') }}">
                                          <img src="{{ WEBSITE_IMG_URL.'add-image.png' }}" class="img-fluid address-img">
                                      </a>
                                  </div>
                              </div>
                              @if($userAddresses->isNotEmpty())
                                  @foreach($userAddresses as $userAddress)
                                      <div class="col-md-6" id="address_{{ $userAddress->id }}">
                                          <div class="border addr-bx">
                                              <h5>{{ $userAddress->addressType() }}
                                                  <div class="form-group custom-checkbox-div">
                                                      @if($userAddress->isPrimaryAddress())
                                                          <input
                                                                  type="hidden"
                                                                  class="status"
                                                                  id="status_{{ $userAddress->id }}"
                                                                  value="{{ INACTIVE }}"
                                                          >
                                                          <input
                                                                    onclick='primaryAddress("{{ $userAddress->id }}")'
                                                                    type="checkbox"
                                                                    id="html_{{ $userAddress->id }}",
                                                                    class="all"
                                                                    checked
                                                            >
                                                      @else
                                                          <input
                                                                  type="hidden"
                                                                  class="status"
                                                                  id="status_{{ $userAddress->id }}"
                                                                  value="{{ ACTIVE }}"
                                                          >
                                                          <input
                                                                  onclick='primaryAddress("{{ $userAddress->id }}")'
                                                                  type="checkbox"
                                                                  id="html_{{ $userAddress->id }}"
                                                                  class="all"
                                                          >

                                                      @endif
                                                      <label for="html_{{ $userAddress->id }}"></label>
                                                  </div>
                                              </h5>

                                              <h6><b>Address :</b> {{ $userAddress->streetAddress() }}, {{ isset($userAddress->city->name)?$userAddress->city->name:'' }} {{
                                              isset($userAddress->state->name)?$userAddress->state->name:'' }}, {{ isset($userAddress->pincode)?$userAddress->pincode:'' }}</h6>
                                              <h6>{{ isset($userAddress->country->name)?$userAddress->country->name:'' }}</h6>
                                              <h6><b>Land Mark :</b> {{ isset($userAddress->landmark)?$userAddress->landmark:'' }}</h6>
                                              <h6><a href="#">Add delivery instruction</a></h6>
                                              <div class="">
                                                  <span><a href="{{ url('edit-address', $userAddress->id) }}">Edit</a></span> |
                                                  <span>
                                                      <a href="javascript:void(0)" onclick='removeAddress("{{ $userAddress->id }}")'>
                                                          Remove
                                                      </a>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection