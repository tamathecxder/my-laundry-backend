@extends('layouts.main')

    @section('top-side')
        @include('partials.topbar')
        @include('partials.sidebar')
    @endsection

@section('container')
    {{-- WRITE ALL THE CODES DOWN HERE --}}

    <!-- Modal -->
    <div class="modal fade" id="inputDataPaket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('paket.store') }}" id="formInputOutlet">
                        @csrf
                        <div id="method"></div>
                        <div class="mb-3">
                            <div class="col-md-6">
                                <label for="id_outlet" class="form-label">ID Outlet</label>
                                <select id="id_outlet" name="id_outlet" class="form-select" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    @foreach ($outlet as $ot)
                                        <option value="{{ $ot->id }}">{{ $ot->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select id="jenis" name="jenis" class="form-select" aria-label="Default select example" required>
                                <option selected>Open this select menu</option>
                                <option value="kiloan">Kiloan</option>
                                <option value="selimut">Selimut</option>
                                <option value="bed_cover">Bed Cover</option>
                                <option value="kaos">Kaos</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                          <label for="nama_paket" class="form-label">Nama paket</label>
                          <input type="text" name="nama_paket" class="form-control" id="nama_paket">
                        </div>
                        <div class="mb-3">
                          <label for="harga" class="form-label">Harga</label>
                          <input type="number"  name="harga" class="form-control" id="harga">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Kirimkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-lg-2 col-xlg-3 mx-auto">
        <div class="card card-hover" data-bs-toggle="modal" data-bs-target="#inputDataPaket">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-relative-scale"></i></h1>
                <h6 class="text-white">Input Data Paket</h6>
            </div>
        </div>
    </div>


    {{-- Pesan Success / Error --}}
    <div style="margin-top: 20px">
        @if (session('success'))
            <div class="alert alert-success" role="alert" id="success-alert">
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert" id="error-alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
        @endif
    </div>
    {{-- End Pesan Success / Error --}}

    <div class="container-fluid">
        {{-- tabel --}}
        <table class="table table-dark table-striped" id="tbl-paket">
            <thead class="table-info">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Id Outlet</th>
                  <th scope="col">Jenis Paket</th>
                  <th scope="col">Nama Paket</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paket as $pk)
                    <tr>
                        <td>{{ $index = (isset($index)) ? ++$index : $index = 1 }}</td>
                        <td>{{ $pk->id_outlet }}</td>
                        <td>{{ $pk->jenis }}</td>
                        <td>{{ $pk->nama_paket }}</td>
                        <td>{{ $pk->harga }}</td>
                        <td>
                            <div class="d-inline-flex">
                                <div class="col">
                                    <button class="btn btn-primary me-2 edit-barang" data-bs-toggle="modal" data-bs-target="#inputDataPaket"
                                      data-mode="edit"
                                      data-id="{{ $pk->id }}"
                                      data-id_outlet="{{ $pk->id_outlet }}"
                                      data-harga="{{ $pk->harga }}"
                                      data-nama_paket="{{ $pk->nama_paket }}"
                                      data-jenis="{{ $pk->jenis }}"
                                    > Edit
                                </div>
                              </button>
                              <form action="{{ route('paket.destroy', $pk->id) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger delete-paket">Hapus</button> &nbsp;
                              </form>
                            </div>
                          </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

@push('script')
<script>
// data tables
$(function() {
    $('#tbl-paket').DataTable()
  });

  // menghapus alert
  $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
    $("#success-alert").slideUp(500);
  });

  $("#error-alert").fadeTo(2000, 500).slideUp(500, function() {
    $("#success-alert").slideUp(500);
  });

// delete data outlet dengan sweetalert
$('.delete-paket').click(function(e) {
    e.preventDefault()
    let data1 = $(this).closest('tr').find('td:eq(1)').text()
    let data2 = $(this).closest('tr').find('td:eq(3)').text()
    swal({
      title: "Apakah kamu yakin ingin menghapusnya?",
      text: "Paket dengan id ke- "+data1+" dengan nama paket " + data2 + " yakin akan dihapus?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((req) => {
      if(req) $(e.target).closest('form').submit()
      else swal.close()
    })
  });

$('#inputDataPaket').on('show.bs.modal', function (e) {
    let button = $(e.relatedTarget);
    // console.log(button);
    let id = button.data('id');
    let id_outlet = button.data('id_outlet');
    let harga = button.data('harga');
    let nama_paket = button.data('nama_paket');
    let jenis = button.data('jenis');
    let mode = button.data('mode');
    let modal = $(this);

    if ( mode == 'edit' ) {
        modal.find('.modal-title').text('Edit data outlet');
        modal.find('.modal-body #id_outlet').val(id_outlet).change();
        modal.find('.modal-body #harga').val(harga).change();
        modal.find('.modal-body #nama_paket').val(nama_paket).change();
        modal.find('.modal-body #jenis').val(jenis).change();
        modal.find('.modal-footer #btn-submit').text('Update');
        modal.find('.modal-body #method').html('{{ method_field('patch') }}');
        modal.find('.modal-body form').attr('action', 'paket/' + id);
    } else {
        modal.find('.modal-title').text('Input data outlet');
        modal.find('.modal-body #id_outlet').val('').change();
        modal.find('.modal-body #harga').val('').change();
        modal.find('.modal-body #nama_paket').val('').change();
        modal.find('.modal-body #jenis').val('').change();
        modal.find('.modal-footer #btn-submit').text('Input');
        modal.find('.modal-body #method').html('');
    }
});


</script>
@endpush
