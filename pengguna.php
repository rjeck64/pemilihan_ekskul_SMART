<?php
// Query SQL untuk mengambil data dari tabel user
$sql = "SELECT id, username, email, level FROM user";
$result = $conn->query($sql);
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Pengguna</h4>
            <button type="button" class="btn btn-primary btn-rounded btn-icon" data-toggle="modal" data-target="#addModal">
                <i class="ti-plus"></i>
            </button>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Menampilkan data untuk setiap baris
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["level"] . "</td>";
                                echo '<td>
                                        <button type="button" class="btn btn-primary btn-rounded btn-icon edit-button" data-id="' . $row["id"] . '" data-username="' . $row["username"] . '" data-email="' . $row["email"] . '" data-level="' . $row["level"] . '">
                                            <i class="ti-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-rounded btn-icon" data-toggle="modal" data-target="#modalHapus' . $row["id"] . '">
                                                <i class="ti-trash"></i>
                                        </button>
                                      </td>';
                                echo "</tr>";

                                echo '<div class="modal fade" id="modalHapus' . $row["id"] . '" tabindex="-1" role="dialog" aria-labelledby="modalHapus' . $row["id"] . 'Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalHapus' . $row["id"] . 'Label">Konfirmasi Hapus Kriteria</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Anda yakin ingin menghapus kriteria <strong>' . $row["username"] . '</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="id" value="' . $row["id"] . '">
                                                        <button type="button" class="btn btn-danger delete-button" data-id="' . $row["id"] .'">Hapus</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <input type="hidden" id="editId" name="id">
          <div class="form-group">
            <label for="editUsername">Username</label>
            <input type="text" class="form-control" id="editUsername" name="username" required>
          </div>
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>
          <div class="form-group">
            <label for="editLevel">Level</label>
            <select class="form-control" id="editLevel" name="level" required>
              <option value="admin">Admin</option>
              <option value="superadmin">Superadmin</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitEditForm()">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal untuk Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm">
          <div class="form-group">
            <label for="addUsername">Username</label>
            <input type="text" class="form-control" id="addUsername" name="username" required>
          </div>
          <div class="form-group">
            <label for="addEmail">Email</label>
            <input type="email" class="form-control" id="addEmail" name="email" required>
          </div>
          <div class="form-group">
            <label for="addPassword">Password</label>
            <input type="password" class="form-control" id="addPassword" name="password" required>
          </div>
          <div class="form-group">
            <label for="addLevel">Level</label>
            <select class="form-control" id="addLevel" name="level" required>
              <option value="admin">Admin</option>
              <option value="superadmin">Superadmin</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitAddForm()">Save changes</button>
      </div>
    </div>
  </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function() {
  // Handle edit button click
  document.querySelectorAll('.edit-button').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.getAttribute('data-id');
      var username = this.getAttribute('data-username');
      var email = this.getAttribute('data-email');
      var level = this.getAttribute('data-level');

      // Set data to modal
      document.getElementById('editId').value = id;
      document.getElementById('editUsername').value = username;
      document.getElementById('editEmail').value = email;
      document.getElementById('editLevel').value = level;

      // Show modal
      $('#editModal').modal('show');
    });
  });

  // Handle delete button click
  document.querySelectorAll('.delete-button').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.getAttribute('data-id');
      var confirmDelete = true;
      if (confirmDelete) {
        // Send AJAX request to delete data
        $.ajax({
          url: 'page/hapus/delete_user.php', // Change this to the correct URL for your delete script
          type: 'POST',
          data: { id: id },
          success: function(response) {
            // Handle success
            alert('Data deleted successfully!');
            location.reload(); // Reload the page to reflect changes
          },
          error: function(xhr, status, error) {
            // Handle error
            alert('Error deleting data: ' + error);
          }
        });
      }
    });
  });
});

function submitEditForm() {
  // Get form data
  var formData = {
    id: document.getElementById('editId').value,
    username: document.getElementById('editUsername').value,
    email: document.getElementById('editEmail').value,
    level: document.getElementById('editLevel').value
  };

  // Send AJAX request to update data
  $.ajax({
    url: 'page/update/update_user.php', // Change this to the correct URL for your update script
    type: 'POST',
    data: formData,
    success: function(response) {
      // Handle success
      alert('Data updated successfully!');
      location.reload(); // Reload the page to reflect changes
    },
    error: function(xhr, status, error) {
      // Handle error
      alert('Error updating data: ' + error);
    }
  });
}

function submitAddForm() {
  // Get form data
  var formData = {
    username: document.getElementById('addUsername').value,
    email: document.getElementById('addEmail').value,
    password: document.getElementById('addPassword').value,
    level: document.getElementById('addLevel').value
  };

  // Send AJAX request to add data
  $.ajax({
    url: 'page/add/add_user.php', // Change this to the correct URL for your add script
    type: 'POST',
    data: formData,
    success: function(response) {
      // Handle success
      alert('Data added successfully!');
      location.reload(); // Reload the page to reflect changes
    },
    error: function(xhr, status, error) {
      // Handle error
      alert('Error adding data: ' + error);
    }
  });
}
</script>
