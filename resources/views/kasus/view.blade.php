@extends('layouts.admin')

@section('title')
Kasus
@endsection

@section('title-card')
Daftar Kasus
@endsection

@section('menu-kasus')
active
@endsection

@section('menu-kasus-daftar')
active
@endsection


@section('content')
@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('status')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{session('warning')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
<div class="col-12 table-responsive">
        <table class="table" style="width:100%">
            <tbody>
                <tr>
                    <td><strong>Nama Kasus</strong></td>
                    <td>
                        <input type="text" class="form-control" value="{{$kasus->nama_kasus}}" disabled>
                    </td>
                </tr>
                <tr>
                    <td><strong>Solusi</strong></td>
                    <td>
                        <textarea rows="5" class="form-control" disabled>{{$kasus->solusi}}</textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered table-hover" style="width:100%" id="table_id">
            <thead>
                <tr>
                    <th style="width: 70%">Fitur</th>
                    <th style="width: 10%">Bobot</th>
                    <th style="width: 20%">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($detail_fitur as $df)
                <tr>
                    <td>{{$df->Fitur()->nama_fitur}}</td>
                    <td>{{$df->bobot}}</td>
                    <td>
                        <a href="{{route('fitur.edit', ['fitur' => $df->fitur_id])}}" class="btn btn-warning btn-sm mr-2">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-remote="{{route('fitur.destroy', ['fitur' => $df->fitur_id])}}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<a href="{{route('fitur.create')}}" id="add_fitur" hidden></a>
@endsection

@section('modal')
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Kasus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="" id="form-delete" class="form-inline" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="form-btn_delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready( function () {
        var table = $('#table_id').DataTable({
            dom: 'Brtip',
            buttons: [
                {
                    text: 'Tambah Fitur',
                    action: function ( e, dt, node, config ) {
                        document.getElementById("add_fitur").click();
                    }
                }
            ]
        });

        $('#table_id tbody').on('click', 'button', function () {
            var url = $(this).data('remote');
            $('#modal-delete').modal('show');
            $('#form-delete').attr('action', url);

            var tr = $(this).closest('tr');
            var row = table.row(tr).data();
            document.getElementById('modal-body').innerHTML = 'Apakah anda yakin menghapus kasus <strong>' + row[0]+ '</strong> ?';
        });
    });
</script>
@endsection
