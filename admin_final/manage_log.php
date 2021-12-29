<?php
include("include/header.php");
?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Activity Log</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Log List</p>
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
                ?>
</body>

</html>

<div id="edit-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="single_log">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">Log Details</h4>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="fullname">
                                <strong>Log ID</strong>
                            </label>
                            <input type="text" class="form-control" id="id" name="id" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="fullname">
                                <strong>Log Time</strong>
                            </label>
                            <input type="text" class="form-control" id="time" name="time" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="username">
                                <strong>Log Name</strong>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" readonly/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="password">
                                <strong>Log Description</strong>
                            </label>
                            <textarea type="text" class="form-control" id="desc" name="desc" readonly></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="email">
                                <strong>Account Created</strong>
                            </label>
                            <input type="text" class="form-control" id="account" name="account" readonly/>
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
                url:"fetch_log.php",
                method:"POST",
                data:{query:query},
                success:function(data) {
                    $('#table').html(data);
                }
            });
        }

        //Display Single Data
        $(document).on('click', '.info', function() {
            var logID = $(this).attr('id');
            $.ajax({
                url:"single_log.php",
                method:"POST",
                data:{logID:logID},
                dataType:'json',
                success:function(data) {
                    $('#edit-modal').modal('show');
                    $('#id').val(logID);
                    $('#time').val(data.logTime);
                    $('#name').val(data.logName);
                    $('#desc').val(data.logContent);
                    $('#account').val(data.accountCreated);
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