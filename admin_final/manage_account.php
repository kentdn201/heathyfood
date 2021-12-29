<?php
include("include/header.php");
if($user['roleID'] != 'role_0') { ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">You don't have the sufficient authority to access this page</h3>
    </div>
<?php }
else { ?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Account Management</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Account List</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-nowrap">
                                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                        <label class="form-label">Show <select class="d-inline-block form-select form-select-sm">
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter">
                                        <label class="form-label">
                                            <input type="text" name="search" id="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" />
                                        </label>
                                        <a class="btn btn-primary float-right" href="add_account.php" role="button">Add New Account</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table">
                                                
                            </div>
                        </div>
                    </div>
                </div>
<?php
include("include/footer.php");
}
?>
</body>

</html>

<div id="edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="single_account">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">Account Details</h4>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="fullname">
                                <strong>Fullname</strong>
                            </label>
                            <input type="text" class="form-control" id="fullname" name="fullname" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="username">
                                <strong>Username</strong>
                            </label>
                            <input type="text" class="form-control" id="username" name="username" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="password">
                                <strong>Password</strong>
                            </label>
                            <input type="password" class="form-control" id="password" name="password" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="email">
                                <strong>Email</strong>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="phone">
                                <strong>Phone Number</strong>
                            </label>
                            <input type="tel" class="form-control" id="phone" name="phone" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="role">
                                <strong>Role</strong>
                            </label>
                            <input type="text" class="form-control" id="role" name="role" readonly/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        
        load_data();

        //Display Fetched Data
        function load_data(query) {
            $.ajax({
                url:"fetch_account.php",
                method:"POST",
                data:{query:query},
                success:function(data) {
                    $('#table').html(data);
                }
            });
        }

        //Display Single Data
        $(document).on('click', '.info', function() {
            var accountID = $(this).attr('id');
            $.ajax({
                url:"single_account.php",
                method:"POST",
                data:{accountID:accountID},
                dataType:'json',
                success:function(data) {
                    $('#edit-modal').modal('show');
                    $('#accountID').val(accountID);
                    $('#fullname').val(data.fullname);
                    $('#username').val(data.username);
                    $('#password').val(data.password);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#role').val(data.role);
                }
            });
        });

        //Search
        $('#search').keyup(function(){
            var txt = $(this).val();
            if(txt != '') {
                load_data(txt);
            }
            else {
                load_data();
            }
        });
    });

</script>