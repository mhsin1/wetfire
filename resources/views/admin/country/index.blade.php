@extends('layouts.admin')
@section('title' , 'Countries')
@section('styles')
	<style>
		.special-m{
			margin-top:4%;
		}
		.country-select{
			color:white;
			background:#2d3274;
			border-radius:25px;
			width:50%;
			margin-bottom:0px !important;
		}
	</style>
@endsection
@section('content')
					<input type="hidden" id="headerdata" value="{{ __('COUNTRY') }}">
					<input type="hidden" id="attribute_data" value="{{ __('ADD NEW ATTRIBUTE') }}">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __('COUNTRIES') }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
											</li>
											<li><a href="javascript:;">{{ __('Manage Countries') }}</a></li>
											<li>
												<a href="{{ route('admin-country-index') }}">{{ __('Main Countries') }}</a>
											</li>
										</ul>
								</div>
							</div>
						</div>

						<div class="row">
                                <div class="col-lg-12">
                                    <form>
                                        <div class="row filters">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="search">Search:</label>
                                                    <input type="text" class="form-control" placeholder="Name/Code" id="search">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="st">Status:</label>
                                                    <select class="form-control" id="st">
                                                        <option value="">-Select-</option>
                                                        <option value="0">Activated</option>
                                                        <option value="1">Deactivated</option>
                                                    </select>
                                                </div>
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
				                        <th width="20%">{{ __('Country Name') }}</th>
				                        <th width="20%">{{ __('Country Code') }}</th>
                                        <th>{{ __('Status') }}</th>
				                        <th>{{ __('Options') }}</th>
										<th>{{ __('Stat') }}</th>
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
            <p class="text-center">{{ __('You are about to delete this Country. Everything under this country will be deleted') }}.</p>
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
	            ordering: false,
               ajax: '{{ route('admin-country-datatables') }}',
               columns: [
                        { data: 'country_name', name: 'country_name' },
                        { data: 'country_code', name: 'country_code' },
                        { data: 'status', searchable: false, orderable: false},
            			{ data: 'action', searchable: false, orderable: false },
                        { data: 'stat', name: 'stat' }

                     ],
                language : {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
				drawCallback : function( settings ) {
	    				$('.select').niceSelect();
				}
            });

		table.column(4).visible( false );

		$(document).on('change', '#st', function() {
			var value = $(this).val();
			table.columns(4).search(value).draw();
		});

		$(document).on('keyup', '#search', function() {
			var value = $(this).val();
			table.search(value).draw();
		});
		
      	$(function() {
        $(".filters").append('<div class="special-m col-sm-6 table-contents">'+
        	'<a class="add-btn" data-href="{{route('admin-country-create')}}" id="add-data" data-toggle="modal" data-target="#modal1">'+
          '<i class="fas fa-plus"></i> Add New Country'+
          '</a>'+
          '</div>');
      });

{{-- DATA TABLE ENDS--}}


$(document).on('change','.country-select',function () {

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
