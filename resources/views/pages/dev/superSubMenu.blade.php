@extends('template/layouts/master')

@section('content')
    <div class="content pt-5">
        {{-- heading content --}}
        <div class="pb-5">
            <div class="row g-5">
                <div class="col-12 col-xxl-6">
                    <div class="mb-2">
                        <h2 class="mb-2">{{ ucfirst(trans($title)) }}</h2>
                        <h5 class="text-700 fw-semi-bold">{{ ucfirst(trans(Auth::user()->role)) }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        {{-- heading content --}}


        {{-- content --}}
        <div class="mx-n6 bg-white px-6 pt-7 border-y border-300">
            <div class="row">
                <div data-list='{"valueNames":["product","customer","rating","review","time"],"page":6}'>
                    <div class="row align-items-end justify-content-between pb-5 g-3">
                        <div class="col-auto">
                            <h3>Setting </h3>
                            <p class="text-700 lh-sm mb-0">Super Sub Menu</p>
                        </div>
                        <div class="col-12 col-md-auto">
                            <div class="row g-2">
                                <div class="col-auto flex-1">
                                    <div class="search-box">
                                        <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                            <input class="form-control form-control-sm search-input search" type="search"
                                                placeholder="Search" aria-label="Search">
                                            <span class="fas fa-search search-box-icon"></span>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-outline-primary me-1 mb-1" data-bs-toggle="modal"
                                        data-bs-target="#addData" type="button">Tambah
                                        {{ ucfirst(trans($title)) }}
                                    </button>
                                    {{-- <button class="btn btn-sm btn-phoenix-secondary ms-2 bg-white hover-bg-100"
                                        type="button"><span class="fas fa-ellipsis-h fs--2"></span>
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mx-n1 px-1 scrollbar">
                        <table class="table fs--2 mb-0 overflow-hidden">
                            <thead>
                                <tr>
                                    <th class="sort border-top white-space-nowrap align-middle" scope="col"
                                        data-sort="no">NO</th>
                                    <th class="sort border-top white-space-nowrap align-middle" scope="col"
                                        style="min-width:200px;" data-sort="product">
                                        SUPER SUB MENU
                                    </th>
                                    <th class="sort border-top white-space-nowrap align-middle" scope="col"
                                        style="min-width:200px;" data-sort="product">
                                        SUB MENU
                                    </th>
                                    <th class="sort border-top white-space-nowrap align-middle" scope="col"
                                        style="min-width:200px;" data-sort="product">
                                        MENU
                                    </th>
                                    <th class="sort border-top white-space-nowrap align-middle" scope="col"
                                        style="min-width:200px;" data-sort="product">
                                        URL
                                    </th>
                                    <th class="sort border-top white-space-nowrap align-middle" scope="col"
                                        style="min-width:100px;" data-sort="product">
                                        STATUS
                                    </th>
                                    <th class="sort border-top align-middle" scope="col" data-sort="customer"
                                        style="min-width:200px;">
                                        INFORMASI
                                    </th>
                                    <th class="sort border-top align-middle" scope="col" data-sort="customer"
                                        style="min-width:200px;">
                                        ALIAS
                                    </th>
                                    <th class="sort border-top text-end pe-0 align-middle" scope="col">
                                        ACTION
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-latest-review-body">
                                @forelse  ($superSubMenu as $dt)
                                    <tr class="hover-actions-trigger btn-reveal-trigger position-static"
                                        id="index_{{ $dt->id }}">
                                        <td class="align-middle product white-space-nowrap py-0">{{ $loop->iteration }}</td>
                                        <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                                            <h6 class="fw-semi-bold mb-0">{{ $dt->super_sub_menus }}</h6>
                                        </td>
                                        <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                                            <h6 class="fw-semi-bold mb-0">{{ $dt->menu_name }}</h6>
                                            <!-- Nama menu dari hasil join -->
                                        </td>
                                        <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                                            <h6 class="fw-semi-bold mb-0">{{ $dt->sub_menu_name }}</h6>
                                        </td>
                                        <td class="align-middle product white-space-nowrap" style="min-width:100px;">
                                            <h6 class="fw-semi-bold mb-0">{{ $dt->url }}</h6>
                                        </td>
                                        <td class="align-middle product white-space-nowrap" style="min-width:100px;">
                                            <h6 class="fw-semi-bold mb-0">{{ $dt->status ? 'Aktif' : 'Tidak Aktif' }}</h6>
                                            <!-- Status diubah menjadi 'Aktif' atau 'Tidak Aktif' -->
                                        </td>
                                        <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                                            <h6 class="mb-0 text-900">{{ $dt->info }}</h6>
                                        </td>
                                        <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0 text-900">{{ $dt->alias }}</h6>
                                            </div>
                                        </td>

                                        {{-- action --}}
                                        <td class="align-middle white-space-nowrap text-end pe-0">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                <button data-id="{{ Crypt::encryptString($dt->id) }}"
                                                    class="btn btn-sm btn-phoenix-primary me-1 fs--2 edit-data-btn">
                                                    <span class="fas fa-edit"></span>
                                                </button>
                                                <form id="delete-data-form-{{ $dt->id }}"
                                                    action="/deleteSuperSubMenu/{{ Crypt::encryptString($dt->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2"
                                                        onclick="confirmDelete({{ $dt->id }})">
                                                        <span class="fas fa-trash"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        {{-- action --}}
                                    </tr>
                                @empty
                                    <div class="alert alert-soft-info">
                                        Data {{ ucfirst(trans($title)) }} belum tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="row align-items-center py-2">
                        <div class="pagination d-none"></div>
                        <div class="col d-flex fs--1">
                            <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info></p><a
                                class="fw-semi-bold" href="#!" data-list-view="*">View all<span
                                    class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a
                                class="fw-semi-bold d-none" href="#!" data-list-view="less">View
                                Less</a>
                        </div>
                        <div class="col-auto d-flex"><button class="btn btn-link px-1 me-1" type="button"
                                title="Previous" data-list-pagination="prev"><span
                                    class="fas fa-chevron-left me-2"></span>Previous</button><button
                                class="btn btn-link px-1 ms-1" type="button" title="Next"
                                data-list-pagination="next">Next<span class="fas fa-chevron-right ms-2"></span></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- content --}}

        {{-- models --}}
        <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="addDataLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataLabel">Add {{ ucfirst(trans($title)) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ url('/storeSuperSubMenu') }}">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Menu:</label>
                                <select class="form-control form-control-sm selectchosen" name="idMenu" id="idMenu"
                                    data-placeholder="Select Your Options Menu">
                                    <option value=""></option> <!-- Tambahkan opsi kosong di sini -->
                                    <option value="{{ old('idMenu') }}" selected>{{ old('idMenu') }}</option>
                                    <!-- Tambahkan opsi kosong di sini -->
                                    @foreach ($menus as $m)
                                        <option value="{{ $m['id'] }}">{{ $m['menu'] }}</option>
                                    @endforeach
                                </select>
                                @error('idMenu')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Sub Menu:</label>
                                <select class="form-control form-control-sm selectchosen" name="idSubMenu" id="idSubMenu"
                                    data-placeholder="Select Your Options Sub Menu">
                                    <option value=""></option> <!-- Tambahkan opsi kosong di sini -->
                                    <option value="{{ old('idSubMenu') }}" selected>{{ old('idSubMenu') }}</option>
                                    <!-- Tambahkan opsi kosong di sini -->
                                    @foreach ($subMenu as $sm)
                                        <option value="{{ $sm['id'] }}">{{ $sm['subMenu'] }}</option>
                                    @endforeach
                                </select>
                                @error('idSubMenu')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">{{ ucfirst(trans($title)) }}:</label>
                                <input type="text"
                                    class="form-control form-control-sm @error('superSubMenu') is-invalid @enderror"
                                    name="superSubMenu" id="superSubMenu" value="{{ old('superSubMenu') }}">
                                @error('superSubMenu')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Url:</label>
                                        <input type="text"
                                            class="form-control form-control-sm @error('url') is-invalid @enderror"
                                            name="url" id="url" value="{{ old('url') }}">
                                        @error('url')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Informasi:</label>
                                        <textarea class="form-control form-control-sm @error('info') is-invalid @enderror" name="info" id="message-text"
                                            rows="1">-{{ old('info') }}</textarea>
                                        @error('info')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Alias:</label>
                                        <input type="text"
                                            class="form-control form-control-sm @error('alias') is-invalid @enderror"
                                            name="alias" id="alias" value="-{{ old('alias') }}">
                                        @error('alias')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Status:</label>
                                        <div class="form-check">
                                            <input class="form-check-input @error('status') is-invalid @enderror"
                                                id="flexCheckChecked" type="checkbox" name="status" id="status"
                                                value="{{ old('status') }}" checked>
                                            <label class="form-check-label" for="flexCheckChecked">Aktif</label>
                                        </div>
                                        @error('status')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- models --}}

        {{-- models edit --}}
        <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDataModalLabel">Edit {{ ucfirst(trans($title)) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit-data-form">
                        <div class="modal-body">
                            @csrf
                            @method('PUT') <!-- Method spoofing -->
                            <input type="hidden" id="data-id">
                            <div class="mb-3">
                                <label for="idMenuEdit" class="col-form-label">Menu:</label>
                                <select class="form-control form-control-sm selectchosen" name="idMenuEdit"
                                    id="idMenuEdit" data-placeholder="Select Your Options">
                                    <option value=""></option> <!-- Opsi kosong untuk memulai -->
                                    @foreach ($menus as $m)
                                        <option value="{{ $m['id'] }}">{{ $m['menu'] }}</option>
                                    @endforeach
                                </select>
                                @error('idMenuEdit')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Sub Menu:</label>
                                <select class="form-control form-control-sm selectchosen" name="idSubMenuEdit"
                                    id="idSubMenuEdit" data-placeholder="Select Your Options Sub Menu">
                                    <option value=""></option> <!-- Tambahkan opsi kosong di sini -->
                                    <option value="{{ old('idSubMenuEdit') }}" selected>{{ old('idSubMenuEdit') }}
                                    </option>
                                    <!-- Tambahkan opsi kosong di sini -->
                                    @foreach ($subMenu as $sm)
                                        <option value="{{ $sm['id'] }}">{{ $sm['subMenu'] }}</option>
                                    @endforeach
                                </select>
                                @error('idSubMenuEdit')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">{{ ucfirst(trans($title)) }}:</label>
                                <input type="text"
                                    class="form-control form-control-sm @error('superSubMenuEdit') is-invalid @enderror"
                                    name="superSubMenuEdit" id="superSubMenuEdit" value="{{ old('superSubMenuEdit') }}">
                                @error('superSubMenuEdit')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Url:</label>
                                        <input type="text"
                                            class="form-control form-control-sm @error('urlEdit') is-invalid @enderror"
                                            name="urlEdit" id="urlEdit" value="{{ old('urlEdit') }}">
                                        @error('urlEdit')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Informasi:</label>
                                        <textarea class="form-control form-control-sm @error('infoEdit') is-invalid @enderror" name="infoEdit" id="infoEdit"
                                            rows="1">{{ old('infoEdit') }}</textarea>
                                        @error('infoEdit')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Alias:</label>
                                        <input type="text"
                                            class="form-control form-control-sm @error('aliasEdit') is-invalid @enderror"
                                            name="aliasEdit" id="aliasEdit" value="{{ old('aliasEdit') }}">
                                        @error('aliasEdit')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="statusEdit" class="col-form-label">Status:</label>
                                        <div class="form-check">
                                            <input class="form-check-input @error('statusEdit') is-invalid @enderror"
                                                id="statusEdit" type="checkbox" name="statusEdit" value="1">
                                            <label class="form-check-label" for="statusEdit">Aktif</label>
                                        </div>
                                        @error('statusEdit')
                                            <div class="text text-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- models edit --}}

        {{-- footer --}}
        <script src="assets/sweetalert2/sweetalert2@11.js"></script>
        @include('template.layouts.footer')
        {{-- footer --}}

        <!-- Cek Error show modal -->
        @if ($errors->any())
            <!-- Script untuk menampilkan modal jika ada error -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('addData'));
                    myModal.show();
                });
            </script>

            <!-- Pastikan Bootstrap JS dan Popper.js dimuat -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
            <!-- Cek Error show modal -->
        @endif

    </div>
