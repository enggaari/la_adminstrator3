@extends('template/layouts/master')

@section('content')
    <div class="content pt-5">
        {{-- heading content --}}
        <div class="pb-5">
            <div class="row g-5">
                <div class="col-12 col-xxl-6">
                    <div class="mb-2">
                        <h2 class="mb-2">{{ ucfirst(trans($title)) }}</h2>
                        <h5 class="text-700 fw-semi-bold"> User Acces Menu
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
                            <h3>Menu {{ $menuSelected->menu }}</h3>
                            <p class="text-700 lh-sm mb-0">User Acces Submenu for {{ $role }}</p>
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
                                    <th class="sort border-top align-middle" scope="col" data-sort="customer"
                                        style="min-width:200px;">MENU</th>
                                    <th class="sort border-top text-end pe-0 align-middle" scope="col">
                                        SUB MENU</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-latest-review-body">
                                @forelse  ($submenu as $sm)
                                    <tr class="hover-actions-trigger btn-reveal-trigger position-static"
                                        id="index_{{ $sm['id'] }}">
                                        <td class="align-middle product white-space-nowrap py-0">{{ $loop->iteration }}
                                        </td>
                                        <td class="align-middle customer white-space-nowrap" style="min-width:360px;">

                                            <label class="form-check-label"
                                                for="flexCheckDefault">{{ $menuSelected->menu }}</label>
                                            {{-- <h6 class="fw-semi-bold mb-0">{{ $sm['menu'] }}</h6> --}}
                                        </td>

                                        {{-- action --}}
                                        <td class="align-middle white-space-nowrap text-end pe-0">
                                            <div class="form-check">
                                                <input data-id="{{ Crypt::encryptString($sm->submenuId) }}"
                                                    class="form-check-input" id="CheckAction" type="checkbox" value=""
                                                    @if (in_array($sm->submenuId, $accessSubmenus)) checked @endif>
                                                <label class="form-check-label" for="flexCheckDefault">{{ $sm['subMenu'] }}
                                                    - {{ $sm->submenuId }}</label>

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

        {{-- footer --}}
        <script src="{{ asset('assets/sweetalert2/sweetalert2@11.js') }}"></script>
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

        $(document).ready(function() {
            // Ketika checkbox dengan id 'CheckAction' di klik
            $(document).on('change', '.form-check-input', function() {
                var submenuId = $(this).data('id'); // Dapatkan menu ID
                var isChecked = $(this).is(':checked'); // Cek apakah checkbox dicentang
                var roleId = '{{ $role }}';
                var menuId = '{{ $menuId }}';

                // console.log(roleId);
                // console.log(menuId);
                console.log(submenuId);

                $.ajax({
                    url: '{{ url('updateAccessSubmenu') }}', // Route ke controller
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        menuId: menuId,
                        roleId: roleId,
                        submenuId: submenuId,
                        isChecked: isChecked
                    },
                    success: function(response) {
                        if (response.success) {
                            // Jika sukses, tampilkan pesan
                            // alert(response.message);

                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1200
                            });

                        } else {
                            alert('Terjadi kesalahan: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Jika terjadi kesalahan pada request
                        console.error('Error: ' + error);
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
