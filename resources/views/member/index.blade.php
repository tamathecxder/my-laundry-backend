@extends('layouts.main')

    @section('top-side')
        @include('partials.topbar')
        @include('partials.sidebar')
    @endsection

@section('container')
    {{-- WRITE ALL THE CODES DOWN HERE --}}
    <!-- Modal -->
    <div class="modal fade" id="inputDataMember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('member.store') }}" id="formInputOutlet">
                        @csrf
                        <div id="method"></div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Member</label>
                            <input type="text" name="nama" class="form-control" id="nama">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="L">L</option>
                                <option value="P">P</option>
                            </select>
                        </div>
                        <div class="mb-3">
                          <label for="alamat" class="form-label">Alamat Lengkap</label>
                          <input type="text" name="alamat" class="form-control" id="alamat">
                        </div>
                        <div class="mb-3">
                          <label for="tlp" class="form-label">No Telepon</label>
                          <input type="number"  name="tlp" class="form-control" id="tlp">
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
        <div class="card card-hover" data-bs-toggle="modal" data-bs-target="#inputDataMember">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-relative-scale"></i></h1>
                <h6 class="text-white">Input Data Member</h6>
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
        <table class="table table-dark table-striped" id="tbl-member">
            <thead class="table-info">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama Member</th>
                  <th scope="col">Jenis Kelamin (L/P)</th>
                  <th scope="col">Alamat Lengkap</th>
                  <th scope="col">No Telp</th>
                  <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $mbr)
                    <tr>
                        <td>{{ $index = (isset($index)) ? ++$index : $index = 1 }}</td>
                        <td>{{ $mbr->nama }}</td>
                        <td>{{ $mbr->jenis_kelamin }}</td>
                        <td>{{ $mbr->alamat }}</td>
                        <td>{{ $mbr->tlp }}</td>
                        <td>
                            <div class="d-inline-flex">
                                <div class="col">
                                    <button class="btn btn-primary me-2 edit-barang" data-bs-toggle="modal" data-bs-target="#inputDataMember"
                                      data-mode="edit"
                                      data-id="{{ $mbr->id }}"
                                      data-nama="{{ $mbr->nama }}"
                                      data-jenis_kelamin="{{ $mbr->jenis_kelamin }}"
                                      data-alamat="{{ $mbr->alamat }}"
                                      data-tlp="{{ $mbr->tlp }}"
                                    > Edit
                                </div>
                              </button>
                              <form action="{{ route('member.destroy', $mbr->id) }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger delete-member">Hapus</button> &nbsp;
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
    $('#tbl-member').DataTable()
  });

  // menghapus alert
  $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
    $("#success-alert").slideUp(500);
  });

  $("#error-alert").fadeTo(2000, 500).slideUp(500, function() {
    $("#success-alert").slideUp(500);
  });

// delete data outlet dengan sweetalert
$('.delete-member').click(function(e) {
    e.preventDefault()
    let data1 = $(this).closest('tr').find('td:eq(1)').text()
    let data2 = $(this).closest('tr').find('td:eq(4)').text()
    swal({
      title: "Apakah kamu yakin ingin menghapusnya?",
      text: "Member dengan nama "+data1+" dengan nomor telepon " + data2 + " yakin akan dihapus?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((req) => {
      if(req) $(e.target).closest('form').submit()
      else swal.close()
    })
  });

$('#inputDataMember').on('show.bs.modal', function (e) {
    let button = $(e.relatedTarget);
    // console.log(button);
    let id = button.data('id');
    let nama = button.data('nama');
    let alamat = button.data('alamat');
    let jenis_kelamin = button.data('jenis_kelamin');
    let tlp = button.data('tlp');
    let mode = button.data('mode');
    let modal = $(this);

    if ( mode == 'edit' ) {
        modal.find('.modal-title').text('Edit data Member');
        modal.find('.modal-body #nama').val(nama).change();
        modal.find('.modal-body #jenis_kelamin').val(jenis_kelamin).change();
        modal.find('.modal-body #alamat').val(alamat).change();
        modal.find('.modal-body #tlp').val(tlp).change();
        modal.find('.modal-footer #btn-submit').text('Update');
        modal.find('.modal-body #method').html('{{ method_field('patch') }}');
        modal.find('.modal-body form').attr('action', 'member/' + id);
    } else {
        modal.find('.modal-title').text('Input data member');
        modal.find('.modal-body #nama').val('').change();
        modal.find('.modal-body #jenis_kelamin').val('').change();
        modal.find('.modal-body #alamat').val('').change();
        modal.find('.modal-body #tlp').val('').change();
        modal.find('.modal-footer #btn-submit').text('Input');
        modal.find('.modal-body #method').html('');
    }
});


</script>
@endpush