@endsection

@push('scripts')
    <script>
        //message with toastr
        @if (session()->has('success'))
            Swal.fire({
                position: "center",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1200
            });
        @elseif (session()->has('error'))

            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        // delete role
        function confirmDelete(roleId) {
            Swal.fire({
                title: 'Yakin hapus data?',
                text: "Data yang dihapus akan hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form delete sesuai role ID
                    document.getElementById('delete-data-form-' + roleId).submit();
                }
            });
        }

        // function data
        $(document).on('click', '.edit-data-btn', function() {
            var roleId = $(this).data('id');
            // Request ke server untuk mengambil data role berdasarkan ID
            $.ajax({
                url: '/SuperSubMenu/edit/' + roleId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#data-id').val(response.data.id);
                        $('#subMenuEdit').val(response.data.subMenu);
                        $('#urlEdit').val(response.data.url);
                        $('#iconEdit').val(response.data.icon);
                        $('#superSubMenuEdit').val(response.data.super_sub_menus);

                        // Mengatur checkbox status sesuai dengan nilai dari database
                        if (response.data.status == 1) {
                            $('#statusEdit').prop('checked', true); // Checkbox tercentang
                        } else {
                            $('#statusEdit').prop('checked', false); // Checkbox tidak tercentang
                        }

                        // Set dropdown 'idMenuEdit' sesuai dengan idMenu dari response
                        $('#idMenuEdit').val(response.data.idMenu).trigger("chosen:updated");
                        $('#idSubMenuEdit').val(response.data.idSubMenu).trigger("chosen:updated");


                        $('#infoEdit').val(response.data.info);
                        $('#aliasEdit').val(response.data.alias);
                        $('#editDataModal').modal('show');
                    }
                }
            });
        });

        $('#edit-data-form').submit(function(e) {
            e.preventDefault();
            var editId = $('#data-id').val();
            var idMenuEdit = $('#idMenuEdit').val();
            var idSubMenuEdit = $('#idSubMenuEdit').val();
            var superSubMenuEdit = $('#superSubMenuEdit').val();
            var urlEdit = $('#urlEdit').val();
            var infoEdit = $('#infoEdit').val();
            var aliasEdit = $('#aliasEdit').val();

            // Mendapatkan nilai checkbox
            var statusEdit = $('#statusEdit').is(':checked') ? 1 : 0;

            $.ajax({
                url: '/SuperSubMenu/update/' + editId, // URL dengan ID role
                type: 'PUT', // Menggunakan metode PUT
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF wajib di Laravel
                    idMenuEdit: idMenuEdit,
                    idSubMenuEdit: idSubMenuEdit,
                    superSubMenuEdit: superSubMenuEdit,
                    urlEdit: urlEdit,
                    infoEdit: infoEdit,
                    aliasEdit: aliasEdit,
                    statusEdit: statusEdit
                },
                success: function(response) {
                    if (response.success) {
                        // Update baris yang sesuai berdasarkan roleId
                        // Gunakan HTML row yang dikirimkan dari server
                        var updatedRow = response.updatedRow;

                        // Update baris yang sesuai di table
                        $('#index_' + response.editId).html(updatedRow);

                        $('#editDataModal').modal('hide'); // Tutup modal

                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1200
                        });

                        // Optionally, refresh the page or update the row dynamically
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Log error jika request gagal
                }
            });
        });
    </script>
@endpush
