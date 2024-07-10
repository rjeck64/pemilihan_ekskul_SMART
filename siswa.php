<?php
// Query SQL untuk mengambil data dari tabel siswa
$sql = "SELECT * FROM siswa";
$result = $conn->query($sql);
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Siswa</h4>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                Tambah Siswa
            </button>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Kelas</th>
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
                                echo "<td>" . $row["nm_siswa"] . "</td>";
                                echo "<td>" . $row["alamat"] . "</td>";
                                echo "<td>" . $row["no_telepon"] . "</td>";
                                echo "<td>" . $row["jenis_kelamin"] . "</td>";
                                echo "<td>" . $row["tanggal_lahir"] . "</td>";
                                echo "<td>" . $row["kelas"] . "</td>";
                                echo '<td>
                                        <button type="button" class="btn btn-primary btn-rounded btn-icon edit-button" data-id="' . $row["kd_siswa"] . '" data-name="' . $row["nm_siswa"] . '" data-address="' . $row["alamat"] . '" data-phone="' . $row["no_telepon"] . '" data-gender="' . $row["jenis_kelamin"] . '" data-birthdate="' . $row["tanggal_lahir"] . '" data-class="' . $row["kelas"] . '">
                                            <i class="ti-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-rounded btn-icon delete-button" data-id="' . $row["kd_siswa"] . '">
                                            <i class="ti-trash"></i>
                                        </button>
                                        </td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Data Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm">
          <div class="form-group">
            <label for="addName">Nama Siswa</label>
            <input type="text" class="form-control" id="addName" name="nm_siswa" required>
          </div>
          <div class="form-group">
            <label for="addAddress">Alamat</label>
            <input type="text" class="form-control" id="addAddress" name="alamat" required>
          </div>
          <div class="form-group">
            <label for="addPhone">No Telepon</label>
            <input type="text" class="form-control" id="addPhone" name="no_telepon" required>
          </div>
          <div class="form-group">
            <label for="addGender">Jenis Kelamin</label>
            <select class="form-control" id="addGender" name="jenis_kelamin" required>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addBirthdate">Tanggal Lahir</label>
            <input type="date" class="form-control" id="addBirthdate" name="tanggal_lahir" required>
          </div>
          <div class="form-group">
            <label for="addClass">Kelas</label>
            <input type="text" class="form-control" id="addClass" name="kelas" required>
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

<!-- modal edit data -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Data Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <input type="hidden" id="editId">
          <div class="form-group">
            <label for="editName">Nama Siswa</label>
            <input type="text" class="form-control" id="editName" name="nm_siswa">
          </div>
          <div class="form-group">
            <label for="editAddress">Alamat</label>
            <input type="text" class="form-control" id="editAddress" name="alamat">
          </div>
          <div class="form-group">
            <label for="editPhone">No Telepon</label>
            <input type="text" class="form-control" id="editPhone" name="no_telepon">
          </div>
          <div class="form-group">
            <label for="editGender">Jenis Kelamin</label>
            <select class="form-control" id="editGender" name="jenis_kelamin">
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editBirthdate">Tanggal Lahir</label>
            <input type="date" class="form-control" id="editBirthdate" name="tanggal_lahir">
          </div>
          <div class="form-group">
            <label for="editClass">Kelas</label>
            <input type="text" class="form-control" id="editClass" name="kelas">
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

<script>
function submitAddForm() {
  // Get form data
  var formData = {
    nm_siswa: document.getElementById('addName').value,
    alamat: document.getElementById('addAddress').value,
    no_telepon: document.getElementById('addPhone').value,
    jenis_kelamin: document.getElementById('addGender').value,
    tanggal_lahir: document.getElementById('addBirthdate').value,
    kelas: document.getElementById('addClass').value
  };

  // Send AJAX request to add data
  $.ajax({
    url: 'page/add/add_siswa.php', // Change this to the correct URL for your add script
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

document.addEventListener("DOMContentLoaded", function() {
  // Handle edit button click
  document.querySelectorAll('.edit-button').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.getAttribute('data-id');
      var name = this.getAttribute('data-name');
      var address = this.getAttribute('data-address');
      var phone = this.getAttribute('data-phone');
      var gender = this.getAttribute('data-gender');
      var birthdate = this.getAttribute('data-birthdate');
      var className = this.getAttribute('data-class');

      // Set data to modal
      document.getElementById('editId').value = id;
      document.getElementById('editName').value = name;
      document.getElementById('editAddress').value = address;
      document.getElementById('editPhone').value = phone;
      document.getElementById('editGender').value = gender;
      document.getElementById('editBirthdate').value = birthdate;
      document.getElementById('editClass').value = className;

      // Show modal
      $('#editModal').modal('show');
    });
  });

  // Handle delete button click
  document.querySelectorAll('.delete-button').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.getAttribute('data-id');
      var confirmDelete = confirm("Are you sure you want to delete this record?");
      if (confirmDelete) {
        // Send AJAX request to delete data
        $.ajax({
          url: 'page/hapus/delete_siswa.php', // Change this to the correct URL for your delete script
          type: 'POST',
          data: { kd_siswa: id },
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
    kd_siswa: document.getElementById('editId').value,
    nm_siswa: document.getElementById('editName').value,
    alamat: document.getElementById('editAddress').value,
    no_telepon: document.getElementById('editPhone').value,
    jenis_kelamin: document.getElementById('editGender').value,
    tanggal_lahir: document.getElementById('editBirthdate').value,
    kelas: document.getElementById('editClass').value
  };

  // Send AJAX request to update data
  $.ajax({
    url: 'page/update/update_data_siswa.php', // Change this to the correct URL for your update script
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
</script>
