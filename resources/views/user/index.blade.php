@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('user/create') }}" class="btn btn-primary btn-sm">Tambah</a>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-3">
            <label class="col-1 col-form-label">Filter</label>
            <div class="col-3">
                <select class="form-control" id="level_id">
                    <option value="">- Semua -</option>
                    @foreach($level as $item)
                        <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Level Pengguna</small>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="table_user">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function () {
    let table = $('#table_user').DataTable({
        processing: true,
        serverSide: false, // Ubah ke false karena kita menggunakan data manual
        ajax: {
            url: "{{ url('user/list') }}",
            type: "POST",
            data: function (d) {
                d.level_id = $('#level_id').val();
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "username", orderable: true, searchable: true },
            { data: "nama", orderable: true, searchable: true },
            { data: "level.level_nama", orderable: false, searchable: false },
            { data: "aksi", orderable: false, searchable: false }
        ]
    });

    $('#level_id').on('change', function () {
        table.ajax.reload();
    });
});
</script>
@endpush