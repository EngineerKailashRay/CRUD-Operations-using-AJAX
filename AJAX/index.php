
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CRUD operations</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
        <script type="text/javascript" src="DataTables/datatables.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            #star{
                color:red;   
            }
            .no-js #loader { display: none;  }
            .js #loader { display: block; position: absolute; left: 100px; top: 0; }
            .se-pre-con {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url(ajax-loader.gif) center no-repeat;
                background-color: #ddd;
                opacity: .7;
            }
        </style>

    </head>
    <body>
        <div class="se-pre-con" id="loaderr" style="display: none;"></div>
        <div id="navigation">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
                <a class="navbar-brand" href="#">CRUD operations</a>
            </nav>
        </div>
        <div id="sectiondata" style="margin:30px">
            <div class="row">

                <div class="col-sm-2 col-2">
                    <label>Name<span id="star">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                </div>
                <div class="col-sm-2 col-2">
                    <label>Email<span id="star">*</span></label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-sm-2 col-2">
                    <label>Mobile<span id="star">*</span></label>
                    <input type="text" name="mobile" id="mobile" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Mobile(Only numbers)">
                </div>
                <div class="col-sm-4 col-4">
                    <label>Message<span id="star">*</span></label>
                    <textarea type="textbox" name="message" id="message" class="form-control" placeholder="Message" style="resize: vertical; height: 40px"  ></textarea>
                </div>
                <div class="col-sm-2 col-2">
                    <label></label>
                    <button type="button" onclick="save_data();" id="save_data" class="btn btn-primary" style="margin-top: 30px;">Save</button>
                </div>
            </div>
            <br>
            <br>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-12">
                    <table id="mytable" class="table table-borderd">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                edit_id = 0;
                current_data = [];
                $('#mytable').DataTable();
                getData();
            });

            function save_data() {
                var name = $('#name').val().trim();
                if (name == "") {
                    alert("Please enter name");
                    $('#name').focus();
                    return;
                }
                var email = $('#email').val().trim();
                if (email == "") {
                    alert("Please enter email!");
                    $('#name').focus();
                    return;
                } else {
//                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                    if (!regex.test(email)) {
                        alert("Please enter a valid email!");
                        $('#email').focus();
                        return;
                    }
                }
                var mobile = $('#mobile').val().trim();
                if (mobile == "") {
                    alert("Please enter mobile number!");
                    $('#mobile').focus();
                    return;
                } else if (mobile.length != 10) {
                    alert("Please enter a valid mobile number!");
                    $('#mobile').focus();
                    return;
                }
                var message = $('#message').val().trim();
                if (message == "") {
                    alert("Please enter something!");
                    $('#message').focus();
                    return;
                }
                var postdata = {"name": name, "email": email, "mobile": mobile, "message": message};
                var datastring = JSON.stringify(postdata);
                $('#loaderr').css("display", "block");
                $.ajax({
                    type: 'post',
                    url: 'Link_Library/link_ajax_data.php',
                    data: {"insert_data": datastring},
                    success: function (response) {
                        $('#loaderr').css("display", "none");
                        console.log("Success", response);
                        var res = JSON.parse(response);
                        if (res.success == 1) {
                            $('#name').val("");
                            $('#email').val("");
                            $('#mobile').val("");
                            $('#message').val("");
                            getData();
                        }
                    },
                    error: function (response) {
                        console.log("Error", response);
                        alert("Someting Went Wrong Contact Admin!");
                        return;
                    }

                });
            }
            function getData() {
                $('#loaderr').css('display', "block");
                $.ajax({
                    type: 'post',
                    url: 'Link_Library/link_ajax_data.php',
                    data: {"getRecords": ""},
                    success: function (response) {
                        var res = JSON.parse(response);
                        if (res.success == 1) {
                            for (var i = 0; i < res.data.length; i++) {
                                current_data = res.data;
                                res.data[i].serial_id = (i + 1);
                                res.data[i].action = '<i class="glyphicon glyphicon-edit" onclick="editData(\'' + i + '\')"></i>&nbsp;&nbsp;<i class="glyphicon glyphicon-remove" onclick="deletedata(\'' + res.data[i].auto_id + '\')"></i>';
                            }
                            create_table(res.data);
                        } else {
                            res.data = [];
                            create_table();
                        }
                    },
                    error: function (response) {
                        console.log("Error", response);
                        alert("Someting Went Wrong Contact Admin!");
                        return;
                    }

                });
            }
            function create_table(array) {
                $('#loaderr').css('display', "none");
                $('#mytable').DataTable().clear().destroy();
                $('#mytable').DataTable({
                    data: array,
                    columns: [{
                            data: "serial_id"
                        },
                        {
                            data: "name"
                        },
                        {
                            data: "email"
                        },
                        {
                            data: "mobile"
                        },
                        {
                            data: "message"
                        },
                        {
                            data: "action"
                        }
                    ]
                });
            }
            function deletedata(id) {
                $('#loaderr').css('display', "block");
                $.ajax({
                    type: 'post',
                    url: 'Link_Library/link_ajax_data.php',
                    data: {"delete_data": id},
                    success: function (response) {
                        $('#loaderr').css("display", "none");
                        console.log("Success", response);
                        var res = JSON.parse(response);
                        if (res.success == 1) {
                            $('#name').val("");
                            $('#email').val("");
                            $('#mobile').val("");
                            $('#message').val("");
                            getData();
                        }
                    },
                    error: function (response) {
                        console.log("Error", response);
                        alert("Someting Went Wrong Contact Admin!");
                        return;
                    }

                });
            }
            function editData(index) {
                data = current_data[index];
                $('#name').val(data.name);
                $('#mobile').val(data.mobile);
                $('#email').val(data.email);
                $('#message').val(data.message);
                edit_id = data.auto_id;
                $('#save_data').html("Update");
                $('#save_data').attr('onclick', 'update_date()');

            }
            function update_date() {
                console.log('edit_id', edit_id);
                var name = $('#name').val().trim();
                if (name == "") {
                    alert("Please enter name");
                    $('#name').focus();
                    return;
                }
                ;
                var email = $('#email').val().trim();
                if (email == "") {
                    alert("Please enter email!");
                    $('#email').focus();
                    return;
                } else {
                    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                    if (!regex.test(email)) {
                        alert("Please enter a valid email!");
                        $('#email').focus();
                        return;
                    }
                }
                var mobile = $('#mobile').val().trim();
                if (mobile == "") {
                    alert("Please enter mobile number!");
                    $('#mobile').focus();
                    return;
                } else if (mobile.length != 10) {
                    alert("Please enter a valid mobile number!");
                    $('#mobile').focus();
                    return;
                }
                var message = $('#message').val().trim();
                if (message == "") {
                    alert("Please enter something!");
                    $('#message').focus();
                    return;
                }
                var postdata = {"name": name, "email": email, "mobile": mobile, "message": message, "auto_id": edit_id};
                var datastring = JSON.stringify(postdata);
                $('#loaderr').css("display", "block");
                $.ajax({
                    type: 'post',
                    url: 'Link_Library/link_ajax_data.php',
                    data: {"insert_data": datastring},
                    success: function (response) {
                        $('#loaderr').css("display", "none");
                        console.log("Success", response);
                        var res = JSON.parse(response);
                        if (res.success == 1) {
                            $('#name').val("");
                            $('#email').val("");
                            $('#mobile').val("");
                            $('#message').val("");
                            $('#save_data').html("Save");
                            $('#save_data').attr('onclick', 'save_data()');
                            getData();
                        }
                    },
                    error: function (response) {
                        console.log("Error", response);
                        alert("Someting Went Wrong Contact Admin!");
                        return;
                    }

                });
            }
        </script>
    </body>
</html>
