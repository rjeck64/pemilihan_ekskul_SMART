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
                            <th>Minat</th>
                            <th>Pengalaman</th>
                            <th>Teknikal</th>
                            <th>Fisik</th>
                            <th>Komunikasi</th>
                            <th>Kerjasama Tim</th>
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
                                echo "<td>" . $row["minat"] . "</td>";
                                echo "<td>" . $row["pengalaman"] . "</td>";
                                echo "<td>" . $row["teknikal"] . "</td>";
                                echo "<td>" . $row["fisik"] . "</td>";
                                echo "<td>" . $row["komunikasi"] . "</td>";
                                echo "<td>" . $row["kerjasama_tim"] . "</td>";
                                echo '<td>
                                        <button type="button" class="btn btn-primary btn-rounded btn-icon edit-button" data-id="' . $row["kd_siswa"] . '" data-name="' . $row["nm_siswa"] . '" data-minat="' . $row["minat"] . '" data-pengalaman="' . $row["pengalaman"] . '" data-teknikal="' . $row["teknikal"] . '" data-fisik="' . $row["fisik"] . '" data-komunikasi="' . $row["komunikasi"] . '" data-kerjasama_tim="' . $row["kerjasama_tim"] .  '">
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
            <label for="addMinat">Minat</label>
            <select class="form-control" id="addMinat" name="minat" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addPengalaman">Pengalaman</label>
            <select class="form-control" id="addPengalaman" name="pengalaman" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addTeknikal">Teknikal</label>
            <select class="form-control" id="addTeknikal" name="teknikal" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
            
          </div>
          <div class="form-group">
            <label for="addFisik">Fisik</label>
            <select class="form-control" id="addFisik" name="fisik" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addKomunikasi">Komunikasi</label>
            <select class="form-control" id="addKomunikasi" name="komunikasi" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="addKerjasama">Kerjasama Tim</label>
            <select class="form-control" id="addKerjasama" name="kerjasama_tim" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
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
            <input type="text" class="form-control" id="editName" name="nm_siswa" required>
          </div>
          <div class="form-group">
            <label for="editMinat">Minat</label>
            <select class="form-control" id="editMinat" name="minat" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editPengalaman">Pengalaman</label>
            <select class="form-control" id="editPengalaman" name="pengalaman" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editTeknikal">Teknikal</label>
            <select class="form-control" id="editTeknikal" name="teknikal" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
            
          </div>
          <div class="form-group">
            <label for="editFisik">Fisik</label>
            <select class="form-control" id="editFisik" name="fisik" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editKomunikasi">Komunikasi</label>
            <select class="form-control" id="editKomunikasi" name="komunikasi" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editKerjasama">Kerjasama Tim</label>
            <select class="form-control" id="editKerjasama" name="kerjasama_tim" required>
              <option value="Sangat Kurang">Sangat Kurang</option>
              <option value="Kurang">Kurang</option>
              <option value="cukup">cukup</option>
              <option value="baik">baik</option>
              <option value="Sangat Baik">Sangat Baik</option>
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

<script>
function submitAddForm() {
  // Get form data
  var formData = {
    nm_siswa: document.getElementById('addName').value,
    minat: document.getElementById('addMinat').value,
    pengalaman: document.getElementById('addPengalaman').value,
    teknikal: document.getElementById('addTeknikal').value,
    fisik: document.getElementById('addFisik').value,
    komunikasi: document.getElementById('addKomunikasi').value,
    kerjasama_tim: document.getElementById('addKerjasama').value
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
      var minat = this.getAttribute('data-minat');
      var pengalaman = this.getAttribute('data-pengalaman');
      var teknikal = this.getAttribute('data-teknikal');
      var fisik = this.getAttribute('data-fisik');
      var komunikasi = this.getAttribute('data-komunikasi');
      var kerjasama_tim = this.getAttribute('data-kerjasama_tim');

      // Set data to modal
      document.getElementById('editId').value = id;
      document.getElementById('editName').value = name;
      document.getElementById('editMinat').value = minat;
      document.getElementById('editPengalaman').value = pengalaman;
      document.getElementById('editTeknikal').value = teknikal;
      document.getElementById('editFisik').value = fisik;
      document.getElementById('editKomunikasi').value = komunikasi;
      document.getElementById('editKerjasama').value = kerjasama_tim;

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
    minat: document.getElementById('editMinat').value,
    pengalaman: document.getElementById('editPengalaman').value,
    teknikal: document.getElementById('editTeknikal').value,
    fisik: document.getElementById('editFisik').value,
    komunikasi: document.getElementById('editKomunikasi').value,
    kerjasama_tim: document.getElementById('editKerjasama').value
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
