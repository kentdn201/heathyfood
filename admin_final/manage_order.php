<?php
include("include/header.php");
?>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Order Management</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Order List</p>
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
                                            <input type="search" name="search" id="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" />
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

<script>

    $(document).ready(function(){
        
        load_data();

        //Display Fetched Data
        function load_data(query) {
            $.ajax({
                url:"fetch_order.php",
                method:"POST",
                data:{query:query},
                success:function(data) {
                    $('#table').html(data);
                }
            });
        }
        
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