@extends('layouts.admin')

@section('styles')
	<style>
		.child-select{
			color:white;
			background:#2d3274;
			border-radius:25px;
			margin-bottom:0px !important;
		}
	</style>
@endsection
@section('content')
					<input type="hidden" id="headerdata" value="{{ __('SUB CHILD CATEGORY') }}">
<input type="hidden" id="attribute_data" value="{{ __('ADD NEW ATTRIBUTE') }}">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __('Sub Child Categories') }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
											</li>
											<li><a href="javascript:;">{{ __('Manage Categories') }}</a></li>
											<li>
												<a href="{{ route('admin-subchildcat-index') }}">{{ __('Child Categories') }}</a>
											</li>
										</ul>
								</div>
							</div>
						</div>

						<div class="row">
                                <div class="col-lg-12">
                                    <form>
                                        <div class="row filters-row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="search">Category:</label>
                                                    <input type="text" class="form-control" id="category">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
													<div class="form-group">
													<label for="search">Sub Category:</label>
													<input type="text" class="form-control" id="subcategory">
												</div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
													<label for="search">Name:</label>
													<input type="text" class="form-control" id="search">
                                                </div>
                                            </div>
											<div class="col-md-2 mt-4">
												<button id="clearFilter" class="btn btn-primary">Clear Filter</button>
											</div>
                                        </div>
                                    </form>
                                </div>
                            </div>


						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
									<div class="mr-table allproduct">

                        @include('includes.admin.form-success')

										<div class="table-responsiv">
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
															<th>{{ __('Category') }}</th>
															<th>{{ __('Sub Category') }}</th>
															<th>{{ __('Child Category') }}</th>
															<th>{{ __('Name') }}</th>
															<th>{{ __('Slug') }}</th>
															<th width="20%">{{ __('Attributes') }}</th>
															<th>{{ __('Status') }}</th>
															<th>{{ __('Options') }}</th>
																				</tr>
													</thead>
												</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

{{-- ADD / EDIT MODAL --}}

										<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

										<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
												<div class="submit-loader">
														<img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
												</div>
											<div class="modal-header">
											<h5 class="modal-title"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">

											</div>
											<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
											</div>
										</div>
										</div>
</div>

{{-- ADD / EDIT MODAL ENDS --}}

{{-- ATTRIBUTE MODAL --}}

										<div class="modal fade" id="attribute" tabindex="-1" role="dialog" aria-labelledby="attribute" aria-hidden="true">

										<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
												<div class="submit-loader">
														<img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
												</div>
											<div class="modal-header">
											<h5 class="modal-title"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">

											</div>
											<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
											</div>
										</div>
										</div>
</div>

{{-- ATTRIBUTE MODAL ENDS --}}


{{-- DELETE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

	<div class="modal-header d-block text-center">
		<h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
	</div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center">{{ __('You are about to delete this Sub Child Category. Everything under this category will be deleted.') }}</p>
            <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- DELETE MODAL ENDS --}}

@endsection


@section('scripts')

{{-- DATA TABLE --}}

    <script type="text/javascript">

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
			   serverSide: false,
			   sDom: 'lrtip',
               ajax: '{{ route('admin-subchildcat-datatables') }}',
               columns: [
						   { data: 'category'},
						   { data: 'subcategory'},
               			{ data: 'childcategory'},
    	                { data: 'name', name: 'name' },
								{ data: 'slug', name: 'slug' },
                    { data: 'attributes', name: 'attributes', searchable: false, orderable: false },
                    { data: 'status', searchable: false, orderable: false},
            				{ data: 'action', searchable: false, orderable: false }
								],
                language : {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
				drawCallback : function( settings ) {
	    				$('.select').niceSelect();
				}
            });

		$(document).on('keyup', '#search', function() {
			var value = $(this).val();
			if(value.length > 0){
				table.columns(2).search(value).draw();
			}else{
				table.columns(2).search(" ").draw();
			}
		});

		$(document).on('keyup', '#category', function() {
			var value = $(this).val();
			table.columns(0).search(value).draw();
		});

		$(document).on('keyup', '#subcategory', function() {
			var value = $(this).val();
			table.columns(1).search(value).draw();
		});
		
      	$(function() {
        $(".filters-row").prepend('<div class="col-sm-12 mb-3 text-right">'+
        	'<a class="add-btn" data-href="{{route('admin-subchildcat-create')}}" id="add-data" data-toggle="modal" data-target="#modal1">'+
          '<i class="fas fa-plus"></i> {{ __('Add New Sub Child Category') }}'+
          '</a>'+
          '</div>');
      });

	  $('#clearFilter').on('click', function(e){
			e.preventDefault();
			$('#category').val("");
			$('#search').val("");
			$('#subcategory').val("");

			table.columns(0).search($('#category').val()).draw();
			table.columns(1).search($('#subcategory').val()).draw();
			table.columns(2).search($('#search').val()).draw();
			table.search('').draw(); 
		});  

{{-- DATA TABLE ENDS--}}


$(document).on('change','.child-select',function () {

var link = $(this).val();

var data = $(this).find(':selected').attr('data-val');
if(data == 0)
{
  $(this).next(".nice-select.process.select1.vdroplinks").removeClass("drop-success").addClass("drop-danger");
}
else{
  $(this).next(".nice-select.process.select1.vdroplinks").removeClass("drop-danger").addClass("drop-success");
}
$.get(link);
$.notify("Status Updated Successfully.","success");
});

</script>

@endsection
