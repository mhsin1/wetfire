@extends('layouts.admin')

@section('title' , 'Sales')

@section('styles')
    <style>
      .error{
        color:red;
        font-size:1rem;
      }
      .ml-00{
          margin-left:1px !important;
      }
     .active-yr, .btn:hover {
        background-color: #4841a8;
        color: white;
      }
      .active-mn, .btn:hover {
        background-color: #4841a8;
        color: white;
      }
      .active-br, .btn:hover {
        background-color: #4841a8;
        color: white;
      }

      @media screen and (max-width: 600px) {
        .btn-group{
          display:inline-block;
        }
        .mn{
          margin-top:10px;
        }
        .br{
          margin-top:10px;
        }
      }
    </style>
@endsection

@section('content')
<div class="container-fluid">

@if(session()->has('message'))
    <div id="alert" class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Sales</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group" id="years">
                    <button type="button" id="2020" class="yr btn btn-primary">2020</button>
                    <button type="button" id="2021" class="ml-00 yr btn btn-primary">2021</button>
                    <button type="button" id="2022" class="ml-00 yr btn btn-primary">2022</button>
                    <button type="button" id="2023" class="ml-00 yr btn btn-primary">2023</button>
                </div>
            </div>

            <div class="col-md-12 mt-2 mb-3">
                <div class="btn-group" id="months">
                    <button type="button" id="1" class="btn mn btn-primary">Jan</button>
                    <button type="button" id="2" class="ml-00 mn btn btn-primary">Feb</button>
                    <button type="button" id="3" class="ml-00 mn btn btn-primary">March</button>
                    <button type="button" id="4" class="ml-00 mn btn btn-primary">April</button>
                    <button type="button" id="5" class="ml-00 mn btn btn-primary">May</button>
                    <button type="button" id="6" class="ml-00 mn btn btn-primary">June</button>
                    <button type="button" id="7" class="ml-00 mn btn btn-primary">July</button>
                    <button type="button" id="8" class="ml-00 mn btn btn-primary">Aug</button>
                    <button type="button" id="9" class="ml-00 mn btn btn-primary">Sep</button>
                    <button type="button" id="10" class="ml-00 mn btn btn-primary">Oct</button>
                    <button type="button" id="11" class="ml-00 mn btn btn-primary">Nov</button>
                    <button type="button" id="12" class="ml-00 mn btn btn-primary">Dec</button>
                </div>
            </div>
     
        </div>


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="categoryTable" width="100%" cellspacing="0">
                  <thead>
                  @php 
                    $gbp = \App\Models\Currency::where(['name' => 'GBP'])->first();
                  @endphp
                    <tr>
                      <th>Date</th>
                      <th>Total (<small>{{$gbp?'£':'$'}}</small>)</th>
                      <th>Discount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>Date</th>
                    <th id="total">Total</th>
                    <th id="discount">Discount</th>
                    <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->


          <!-- Logout Modal-->
  <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select <span class="error">"Delete"</span> below if you are ready to delete the Category.</div>
        <div class="modal-footer">
          <button class="btn btn-success" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="deleteModel" href="#">Delete</a>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <!-- Page level plugins -->
  <!-- <script src="{{asset('public/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('public/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script> -->

  <!-- Page level custom scripts -->
  <!-- <script src="{{asset('public/js/demo/datatables-demo.js')}}"></script> -->

  <script>
     $("#alert").fadeTo(2000, 500).slideUp(500, function(){
       $("#alert").slideUp(600);
       });

        // Selection Area
        var d = new Date();
        var year = d.getFullYear();
        var month = d.getMonth() + 1;
        $('#'+year).addClass('active-yr');
        $('#'+month).addClass('active-mn');
        $(".br:first").addClass('active-br');

        // Add active class to the current button (highlight it)
        var header = document.getElementById("years");
        var btns = header.getElementsByClassName("yr");
        for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active-yr");
        current[0].className = current[0].className.replace(" active-yr", "");
        this.className += " active-yr";
        });
        }


                // Add active class to the current button (highlight it)
        var header = document.getElementById("months");
        var btns = header.getElementsByClassName("mn");
        for (var i = 0; i < btns.length; i++) {
          btns[i].addEventListener("click", function() {
          var current = document.getElementsByClassName("active-mn");
          current[0].className = current[0].className.replace(" active-mn", "");
          this.className += " active-mn";
          });
        }

        // Add active class to the current button (highlight it)
        // var header = document.getElementById("branches");
        // var btns = header.getElementsByClassName("br");
        // for (var i = 0; i < btns.length; i++) {
        //   btns[i].addEventListener("click", function() {
        //   var current = document.getElementsByClassName("active-br");
        //   current[0].className = current[0].className.replace(" active-br", "");
        //   this.className += " active-br";
        //   });
        // }

        $('.yr').click(function(){
            year = this.id;
            getData();
        });

        $('.mn').click(function(){
            month = this.id;
            getData();
        });


       function delete_click(clicked_id){
          $('#deleteModel').attr("href","{{url('deleteCategory')}}/"+clicked_id)
          $('#deleteCategoryModal').modal('show');
        }

        $('#categoryTable').DataTable({
              "fnDrawCallback": function( oSettings ) {
                var total = 0;
                $('#categoryTable > tbody  > tr td:nth-child(2)').each(function(index, td) { 
                    total = total + parseFloat($(td).text());
                });

                $('#total').text(total.toFixed(2) + " {{$gbp?'£':'$'}}");
              },
              "processing":true,
              "serverside":true,
              "bPaginate": false,
              "bInfo" : false,
              "pageLength": 50,
              "ajax":"{{url('admin/ajaxSales')}}/"+year+"/"+month,
              "columns":[
                {"data" : "date"},
                {"data" : "total"},
                {"data" : "discount"},
                {"data" : "action"}
              ]
            });

        function getData(){
          $('#categoryTable').DataTable().ajax.url("{{url('admin/ajaxSales')}}/"+year+"/"+month).load();
        }

  </script>
@endsection