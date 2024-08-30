@extends('Layout')
@section('title', 'Rekening')
@section('sub-title', 'Data Rekening Nasabah')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <?php if(session('login_data')['role'] == 'cs'){ ?>
                        <div class="card-header">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-add-pengajuan">Pengajuan Nasabah</button>
                        </div>
                        <?php } ?>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table-rekening" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Pekerjaan</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Nominal Store</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <!-- Modal -->
        <div class="modal fade" id="modal-add-pengajuan" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Pengajuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="submit-pengajuan">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" id="name" name="nama_lengkap" class="form-control"
                                    placeholder="Masukan nama lengkap">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control"
                                    placeholder="Masukan tempat lahir">
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" id="jenis">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="works">Pekerjaan</label>
                                <select name="works_id" class="form-control" id="works">
                                    <option value="">Pilih Pekerjaan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="provinsi">Provinsi</label>
                                <select class="form-control" id="provinsi" onchange="getKab(event)">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kabupaten">Kabupaten</label>
                                <select class="form-control" id="kabupaten" onchange="getKec(event)">
                                    <option value="">Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <select class="form-control" id="kecamatan" onchange="getDesa(event)">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="desa">Desa</label>
                                <select class="form-control" id="desa" onchange="setAlamat()">
                                    <option value="">Pilih Desa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="nominal_setor">Nominal Setor</label>
                                <input type="number" id="nominal_setor" name="nominal_setor" class="form-control"
                                    placeholder="Masukan nominal setor">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function(){
            $.ajax({
                url: `/api/works`,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    let html = '<option value="">Pilih Pekerjaan</option>'
                    data.data.forEach(element => {
                        html += `<option value="${element.id}">${element.name}</option>`
                    });
                    $('#works').html(html)
                }
            })
            $.ajax({
                url: `/api/provinsi`,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    let html = '<option value="">Pilih Provinsi</option>'
                    data.data.forEach(element => {
                        html += `<option value="${element.code_prov}">${element.name_prov}</option>`
                    });
                    $('#provinsi').html(html)
                }
            })
            var table = $('#table-rekening').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rekening.list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama_lengkap', name: 'nama_lengkap'},
                    {data: 'pekerjaan', name: 'pekerjaan'},
                    {data: 'tempat_lahir', name: 'tempat_lahir'},
                    {data: 'tgl_lahir', name: 'tgl_lahir'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'nominal_rupiah', name: 'nominal_rupiah'},
                    {data: 'status_pengajuan', name: 'status_pengajuan'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        })
        function getKab(e){
            $.ajax({
                url: `/kabupaten/show-prov?code_prov=${e.target.value}`,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    let html = '<option value="">Pilih Kabupaten</option>'
                    data.data.forEach(element => {
                        html += `<option value="${element.code_kab}">${element.name_kab}</option>`
                    });
                    $('#kabupaten').html(html)
                }
            })
        }
        function getKec(e){
            $.ajax({
                url: `/kecamatan/show-kab?code_kab=${e.target.value}`,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    let html = '<option value="">Pilih Kecamatan</option>'
                    data.data.forEach(element => {
                        html += `<option value="${element.code_kec}">${element.name_kec}</option>`
                    });
                    $('#kecamatan').html(html)
                }
            })
        }
        function getDesa(e){
            $.ajax({
                url: `/desa/show-kec?code_kec=${e.target.value}`,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    let html = '<option value="">Pilih Desa</option>'
                    data.data.forEach(element => {
                        html += `<option value="${element.code_desa}">${element.name_desa}</option>`
                    });
                    $('#desa').html(html)
                }
            })
        }
        function setAlamat(){
            let alamat = `${$('#provinsi option:selected').text()}, ${$('#kabupaten option:selected').text()}, ${$('#kecamatan option:selected').text()}, ${$('#desa option:selected').text()}, `;
            $('#alamat').val(alamat);
        }
        function approve(id){
            Swal.fire({
                title: "Kamu Yakin?",
                text: "Approve pengajuan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, approve"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/rekening-nasabah/approve`,
                        type: 'PUT',
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            rekening_id:id
                        },
                        async: false,
                        dataType: 'JSON',
                        success: function(data) {
                            if(data.success){
                                Swal.fire({
                                    title: "Approve!",
                                    text: data.message,
                                    icon: "success"
                                }).then((result) => {
                                    location.href = '/rekening-nasabah';
                                });
                            }
                        }
                    })
                }
            });
        }
        $('#submit-pengajuan').submit(function(e) {
            e.preventDefault();
            let data = new FormData(this);
            console.log(data);
            $.ajax({
                url: '/rekening-nasabah',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                        }).then((result) => {
                            location.href = '/rekening-nasabah';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        }).then((result) => {});
                    }
                }
            });
        })
    </script>
@endsection
