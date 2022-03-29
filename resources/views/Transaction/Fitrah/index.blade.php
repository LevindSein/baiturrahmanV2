@extends('Layout.index')

@section('content-title')
@include('Transaction.Fitrah.Partial._title')
@endsection

@section('content-body')
@include('Transaction.Fitrah.Partial._subheader')

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover" id="dtable" style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Muzakki</th>
                                    <th>Jumlah</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-modal')
@include('Transaction.Fitrah.Partial._modal')
@endsection

@section('content-js')
<script>
    var dtable = $('#dtable').DataTable({
        language : {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        serverSide : true,
        ajax : "/production/transaction/fitrah",
        columns : [
            { data: 'code', name: 'code', class : 'text-center align-middle' },
            { data: 'muzakki', name: 'muzakki', class : 'text-center align-middle' },
            { data: 'jumlah', name: 'jumlah', class : 'text-center align-middle' },
            { data: 'action', name: 'action', class : 'text-center align-middle' },
        ],
        stateSave : true,
        deferRender : true,
        pageLength : 5,
        aLengthMenu : [[5,10,25,50,100], [5,10,25,50,100]],
        order : [[ 0, "asc" ]],
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [3] },
            { "bSearchable": false, "aTargets": [3] }
        ],
        scrollY : "50vh",
        scrollX : true,
        preDrawCallback : function( settings ) {
            scrollPosition = $(".dataTables_scrollBody").scrollTop();
        },
        drawCallback : function( settings ) {
            $(".dataTables_scrollBody").scrollTop(scrollPosition);
            if(typeof rowIndex != 'undefined') {
                dtable.row(rowIndex).nodes().to$().addClass('row_selected');
            }
            setTimeout( function () {
                $("[data-toggle='tooltip']").tooltip();
            }, 10)
        },
    });

    setInterval(function(){
        dtableReload();
    }, 60000);

    function dtableReload(searchKey = null){
        if(searchKey){
            dtable.search(searchKey).draw();
        }

        dtable.ajax.reload(function(){
            console.log("Refresh Automatic")
        }, false);

        $(".tooltip").tooltip("hide");

        $(".popover").popover("hide");
    }
</script>
@endsection
