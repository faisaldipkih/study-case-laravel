@extends('Layout')
@section('title', 'Users')
@section('sub-title', 'Data User')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-add-student">Tambah
                                User</button>
                        </div> --}}
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table-user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Gagal Login</th>
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
        <div class="modal fade" id="modal-add-student" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="submit-student">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama User</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Masukan nama lengkap">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    placeholder="Masukan nama lengkap">
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
    var table = $('#table-user').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('user.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'fail_login', name: 'fail_login'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });
})

function active(id){
    Swal.fire({
        title: "Kamu Yakin?",
        text: "Mengaktifkan Akun ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Aktifkan"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/user/active`,
                type: 'PUT',
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    user_id:id
                },
                async: false,
                dataType: 'JSON',
                success: function(data) {
                    if(data.success){
                        Swal.fire({
                            title: "Aktif!",
                            text: data.message,
                            icon: "success"
                        }).then((result) => {
                            location.href = '/user';
                        });
                    }
                }
            })
        }
    });
}
</script>
@endsection
