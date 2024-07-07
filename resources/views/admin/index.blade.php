@extends('layouts.template')

@section('title', $title)
@section('page_title', $page_title)

{{-- @section('content_header')
<div class='card'>
    <div class="card-header d-flex">
        <h1 class="card-title">{{$page_title}}</h1>
        <a href="javascript:void(0)" class="btn btn-primary ml-auto" id="btn_modal_create" onclick="show_modal_create('modal_user')">Create</a>
    </div>
</div>
@stop --}}

@section('content')
    <!-- /.card-header -->
    <div class="card">
        <div class="card-header d-flex">
            <h1 class="card-title align-self-center">{{ $page_title }}</h1>
            @can("can:product-create")
            <a href="javascript:void(0)" class="btn btn-primary ml-auto" id="btn_modal_create"
                onclick="show_modal_create('modal_user')">Create</a>
            @endcan
            </div>
        <div class="card-body">
            <div class="row  mb-3">
                <div class="col-sm-12 d-inline-flex justify-content-end">
                    <div class="filter_wrapper mr-2" style="width:200px;">
                        <select name="data_range" id="data_range" class="form-control no-search-box">
                            <option value=0 selected>All Data</option>
                            <option value="0 - 100">0 - 100</option>
                            <option value="100 - 500">100 - 500</option>
                            <option value="500 - 0">500 - All</option>
                        </select>
                    </div>
                    <div class="filter_wrapper text-right align-self-center">
                        <button id="reload_table_btn" class="btn btn-sm btn-info">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <table id="tbl_list" class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="25">No</th>
                        <th width="" class="text-center">Name</th>
                        <th width="" class="text-center">Price</th>
                        <th width="" class="text-center">Quantity</th>
                        <th width="" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add and Edit Product -->
    <div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" onsubmit="stopFormSubmission(event)">
                    <input type="hidden" name="edit_user_id" value="" id="edit_user_id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="qty" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button onclick="submitForm('modal_user')" class="btn btn-primary btn-submit">Add
                            User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Add and Edit Product -->
@endsection

@section('js')
    <script type="text/javascript">
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const store_url = "{{ route('product.create') }}";
        const edit_url = "{{ route('product.edit', 'id') }}";
        const update_url = "{{ route('product.update', 'id') }}";
        const destroy_url = "{{ route('product.destroy', 'id') }}";

        const show_modal_create = (modal_element_id) => {
            let modal_data = {
                modal_id: modal_element_id,
                title: "Add New Product",
                btn_submit: "Add Product",
                form_action_url: store_url,
            }
            clear_form(modal_data);
            $(`#${modal_element_id}`).modal('show');
        }

        const show_modal_edit = async (modal_element_id, product_id) => {
            let modal_data = {
                modal_id: modal_element_id,
                title: "Edit Product",
                btn_submit: "Save",
                form_action_url: update_url.replace('id', product_id),
            }
            clear_form(modal_data);

            const response = await fetch(edit_url.replace('id', product_id), {
                method: "GET",
                mode: "cors",
                cache: "no-cache",
                credentials: "same-origin",
                redirect: "follow",
                referrerPolicy: "no-referrer",
                headers: {
                    "Content-Type": 'application/json',
                },
            });

            if (response.ok) {
                const editData = await response.json();
                $(`#name`).val(editData.data.name);
                $(`#price`).val(editData.data.price);
                $(`#qty`).val(editData.data.qty);
                $(`#edit_user_id`).val(editData.data.id);

            }

            $(`#${modal_element_id}`).modal('show');

        }
        const submitForm = async (modal_id) => {
            try {
                let modal = document.getElementById(modal_id)
                let form = modal.querySelector('form');
                let formData = getFormData(form);
                let edit_modal = form.querySelector('#edit_user_id').value;
                const response = await fetch(edit_modal ? update_url.replace('id', edit_modal) : store_url, {
                    method: edit_modal ? "PUT" : "POST",
                    mode: "cors",
                    cache: "no-cache",
                    credentials: "same-origin",
                    redirect: "follow",
                    referrerPolicy: "no-referrer",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json",
                        "Content-Type": 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                const responseData = await response.json();
                console.log(responseData)
                if (response.ok) { // HTTP status in the range 200-299
                    Swal.fire({
                        type: responseData.status, // Use the icon from response or default to "success"
                        title: responseData.status,
                        text: responseData.message,
                    });
                    $('#tbl_list').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        type: 'error',
                        title: responseData.status || 'Error',
                        text: responseData.message || 'An unexpected error occurred',
                        showConfirmButton: true,
                    });
                }
                $(`#${modal_id}`).modal('hide');

            } catch (error) {
                console.log(error)
            }
        }

        const show_modal_delete = async (id) => {
            const result = await Swal.fire({
                title: "Apakah anda yakin ingin menghapus product?",
                type: "warning",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal"
            });

            if (result.value) {
                try {
                    const response = await fetch(destroy_url.replace('id', id), {
                        method: "DELETE",
                        mode: "cors",
                        cache: "no-cache",
                        credentials: "same-origin",
                        redirect: "follow",
                        referrerPolicy: "no-referrer",
                        headers: {
                            "X-CSRF-TOKEN": token,
                            "Content-Type": 'application/json',
                            "Accept": "application/json",          
                        },
                    })
                    
                    if (response.ok) {
                        Swal.fire({
                            title: "Produk berhasil dihapus",
                            icon: "success",
                        });
                        $('#tbl_list').DataTable().ajax.reload(null, false);
                    }
                } catch (error) {
                    console.error('Error deleting product:', error);
                    // Handle network errors or other exceptions
                    Swal.fire({
                        title: "Terjadi kesalahan",
                        text: "Gagal menghapus produk. Silakan coba lagi nanti.",
                        icon: "error",
                    });
                }
            }

        }

        $("#reload_table_btn").click(function() {
            $('#tbl_list').DataTable().ajax.reload(null, false);
        }) //tombol untuk reload table
    </script>

    <script type="text/javascript">
        $(function() {
            let tableurl = "{{ route('product.dtable') }}"
            var table = $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: tableurl,
                    data: function(d) {
                        d.data_range = $('#data_range').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: 'false',
                        searchable: 'false',
                        visible: @can('product-edit') true @else false @endcan
                    }
                ],
                paging: true,
                responsive: true,
                lengthChange: true,
                searching: true,
                autoWidth: false,
                orderCellsTop: true,
                searchDelay: 500,
            });
            $('#data_range').change(function(event) {
                $('#tbl_list').DataTable().ajax.reload(null, false);
            });
        });
    </script>
@endsection
