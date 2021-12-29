<?php
include("include/header.php");
if($user['roleID'] != 'role_0') { ?>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">You don't have the sufficient authority to access this page</h3>
    </div>
<?php }
else {
?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Account Role Management</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Account Role List</p>
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
                                            <input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" />
                                        </label>
                                        <a class="btn btn-primary float-right" href="add_role.php" role="button">Add New Role</a>
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

<script>

    $(document).ready(function(){
        
        load_data();

        //Display Fetched Data
        function load_data() {
            $.ajax({
                url:"fetch_role.php",
                method:"POST",
                success:function(data) {
                    $('#table').html(data);
                }
            });
        }

        //Delete Data
        $(document).on('click', '.delete', function() {
            var roleID = $(this).attr('id');
            if(confirm("Are you sure you want to delete this item?")) {
                $.ajax({
                    url:"delete_role.php",
                    method:"POST",
                    data:{roleID:roleID},
                    success:function(data) {
                        load_data();
                        alert("Data Removed");
                    }
                });
            }
        });
    });

</script>