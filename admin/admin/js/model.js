function send_data(form, type, htmlID) {

    $.ajax({
        url: 'controller/data.php',
        type: 'POST',
        data: form,
        contentType: false,
        processData: false,
        success: (result) => {
            result = result.trim();
            console.log("Result --> ", result);
            if (type == "1" && result != "0") {
                // ADD
                $('#' + htmlID).html(result);
                console.log(result);
                getAllData();

            } else if (type == "2") {
                // SHOW 

                $('#' + htmlID).html(result);
                CKEDITOR.replace('desc');
                CKEDITOR.instances.desc.setData($('#desc').val())

            }
            else if (type == "3") {
                // DEL
                alert(result);
                window.location = "";
            }



        }
    });
}
function getAllData() {
    let form = new FormData();
    form.append('request_Type', "GET")
    send_data(form, 2, "showALL")
}
function find() {
    let location = $('#findLocation').val();
    let city = $('#findCity').val();
    let form = new FormData();
    form.append("request_Type", "FIND");
    if (location) {
        form.append("location", location);
    }
    if (city) {
        form.append("city", city);
    }
    send_data(form, 2, "showALL")
}
function delEvent(id) {
    console.log(id);
    let form = new FormData();
    form.append('request_Type', "DEl")
    form.append('id', id)
    send_data(form, 3, '');
}

function takePostData(e) {
    console.log(e);
    let title = $('#title').val();
    let location = $('#location').val();
    let request_Type = $('#request_Type').val();
    let city = $('#city').val();
    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();
    if (!start_date || !end_date) {
        $('#result').html("Please Select the Dates");
        return;
    }

    let desc = CKEDITOR.instances.desc.getData();

    const d1 = new Date(start_date);
    const d2 = new Date(end_date);


    start_date = d1.getFullYear() + "-" + d1.getMonth() + "-" + d1.getDate();
    end_date = d2.getFullYear() + "-" + d2.getMonth() + "-" + d2.getDate();
    console.log(start_date);

    let form = new FormData();
    form.append('table', "event");
    form.append('name', title);
    form.append('location', location);
    form.append('city', city);
    form.append('description', desc);
    form.append('request_Type', request_Type);
    form.append('start_date', start_date);
    form.append('end_date', end_date);
    // update
    if (request_Type == "UPDATE") {
        let id = $('#id').val();
        form.append('id', id);
    }
    // files
    let fileCompanyLogo = document.getElementById('fileCompanylogo').files[0];
    if (fileCompanyLogo) {
        form.append('myfile[0]', fileCompanyLogo);
        console.log("append");
    }
    send_data(form, 1, "result");
}
function showFrom(id) {
    let form = new FormData();
    form.append('request_Type', "showForm")
    form.append('id', id)
    send_data(form, 2, "showForm")
}
// call the requiered function
getAllData();
showFrom(0);