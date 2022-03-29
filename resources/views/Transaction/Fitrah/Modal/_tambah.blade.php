<!--begin::Modal-->
<div class="modal fade" id="tambah-modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="tambah-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah @include('Transaction.Fitrah.Partial._title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form id="tambah-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Rumusan</label>
                        <select class="form-control" id="tambah-rumusan" name="tambah_rumusan">
                            @foreach($rumusan as $d)
                            <option value="{{$d->id}}">Kategori {{$d->kategori}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilih Muzakki</label>
                        <select class="form-control" id="tambah-muzakki" name="tambah_muzakki" style="width:100%"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Check</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Javascript-->
<script>
    function tambah_init(){
        $("#tambah-rumusan").prop("selectedIndex", 0).val();
        $("#tambah-muzakki").val('').html('');
    }

    $("#add").click(function(){
        tambah_init();

        $("#tambah-modal").modal("show");
    });

    $('#tambah-muzakki').select2({
        placeholder: "Cari Muzakki",
        allowClear: true,
        ajax: {
            url: "/search/muzakki",
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (d) {
                        return {
                            id: d.id,
                            text: d.name + '(' + d.hp + ')'
                        }
                    })
                };
            },
        }
    });
</script>
<!--end::Javascript-->
