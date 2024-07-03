const clear_form = (data) => {
    /*
        * --------------------------------------------------------------------
        * Params Example
        * --------------------------------------------------------------------
        data = {
            modal_id : 'packinglist_modal',
            title: "Add Product",
            btn_submit: "Add Product",
            form_action_url: "",
        };
        * --------------------------------------------------------------------
    */

    $(`#${data.modal_id} .modal-title`).text(data.title);
    $(`#${data.modal_id} .btn-submit`).text(data.btn_submit);
    $(`#${data.modal_id} form`).attr(`action`, data.form_action_url);
    // $(`#${data.modal_id} form`).find("input[type=text], input[type=number], input[type=email], input[type=hidden], input[type=password], textarea").val("");
    $(`#${data.modal_id} form`).find(`select`).val("").trigger(`change`);
    $(`#${data.modal_id} form`).find('input,select').removeClass("is-invalid");
    $(`#${data.modal_id} form`).find('span.invalid-feedback').css('display', 'none');
}

const stopFormSubmission = (event) => {
    event.preventDefault();
}

const getFormData = (form) =>{
    const formData = new FormData(form)
    const formDataObject = {};

    formData.forEach((value, key) => {
        formDataObject[key] = value;
    });


    return formDataObject
}


window.getFormData = getFormData;
window.clear_form = clear_form;
window.stopFormSubmission = stopFormSubmission;
