@extends('layouts.template')

@section('title', $title)

@section('page_title', $page_title)

@section('content_header')
<div class='card'>
    <div class="card-header d-flex">
        <h1 class="card-title">{{$page_title}}</h1>
        <a href="javascript:void(0)" class="btn btn-primary ml-auto" id="btn_modal_create" onclick="show_modal_create('modal_user')">Create</a>
    </div>
</div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="card mr-4" style="width: 18rem;">
                <img class="card-img-top" src="..." alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Add and Edit User -->
<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" onsubmit="stopFormSubmission(event)">
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
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit" onclick="submitForm('modal_user')">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Add and Edit User -->
@endsection

@section('js')
<script type="text/javascript">
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const show_modal_create = (modal_element_id) => {
        let modal_data = {
            modal_id : modal_element_id,
            title : "Add New User",
            btn_submit : "Add User",
        }
        // clear_form(modal_data);
        $(`#${modal_element_id}`).modal('show');
    }

    const submitForm = async()
</script>
@endsection