@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="card">
                        <div class="card-header">{{__('messages.Edit your Offer')}}</div>
                        <div class='card-body'>
                            <form method="POST" id="offerForm" action="" enctype="multipart/form-data">
                                        @csrf
                                        {{-- <input name="_token" value="{{csrf_token()}}"> --}}

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('messages.Name_ar offer')}}</label>
                                            <input type="text" class="form-control" name="name_ar" value=''
                                                placeholder="{{ __('messages.Name_ar offer')}}">
                                             @error('name_ar')
                                             <small class="form-text text-danger">{{$message}}</small>
                                             @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputName_en">{{ __('messages.Name_en offer')}}</label>
                                            <input type="text" class="form-control" name="name_en" value=''
                                                placeholder="{{ __('messages.Name_en offer')}}">
                                             @error('name_en')
                                             <small class="form-text text-danger">{{$message}}</small>
                                             @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('messages.price offer')}}</label>
                                            <input type="text" class="form-control" name="price" value=''
                                                placeholder="{{ __('messages.price offer')}}">
                                             @error('price')
                                             <small class="form-text text-danger">{{$message}}</small>
                                             @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputdetailes">{{ __('messages.detailes_ar offer')}}</label>
                                            <input type="text" class="form-control" name="details_ar" value=''
                                                 placeholder="{{ __('messages.detailes_ar offer')}}">

                                             @error('details_ar')
                                             <small class="form-text text-danger">{{$message}}</small>
                                             @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputdetailes">{{ __('messages.detailes_en offer')}}</label>
                                            <input type="text" class="form-control" name="details_en" value=''
                                                 placeholder="{{ __('messages.detailes_en offer')}}">

                                             @error('details_en')
                                             <small class="form-text text-danger">{{$message}}</small>
                                             @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputdetailes">{{ __('messages.add photo offer')}}</label>
                                            <input type="file" class="form-control" name="photo" value=''
                                                 placeholder="{{ __('messages.add photo offer')}}">


                                             @error('photo')
                                             <small class="form-text text-danger">{{$message}}</small>
                                             @enderror

                                        </div>


                                        <button id="save_offer" class="btn btn-primary">{{__('messages.btn save')}}</button>
                            </form>
                        </div>
                </div>
                    </div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
