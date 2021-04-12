<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Issue Trackers</title>

</head>

<body>
    <div class="container-sm">

        <br>
        <br>
    </div>
    <div class="container-sm">
        <div class="row">
            <div class="col-sm-8">
                <h2>Issue <b>Tracker</b></h2>
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#issueModal">
                    <i class="fa fa-plus "></i> Add Issue
                </button>

                <a href="JavaScript:void(0);" class="btn btn-danger" id="deleteMultiple"><i class="fa fa-trash-o "></i>
                    Delete</a>
            </div>
        </div>

        <div class="card text-center">

            <div class="card-body table-responsive-sm table-responsive-md">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">IssueId</th>
                            <th scope="col">Assignee</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Status</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Update Date</th>
                            <th scope="col">Action</th>
                            <th>
                                <input type="checkbox" id="allCB" class="form-check-input">
                                <label for="selectAll"></label>

                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableItem">

                    </tbody>
                </table>

            </div>
        </div>


        <div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="issueModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="issueForm">
                            <div class="form-group">
                                <label for="assignee">Assignee</label>
                                <input type="text" class="form-control" id="assignee" name="assignee" placeholder="name" required="true" minlength="3" maxlength="40">
                                <span id="labelAssignee" style="display:none;color:red;">Please enter value</span>
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject here">
                                <span id="labelSubject" style="display:none;color:red;">Please enter subject</span>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="" selected>Choose Status</option>
                                    <option value="Complete">Complete</option>
                                    <option value="Pending">Pending</option>
                                </select>
                                <span id="labelSelectStatus" style="display:none;color:red;">Please select status</span>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Due Date</label>
                                <input type="text" class="form-control" id="dueDate" name="dueDate" minLength="10" placeholder="YYYY-MM-DD">
                                <span id="labelDueDate" style="display:none;color:red;">Please enter value</span>
                            </div>


                            <div class="modal-footer">
                                <input type="hidden" value="1" name="type">
                                <input type="hidden" value="" name="updateIssueId" id="updateIssueId">
                                <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                                <button type="button" class="btn btn-success" id="btnAdd">Add</button>
                                <button type="button" class="btn btn-success" id="btnUpdate" style="display: none">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom" style="bottom:10px;padding-bottom: 10px;">
            <div class="container-sm">
                <div class="row">
                    <div class="lead">
                        &copy; 2021 Copyright to Adnan. All rights reserved.

                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function($) {

                $("#issueModal").on('hidden.bs.modal', function() {
                    $('#assignee').val('');
                    $('#subject').val('');
                    $("#status").prop('selectedIndex', 0);
                    $('#dueDate').val('');
                    $("#btnUpdate").hide()
                    $("#btnAdd").show()
                    $('#labelSubject').hide();
                    $('#labelDueDate').hide();
                    $('#labelAssignee').hide();
                    $('#labelSelectStatus').hide();
                })

                $("input").focusout(function() {
                    $('#labelSubject').hide();
                    $('#labelDueDate').hide();
                    $('#labelAssignee').hide();
                }).trigger("focusout");
                $("#status").focusout(function() {
                    $('#labelSelectStatus').hide();
                })


                var checkbox = $('table input[type="checkbox"]');

                $('#allCB').change(function() {
                    if ($(this).prop('checked')) {
                        $('tbody tr td input[type="checkbox"]').each(function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        $('tbody tr td input[type="checkbox"]').each(function() {
                            $(this).prop('checked', false);
                        });
                    }
                });


                /******************** Fetch All ********************************************/
                $.ajax({
                    type: "get",
                    url: "../routes/getAll.php",
                    success: function(res) {
                        var result = JSON.parse(res);
                        if (result.statusCode == 200) {

                            showList(result.data)
                        } else if (result.statusCode == 201) {
                            alert(result);
                        }
                    },
                    error: function(e) {
                        console.log(e)
                    }
                });

            });


            /******************** Add request ********************************************/

            $(document).on('click', '#btnAdd', function(e) {
                e.preventDefault()
                $('#labelSubject').hide();
                $('#labelDueDate').hide();
                $('#labelAssignee').hide();
                $('#labelSelectStatus').hide();

                var assignee = $('#assignee').val();
                var subject = $('#subject').val();
                var selectedStatus = $("#status :selected").val();
                var dueDate = $('#dueDate').val();

                if (assignee.trim() == '') {
                    $('#labelAssignee').show();
                    $('#assignee').focus();
                    return false;
                } else if (subject.trim() == '') {

                    $('#labelSubject').show();
                    $('#subject').focus();
                    return false
                } else if (selectedStatus == '') {

                    $('#labelSelectStatus').show();
                    $('#status').focus();
                    return false
                } else if (dueDate.trim() == '') {

                    $('#labelDueDate').show();
                    $('#dueDate').focus();
                    return false
                } else {

                    var data = $("#issueForm").serialize();

                    $.ajax({
                        data: data,
                        type: "post",
                        url: "../routes/operation.php",
                        success: function(result) {

                            try {
                                var result = JSON.parse(result);
                                if (result.statusCode == 200) {
                                    $('#issueModal').modal('hide');
                                    alert('Data added successfully !');
                                    location.reload();
                                } else if (result.statusCode == 201) {
                                    alert(result.data);
                                } else if (result.statusCode == 203) {
                                    alert(result.data);
                                }

                            } catch (error) {
                                console.log(error)
                            }

                        },
                        error: function(e) {
                            console.log(e)
                        }
                    });
                }

            })

            /******************** Update request ********************************************/


            $(document).on('click', '#btnUpdate', function(e) {
                e.preventDefault()
                $('#labelSubject').hide();
                $('#labelDueDate').hide();
                $('#labelAssignee').hide();
                $('#labelSelectStatus').hide();

                var assignee = $('#assignee').val();
                var subject = $('#subject').val();
                var selectedStatus = $("#status :selected").val();
                var dueDate = $('#dueDate').val();

                if (assignee.trim() == '') {
                    $('#labelAssignee').show();
                    $('#assignee').focus();
                    return false;
                } else if (subject.trim() == '') {

                    $('#labelSubject').show();
                    $('#subject').focus();
                    return false
                } else if (selectedStatus == '') {

                    $('#labelSelectStatus').show();
                    $('#status').focus();
                    return false
                } else if (dueDate.trim() == '') {

                    $('#labelDueDate').show();
                    $('#dueDate').focus();
                    return false
                } else {

                    let id = $("#updateIssueId").val()

                    var data = $("#issueForm").serialize() + "&id=" + id;

                    $.ajax({
                        data: data,
                        type: "post",
                        url: "../routes/update.php",
                        success: function(result) {

                            try {

                                var result = JSON.parse(result);
                                if (result.statusCode == 200) {
                                    $('#issueModal').modal('hide');
                                    alert('Data updated successfully !');
                                    location.reload();
                                } else if (result.statusCode == 201) {
                                    alert(result.data);
                                } else if (result.statusCode == 203) {
                                    alert(result.data);
                                }

                            } catch (error) {
                                console.log(error)
                            }

                        },
                        error: function(e) {
                            console.log(e)
                        }
                    });
                }

            })


            /******************** Populate data into table ********************************************/

            function showList(items) {
                items.forEach(element => {
                    $("#tableItem").append(
                        `<tr id="${element.id}">
                    <td>${element.issueId}</td>
                    <td>${element.assignee}</td>
                    <td>${element.subject}</td>
                    <td>${element.status}</td>
                    <td>${element.dueDate}</td>
                    <td>${element.updateDate}</td>
                    <td>
                        <i onClick = editRow(${element.id}) id="edit" class="fa fa-pencil-square-o" aria-hidden="true" style="cursor: pointer; font-size:20px; color:green;"></i>
                        <i onClick = delRow(${element.id}) id="delete" class="fa fa-trash-o" aria-hidden="true"  style="cursor: pointer; font-size:20px; color:red;"></i>
                        </td>
                        <td>
                       
								<input id="userCheckbox" type="checkbox" class="form-check-input" data-user-id="${element.id}">
								<label for="checkbox"></label>
						
                        </td>
                     </tr>
                  `
                    )
                });
            }

            /*****************           Edit Form   *********************** */
            function editRow(id) {
                var obj = {};
                obj["id"] = id

                $.ajax({
                    data: obj,
                    type: "post",
                    url: "../routes/getIssue.php",
                    success: function(result) {

                        var result = JSON.parse(result);
                        if (result.statusCode == 200) {
                            let res = result.data
                            $("#assignee").val(res[0].assignee)
                            $("#subject").val(res[0].subject)
                            $("#status").val(res[0].status)
                            $("#dueDate").val(res[0].dueDate)
                            $("#updateIssueId").val(res[0].id)
                            $("#btnUpdate").show()
                            $("#btnAdd").hide()
                            $('#issueModal').modal('show');
                        } else if (result.statusCode == 201) {
                            alert(result);
                        }
                    },
                    error: function(e) {
                        console.log(e)
                    }
                });
            }

            /***********************************  Delete single row *********************** */

            function delRow(id) {
                var obj = {};
                obj["id"] = id

                $.ajax({
                    data: obj,
                    type: "post",
                    url: "../routes/delete.php",
                    success: function(result) {

                        var result = JSON.parse(result);
                        if (result.statusCode == 200) {
                            alert('Data deleted successfully !');
                            location.reload();
                        } else if (result.statusCode == 201) {
                            alert(result);
                        }
                    },
                    error: function(e) {
                        console.log(e)
                    }
                });
            }

            /***********************************  Delete multiple rows *********************** */

            $(document).on("click", "#deleteMultiple", function() {
                var user = [];
                $("#userCheckbox:checked").each(function() {
                    user.push($(this).data('user-id'));
                });
                if (user.length <= 0) {
                    alert("Please select records");
                } else {

                    WRN_PROFILE_DELETE = "Are you sure you want to delete " + (user.length > 1 ? "these" : "this") + " row?";
                    var checked = confirm(WRN_PROFILE_DELETE);
                    if (checked == true) {

                        // var selected_values = user.join(",");
                        $.ajax({
                            type: "POST",
                            url: "../routes/operation.php",
                            cache: false,
                            data: {
                                type: 4,
                                id: user
                            },
                            success: function(res) {
                                console.log(res)
                                var result = JSON.parse(res);
                                if (result.statusCode == 200) {
                                    alert('records deleted successfully!');
                                    location.reload();
                                } else if (result.statusCode == 201) {
                                    alert(result);
                                }
                            },
                            error: function(e) {
                                console.log(e)
                            }
                        });
                    }
                }

            });
        </script>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>