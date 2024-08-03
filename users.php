  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<nav aria-label="breadcrumb ">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-success">Home</li>
  </ol>
</nav>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <button class="btn btn-success float-right btn-md" id="new_user"><i class="fa fa-plus"></i> New user</button>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="card col-lg-12">
      <div class="card-body">
        <table class="table-striped table-bordered col-md-12">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Name</th>
              <th class="text-center">Username</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include 'db_connect.php';
            if (!isset($_SESSION['login_id']))
              header('location:login.php');
            $users = $conn->query("SELECT * FROM users ORDER BY name ASC");
            $i = 1;
            while ($row = $users->fetch_assoc()) :
            ?>
              <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td>
                  <center>
                    <div class="btn-group">
                      <button type="button" class="btn btn-success">Action</button>
                      <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Delete</a>
                      </div>
                    </div>
                  </center>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#new_user').click(function() {
        uni_modal('New User', 'manage_user.php');
    });

    $('.edit_user').click(function() {
        var id = $(this).attr('data-id');
        uni_modal('Edit User', 'manage_user.php?id=' + id);
        
        // Use SweetAlert after editing
        $(document).on('submit', '#manage_user_form', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'save_user.php', // Make sure to handle form submission in save_user.php
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'User successfully edited',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to edit user',
                            text: response
                        });
                    }
                }
            });
        });
    });

    $('.delete_user').click(function() {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_user.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if (response == 1) {
                            Swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to delete user',
                                text: response
                            });
                        }
                    }
                });
            }
        });
    });
});
</script>

