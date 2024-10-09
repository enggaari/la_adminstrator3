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
                            <p class="text-700 lh-sm mb-0">Menu</p>
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
                                        data-sort="product">NO</th>
                                    <th class="sort border-top white-space-nowrap align-middle" scope="col"
                                        style="min-width:360px;" data-sort="product">
                                        MENU</th>
                                    <th class="sort border-top align-middle" scope="col" data-sort="customer"
                                        style="min-width:200px;">INFORMASI</th>
                                    <th class="sort border-top align-middle" scope="col" data-sort="customer"
                                        style="min-width:200px;">ALIAS</th>
                                    <th class="sort border-top text-end pe-0 align-middle" scope="col">
                                        ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-latest-review-body">
                                @forelse  ($menu as $m)
                                    <tr class="hover-actions-trigger btn-reveal-trigger position-static"
                                        id="index_{{ $m['id'] }}">
                                        <td class="align-middle product white-space-nowrap py-0">{{ $loop->iteration }}
                                        </td>
                                        <td class="align-middle product white-space-nowrap" style="min-width:360px;">
                                            <h6 class="fw-semi-bold mb-0">{{ $m['menu'] }}</h6>
                                        </td>
                                        <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                                            <div class="d-flex align-items-center">
                                                {{-- <div class="avatar avatar-l">
                                                    <div class="avatar-name rounded-circle"><span>R</span></div>
                                                </div> --}}
                                                <h6 class="mb-0 text-900">{{ $m['info'] }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                                            <div class="d-flex align-items-center">
                                                <h6 class="mb-0 text-900">{{ $m['alias'] }}</h6>
                                            </div>
                                        </td>

                                        {{-- action --}}
                                        <td class="align-middle white-space-nowrap text-end pe-0">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                <button data-id="{{ Crypt::encryptString($m->id) }}"
                                                    class="btn btn-sm btn-phoenix-primary me-1 fs--2 edit-data-btn">
                                                    <span class="fas fa-edit"></span>
                                                </button>
                                                <form id="delete-data-form-{{ $m['id'] }}"
                                                    action="/deleteMenu/{{ Crypt::encryptString($m['id']) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2"
                                                        onclick="confirmDelete({{ $m['id'] }})">
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
                        <div class="col-auto d-flex"><button class="btn btn-link px-1 me-1" type="button" title="Previous"
                                data-list-pagination="prev"><span
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataLabel">Add {{ ucfirst(trans($title)) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ url('/storeMenu') }}">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">{{ ucfirst(trans($title)) }}:</label>
                                <input type="text" class="form-control @error('menu') is-invalid @enderror"
                                    name="menu" id="menu" value="{{ old('menu') }}">
                                @error('menu')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Informasi:</label>
                                <textarea class="form-control @error('info') is-invalid @enderror" name="info" id="message-text">{{ old('info') }}</textarea>
                                @error('info')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Alias:</label>
                                <input type="text" class="form-control @error('alias') is-invalid @enderror"
                                    name="alias" id="alias" value="{{ old('alias') }}">
                                @error('alias')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
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
            <div class="modal-dialog">
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
                                <label for="recipient-name" class="col-form-label">{{ ucfirst(trans($title)) }}:</label>
                                <input type="text" class="form-control @error('menuEdit') is-invalid @enderror"
                                    name="menuEdit" id="menuEdit" value="{{ old('menuEdit') }}">
                                @error('menuEdit')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Informasi:</label>
                                <textarea class="form-control @error('infoEdit') is-invalid @enderror" name="infoEdit" id="infoEdit">{{ old('infoEdit') }}</textarea>
                                @error('infoEdit')
                                    <div class="text text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Alias:</label>
                                    <textarea class="form-control @error('aliasEdit') is-invalid @enderror" name="aliasEdit" id="aliasEdit">{{ old('aliasEdit') }}</textarea>
                                    @error('aliasEdit')
                                        <div class="text text-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                url: '/menu/edit/' + roleId,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#data-id').val(response.data.id);
                        $('#menuEdit').val(response.data.menu);
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
            var menuEdit = $('#menuEdit').val();
            var infoEdit = $('#infoEdit').val();
            var aliasEdit = $('#aliasEdit').val();

            $.ajax({
                url: '/menu/update/' + editId, // URL dengan ID role
                type: 'PUT', // Menggunakan metode PUT
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF wajib di Laravel
                    menuEdit: menuEdit,
                    infoEdit: infoEdit,
                    aliasEdit: aliasEdit,
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
