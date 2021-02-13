@extends('admin.layouts.master')
@section('content')
<?php $url= URL::current();?>
<section class="content">
    <div class=" clearfix"></div>
    <div class="row">
         <!-- Filter Section -->
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header box-header-background with-border">
                  <h3 class="box-title">SEARCH BY FILTERS</h3>
                </div>
                <!-- /.box-header --> 
                <div class="box-body">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputEmail3">Start date</label>
                                <input class="form-control" type="text" name="start_date" id="start_date" placeholder="Start Date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputEmail3">End date</label>
                                <input class="form-control" type="text" name="end_date" id="end_date" placeholder="End Date">
                            </div>
                        </div>
                        <div class="col-md-3">
                         <button type="button" id="filter" class="btn btn-success btn-flat margin-top-25"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                        <a href="" class="btn btn-warning btn-flat margin-top-25"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Reset</a>
                     </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Filter Section -->
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title">{{ $title }}</h3>
                    <div class="box-tools pull-right">
                         @if(auth('web')->user()->role_id==1)
                        <a href="{{url('admin/products/create')}}" class="btn btn-warning" style="padding-bottom: 3px;"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Add</a>
                        @endif
                       
                    </div>
                </div>

                <!-- /.box-header --> 
                <div class="box-body table-responsive">
                    <table id="product-table" class="table table-bordered table-hover">
                        <input type="hidden" name="country" id="country" value="{{ (!empty($country)) ? ($country) : ('') }}">
                        <input type="hidden" name="data_table_name" id="data_table_name" value="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>S NO</th>
                               <!--  <th>Profile Picture</th> -->
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('public/Admin/DataTables/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('js')

<script type="text/javascript" src="{{ asset('public/Admin/DataTables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/Admin/DataTables/js/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('public/Admin/my-script.js') }}"></script>

<script type="text/javascript">

$(document).ready(function () {
     var url = '<?php echo $url; ?>';
     //alert(url)
     var today = new Date();
    $("#start_date").datepicker({
        dateFormat: 'd-m-yy',
        onClose: function (selectedDate) {
            $("#end_date").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#end_date").datepicker({
        dateFormat: 'd-m-yy',
        onClose: function (selectedDate) {
            $("#start_date").datepicker("option", "maxDate", selectedDate);
        }
    });
    if ($('#product-table').length > 0) {
        var dataTable = $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: "<'row ks-tableFilter'<'col-sm-4 text-left'l><'col-sm-4 text-center'f><'col-sm-4 text-right'B>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-12'p>>",
            language: {
                searchPlaceholder: "{{ Config::get('constants.SEARCH') }}"
            },
            buttons: [
                
            ],
            ajax: {
                url: url,
                type: 'GET',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            "fnDrawCallback": function (oSettings) {
                
                $('body').off('click', '[id^="changeStatus-"]').on('click', '[id^="changeStatus-"]', function (e) {
                    var self = $(this);
                    var tbl = 'products';
                    var id = $(this).attr('id').split('-')[1];
                    var status = $(this).attr('id').split('-')[2];

                    var msgStatus = status == 'Active' ? 'Inactive' : 'Active';
                    var msgStatus2 = status == 'Active' ? 'Inactivated' : 'Activated';

                    swal({
                        title: "Are you sure?",
                        text: "You want to " + msgStatus.toLowerCase() + " this record !!",
                        type: "warning",
                        confirmButtonText: 'Yes, ' + msgStatus.toLowerCase() + ' it!',
                        cancelButtonText: "No, cancel please!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then(function (value) {
                        if (value == 1) {
                            $.post(SITEURL + "/admin/change-status", {table: tbl, id: id, _token: '{{csrf_token()}}'},
                                    function (data) {
                                        if (data == '1') {
                                            if (status == 'Active') {
                                                self.attr('id', 'changeStatus-' + id + '-Inactive-').removeClass('btn-success').addClass('btn-danger').html("<i class='fa fa-thumbs-down'> Inactive </i>");
                                            } else {
                                                self.attr('id', 'changeStatus-' + id + '-Active-').removeClass('btn-danger').addClass('btn-info').html("<i class='fa fa-thumbs-up'> Active</i>");
                                            }
                                        }
                                    });
                            swal(msgStatus + "!", "Your record has been " + msgStatus2.toLowerCase() + "!", "success");
                        } else {
                             swal("Cancelled", "Your record is safe :)", "error"); 
                        }
                    });
                });
            },
            columns: [
                {data: 'id', name: 'id', 'visible': false},
                {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false,searchable: false},
                //{data: 'profile_picture', name: 'profile_picture', 'visible': true,orderable: false,searchable: false},
                {data: 'product_name', name: 'product_name', 'visible': true},
                {data: 'quantity', name: 'quantity', 'visible': true},
                {data: 'price', name: 'price', 'visible': true},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at','visible': true },
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
        });
    }
    $('#filter').click( function () {
      dataTable.draw();
    });
});

</script>

@endsection
