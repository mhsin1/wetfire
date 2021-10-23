@extends('layouts.admin')
@section('title' , 'City')
@section('styles')
	<style>
		.special-m{
			margin-top:4%;
		}
		.city-select{
			color:white;
			background:#2d3274;
			border-radius:25px;
			width:80%;
			margin-bottom:0px !important;
		}
	</style>
@endsection
@section('content')
					<input type="hidden" id="headerdata" value="{{ __('CITY') }}">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __('CITY') }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
											</li>
											<li><a href="javascript:;">{{ __('Manage Cities') }}</a></li>
											<li>
												<a href="{{ route('admin-city-index') }}">{{ __('Cities') }}</a>
											</li>
										</ul>
								</div>
							</div>
						</div>

						<div class="row mb-3">
						<div class="col-sm-12 table-contents">
							<a class="add-btn" data-href="{{route('admin-city-create')}}" id="add-data" data-toggle="modal" data-target="#modal1">
								<i class="fas fa-plus"></i> Add New City
							</a>
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
				                        <th width="20%">{{ __('City Name') }}</th>
				                        <th width="20%">{{ __('City Code') }}</th>
                                        <th>{{ __('State Name') }}</th>
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
            <p class="text-center">{{ __('You are about to delete this City. Everything under this City will be deleted') }}.</p>
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
               serverSide: true,
			   "bLengthChange": false,
			   "dom": '<"pull-left"f><"pull-right"l>tip',
               ajax: '{{ route('admin-city-datatables') }}',
               columns: [
                        { data: 'city_name', name: 'city_name' },
                        { data: 'city_code', name: 'city_code' },
                        { data: 'state_id', name: 'state_id' },
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

			$('input[type="search"]').attr('placeholder', 'City/Code/State...');
			// $(document).on('keyup', 'input[type="search"]', function() {
			// 	var value = $(this).val();
			// 	if(value.length > 0){
			// 		table.columns(0).search(value).draw();
			// 	}else{
			// 		table.columns(0).search(" ").draw();
			// 	}
			// });
    //   	$(function() {
    //     $(".btn-area").append('<div class="col-sm-4 table-contents">'+
    //     	'<a class="add-btn" data-href="{{route('admin-city-create')}}" id="add-data" data-toggle="modal" data-target="#modal1">'+
    //       '<i class="fas fa-plus"></i> Add New City'+
    //       '</a>'+
    //       '</div>');
    //   });

{{-- DATA TABLE ENDS--}}


$(document).on('change','.city-select',function () {

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
