@extends('layouts.master')

@section('title')
  المنتجات
@endsection

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
			<!-- breadcrumb -->
			 	<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
				<!-- row opened -->
				<div class="row row-sm">

                        <!-- strart session success -->
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session()->get('success') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <!-- End session success    -->

                        <!-- strart session error -->
                        @if (session()->has('Error'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session()->get('Error') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <!-- End session error    -->

				     <!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
                                    @can('اضافة منتج')
                                    <div class="col-sm-6 col-md-4 col-xl-3">
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافه منتج</a>
									</div>
                                    @endcan
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap " data-page-length='50'>
										<thead>
											<tr>
												<th class="borde-0">#</th>
												<th class="border-bottom-0">اسم المنتج</th>
												<th class="border-bottom-0">القسم</th>
												<th class="border-bottom-0">الوصف</th>
												<th class="border-bottom-0">العمليات</th>

											</tr>
										</thead>
										<tbody>
                                            <?php  $i=0;  ?>

                                                @foreach ($products as $product )
                                                <?php  $i++; ?>
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$product->product_name}}</td>
                                                    <td>{{$product->section->section_name}}</td>
                                                    <td>{{$product->description}}</td>
                                                    <td>
                                                        {{-- <a href="{{route('sections.edit', $section->id,"#modaldemo12")}}" class=" btn btn-sm btn-info" title="تعديل"><i class="las la-pen"></i>تعديل قسم</a> --}}

                                                        @can('تعديل منتج')
                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                              data-id="{{$product->id}}"
                                                              data-section_name="{{$product->section->section_name}}"
                                                              data-product_name="{{$product->product_name}}"
                                                              data-description="{{$product->description}}" data-toggle="modal"
                                                              data-target="#edit_Product"   title="تعديل"><i class="las la-pen"></i></a>

                                                         @endauth

                                                         @can('حذف منتج')
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{$product->id}}"
                                                            data-section_name="{{$product->section->section_name}}"
                                                            data-product_name="{{$product->product_name}}"
                                                            data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                                class="las la-trash"></i> </a>
                                                          @endcan
                                                    </td>

                                                </tr>

                                                @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->
                      <!-- Modal effects -->
                      <div class="modal" id="modaldemo8">
                        <div class="modal-dialog modal-dialog-centered" role="document">

                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">Modal Header</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('products.store') }}" method="post">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">اسم المنتج</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name">
                                            @error('product_name')
                                            <small class="form-text text-danger">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                                        <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            @error('description')
                                            <small class="form-text text-danger">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>

                                        </div>
                                    </form>

                                </div>
                             </div>
                        </div>
                      </div>
                    <!-- End Modal effects-->

                    <!-- edit -->
                        <div class="modal fade" id="edit_Product"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form action="products/update" method="post" autocomplete="off">
                                        {{ method_field('patch') }}
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id" value="">
                                            <label for="recipient-name" class="col-form-label">اسم القسم:</label>
                                            <input class="form-control" name="product_name" id="product_name" type="text">
                                        </div>

                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                                        <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                            @foreach ($sections as $section)
                                                <option >{{ $section->section_name }}</option>  {{-- value in product controller --}}
                                            @endforeach
                                        </select>

                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">ملاحظات:</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">تاكيد</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                     <!-- delete -->
                        <div class="modal" id="modaldemo9">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                            type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form action="products/destroy" method="post">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                            <input type="hidden" name="id" id="id" value="">
                                            <input class="form-control" name="section_name" id="section_name" type="text" readonly>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>



			        	</div>
				<!-- /row -->

			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection


@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<!-- edit Modal js-->
<script>
    $('#edit_Product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })
</script>

<!-- delete Modal js-->
<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(product_name);
    })
</script>
@endsection


