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
            <a href="javascript:void(0)" class="btn btn-primary ml-auto" id="btn_modal_create"
                onclick="show_modal_create('modal_user')">Create</a>
        </div>
        <div class="card-body">
            <div class="row  mb-3">
                <div class="col-sm-12 d-inline-flex justify-content-end">
                    <div class="filter_wrapper mr-2" style="width:200px;">
                        <select name="data_status" id="data_status" class="form-control select2 no-search-box">
                            <option value="">All Data</option>
                            <option value="1" selected> Active Only </option>
                            <option value="2"> Deleted Only </option>
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

        const show_modal_create = (modal_element_id) => {
            let modal_data = {
                modal_id: modal_element_id,
                title: "Add New Product",
                btn_submit: "Add Product",
                form_action_url : store_url,
            }
            clear_form(modal_data);
            $(`#${modal_element_id}`).modal('show');
            console.log("{{route ('product.create')}}")
        }

        const show_modal_edit = async (modal_element_id, user_id) => {
            let modal_data = {
                modal_id: modal_element_id,
                title: "Edit User",
                btn_submit: "Save",
                form_action_url: update_url.replace(':id', user_id),
            }
            clear_form(modal_data);
        }
        const submitForm = async (modal_id) => {
            try {
                console.log(modal_id)
                let modal = document.getElementById(modal_id)
                let form = modal.querySelector('form');
                let formData = getFormData(form);
                console.log(formData)
                // return false
                const response = await fetch(store_url, {
                    method: "POST",
                    mode: "cors",
                    cache: "no-cache",
                    credentials: "same-origin",
                    redirect: "follow",
                    referrerPolicy: "no-referrer",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Content-Type": 'application/json',
                    },
                    body: JSON.stringify(formData)
                });
                console.log(response)
                if(response.status === 200){
                    // "{{ route('product.dtable') }}".()
                    Swal.fire({
                        title: response.status,
                        text : "Berhasil Membuat Product",
                        icon : "success"
                    })
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "something went wrong",
                        showConfirmButton: true,
                    })
                }
            $(`#${modal_id}`).modal('hide');

            } catch (error) {
                console.log(error)
            }
        }
    </script>

    <script type="text/javascript">
        $(function() {
            let tableurl = "{{ route('product.dtable') }}"
            var table = $('#tbl_list').DataTable({
                paging: true,
                responsive: true,
                lengthChange: true,
                searching: true,
                autoWidth: false,
                orderCellsTop: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: tableurl,

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
                ]
            });

        });
    </script>
@endsection
