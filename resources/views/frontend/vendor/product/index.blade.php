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
                                        <a href="{{ url('add-product') }}">
                                             <button type="button" class="btn add-product">+ Add Product</button>
                                        </a>
                                    </span>
                                </div>
                            </div>
                           <!--  <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category Name</th>
                                    <th>Brand Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Sale Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($getproduct as $product)
                                    <tr>
                                        <td>{{$product->name}}</td>
                                        <td>{{checkCategoryName($product->category_id)}}</td>
                                        <td>@if(!empty($product->brand_id)){{checkBrandName($product->brand_id)}}@endif</td>
                                        <td><img src="{{url('product/'.$product->image)}}"></td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->sale_price}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>
                                            @if($product->status==1)
                                                <label class="label label-success">Active</label>
                                            @else
                                                <label class="label label-danger">Inactive</label>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('vendor/product/edit/'.$product->id)}}" class="btn btn-success">Edit</a>
                                            <a href="{{url('vendor/product/delete/'.$product->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table> -->
                            <div class="search-div">
                                <div class="row">
                                    <div class="form-group col-md-4 sort-data">
                                        <label>Sort: </label>
                                        <select>
                                            <option>10</option>
                                            <option>50</option>
                                            <option>100</option>
                                            <option>150</option>
                                        </select>
                                        <span>entries</span>
                                    </div>
                                    <div class="form-group col-md-8 search-data">
                                         <select>
                                            <option>Product</option>
                                            <option>Category</option>
                                            <option>Brand</option>
                                        </select>
                                        <input type="Search" name="" placeholder="Search">
                                    </div>

                                </div>
                            </div>
                            <div class="table-responsive">
                             <table class="table product-table">
                                <thead class="thead-dark">
                                  <tr>
                                    <th>Name <i class="fa fa-sort" aria-hidden="true"></i></th>
                                    <th>Category<i class="fa fa-sort" aria-hidden="true"></i></th>
                                    <th>Brand<i class="fa fa-sort" aria-hidden="true"></i></th>
                                    <th>Image <i class="fa fa-sort" aria-hidden="true"></i></th>
                                    <th>Price <i class="fa fa-sort" aria-hidden="true"></i></th>
                                    <th>Sale Price <i class="fa fa-sort" aria-hidden="true"></i></th>
                                    <th>Quantity <i class="fa fa-sort" aria-hidden="true"></i></th>
                                    <th>Action <i class="fa fa-sort" aria-hidden="true"></i></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>
                                        <div class="action-icon">
                                            <i class="fa fa-eye"></i>
                                            <i class="fa fa-pencil-square-o"></i>
                                            <i class="fa fa-trash"></i>
                                        </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>
                                        <div class="action-icon">
                                            <i class="fa fa-eye"></i>
                                            <i class="fa fa-pencil-square-o"></i>
                                            <i class="fa fa-trash"></i>
                                        </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>xyz</td>
                                    <td>
                                        <div class="action-icon">
                                            <i class="fa fa-eye"></i>
                                            <i class="fa fa-pencil-square-o"></i>
                                            <i class="fa fa-trash"></i>
                                        </div>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            
                            <div class="table-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                      <ul class="pagination justify-content-end">
                                        <li class="page-item">
                                          <a class="page-link" href="#" aria-label="Previous">
                                            Previous
                                          </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                          <a class="page-link" href="#" aria-label="Next">
                                          Next
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                   <!--  <div class="col-md-4">
                                        <div class="pre-next-btns">
                                            <button class="btn pre-btn" type="button">Previous</button>
                                            <button class="btn pre-btn" type="button">Next</button>
                                        </div>
                                    </div> -->
                                </div>
                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>
@endsection