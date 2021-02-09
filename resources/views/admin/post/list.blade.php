@extends('admin.layouts.master')
@section('content')
<?php $url= URL::current();?>
<section class="content">
    <div class=" clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header box-header-background with-border">
                    <h3 class="box-title">{{ $title }}</h3>
                    <div class="box-tools pull-right">                        
                        <a href="{{url('admin/posts/create')}}" class="btn btn-warning" style="padding-bottom: 3px;"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Add</a>  
                    </div>
                </div>

                <!-- /.box-header --> 
                <div class="box-body table-responsive">
                    <table id="post-table" class="table table-bordered table-hover">
                        <input type="hidden" name="table_name" id="table_name" value="posts">
                        <input type="hidden" name="data_table_name" id="data_table_name" value="post-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>S NO</th>
                                <th>Title</th>
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
    if ($('#post-table').length > 0) {
        var tableData = $('#post-table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'lBfrtip',
            language: {
                searchPlaceholder: "{{ Config::get('constants.SEARCH') }}"
            },
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                },
            ],
            ajax: {
                url: url,
                type: 'GET',
            },
            "fnDrawCallback": function (oSettings) {
                
                $('body').off('click', '[id^="changeStatus-"]').on('click', '[id^="changeStatus-"]', function (e) {
                    var self = $(this);
                    var tbl = 'posts';
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
                {data: 'title', name: 'title', 'visible': true},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at','visible': true },
                {data: 'action', name: 'action', orderable: false},
            ],
            order: [[0, 'desc']]
        });
    }
});

</script>

@endsection
