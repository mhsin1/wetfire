@extends('layouts.admin') 

@section('styles')

<style type="text/css">
    
.input-field { 
    padding: 15px 20px; 
}

</style>

@endsection

@section('content')  

<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('All Orders') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Orders') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-order-index') }}">{{ __('All Orders') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="startDate">Start Date:</label>
                                                    <input type="date" class="form-control" id="startDate">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="endDate">End Date:</label>
                                                    <input type="date" class="form-control" id="endDate">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <div class="form-group mt-4">
                                                    <button id="filter" class="btn btn-primary">Filter</button>
                                                    <button id="clearFilter" class="btn btn-primary">Clear Filter</button>
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
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Customer Email') }}</th>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Order Date') }}</th>
                                                            <th>{{ __('Total Qty') }}</th>
                                                            <th>{{ __('Total Cost') }}</th>
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

{{-- ORDER MODAL --}}

<div class="modal fade" id="confirm-delete1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="submit-loader">
            <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
        </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ __('Update Status') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">{{ __("You are about to update the order's Status.") }}</p>
        <p class="text-center">{{ __('Do you want to proceed?') }}</p>
        <input type="hidden" id="t-add" value="{{ route('admin-order-track-add') }}">
        <input type="hidden" id="t-id" value="">
        <input type="hidden" id="t-title" value="">
        <textarea class="input-field" placeholder="Enter Your Tracking Note (Optional)" id="t-txt"></textarea>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- ORDER MODAL ENDS --}}



{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form id="emailreply">
                                    {{csrf_field()}}
                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="{{ __('Email') }} *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject') }} *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *" required=""></textarea>
                                        </li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub" type="submit">{{ __('Send Email') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

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

@endsection    

@section('scripts')

{{-- DATA TABLE --}}

    <script type="text/javascript">

        var table = $('#geniustable').DataTable({
               ordering: false,
               processing: true,
               serverSide: false,
               ajax: '{{ route('admin-order-datatables','none') }}',
               columns: [
                        { data: 'customer_email', name: 'customer_email' },
                        { data: 'id', name: 'id' },
                        { data: 'date', name: 'date' },
                        { data: 'totalQty', name: 'totalQty' },
                        { data: 'pay_amount', name: 'pay_amount' },
                        { data: 'action', searchable: false, orderable: false }
                     ],
               language : {
                    processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
                drawCallback : function( settings ) {
                        $('.select').niceSelect();  
                }
            });


$('#filter').on('click', function(e){
    e.preventDefault();
    var startDate = $('#startDate').val(),
        endDate = $('#endDate').val();

    $.fn.dataTableExt.afnFiltering.length = 0;
    
    filterByDate(6, startDate, endDate); // We call our filter function
    
    table.draw(); // Manually redraw the table after filtering
  });

  $('#clearFilter').on('click', function(e){
    e.preventDefault();
    $.fn.dataTableExt.afnFiltering.length = 0;
    $('#od_st').val("");
    $('#search').val("");
    $('#pm').val("");

    table.columns(4).search($('#pm').val()).draw();
    table.columns(5).search($('#od_st').val()).draw();
    table.search('').draw(); 
  });  

    // Date range filter
    minDateFilter = "";
    maxDateFilter = "";

  var filterByDate = function(column, startDate, endDate) {

	var sDay = new Date(startDate);
        sDay.setDate(sDay.getDate() -1);

    var eDay = new Date(endDate);
        eDay.setDate(eDay.getDate());

    var minDateFilter = sDay.getTime();
    var maxDateFilter = eDay.getTime();

    $.fn.dataTableExt.afnFiltering.push(
    function(oSettings, aData, iDataIndex) {
        if (typeof aData._date == 'undefined') {
            aData._date = new Date(aData[2]).getTime();
        }

        if (minDateFilter && !isNaN(minDateFilter)) {
            if (aData._date <= minDateFilter) {
                console.log("Min " + minDateFilter);
                return false;
            }
        }

        if (maxDateFilter && !isNaN(maxDateFilter)) {
            if (aData._date >= maxDateFilter) {
                console.log("Max " + maxDateFilter);
                return false;
            }
        }

        return true;
    });


	};
                         
    </script>

{{-- DATA TABLE --}}
    
@endsection   