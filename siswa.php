<?php
// Define database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pemilihan_ekskul"; // Change to your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to calculate utility value
function calculate_utility($value, $min, $max)
{
    if ($min == $max) {
        return 0; // Handle division by zero if necessary
    }
    return ($value - $min) / ($max - $min);
}

// Fetch criteria names for display
$query_criteria = "SELECT * FROM kriteria ORDER BY nama_kriteria ASC";
$result_criteria = $conn->query($query_criteria);

$criteria_names = [];
$kriteria = [];
while ($row = $result_criteria->fetch_assoc()) {
    $criteria_names[] = $row['nama_kriteria'];
    $kriteria[] = $row['kriteria'];
    // echo $row['nama_kriteria'];
}

// Query to fetch names of students who are not in nilai_kriteria table
$query_nama_siswa = "
    SELECT s.kd_siswa, s.nm_siswa
    FROM siswa s
    LEFT JOIN detail_siswa ds ON s.kd_siswa = ds.kd_siswa
    WHERE ds.kd_detail IS NULL;
";
$result_nama_siswa = $conn->query($query_nama_siswa);

// Process form submission for adding data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $nama_siswa = $_POST['nama_siswa'];

    // Masukkan langsung ke tabel siswa
    $insert_siswa_query = "INSERT INTO siswa (nm_siswa) VALUES ('$nama_siswa')";
    if ($conn->query($insert_siswa_query) === TRUE) {
        $kd_siswa = $conn->insert_id; // Dapatkan id yang baru dimasukkan (kd_siswa)
    } else {
        echo "Error: " . $insert_siswa_query . "<br>" . $conn->error;
    }

    if (isset($kd_siswa)) {
        // Loop untuk setiap ekstrakurikuler
        $query_ekskul = "SELECT * FROM ekskul";
        $result_ekskul = $conn->query($query_ekskul);
        while ($row_ekskul = $result_ekskul->fetch_assoc()) {
            $kd_ekskul = $row_ekskul['kd_ekskul'];

            // Masukkan ke tabel detail_siswa
            $insert_detail_query = "INSERT INTO detail_siswa (kd_siswa, kd_ekskul) VALUES ('$kd_siswa', '$kd_ekskul')";
            if ($conn->query($insert_detail_query) === TRUE) {
                $kd_detail = $conn->insert_id; // Dapatkan id yang baru dimasukkan (kd_detail)

                // Masukkan nilai ke tabel nilai_kriteria untuk setiap kriteria
                foreach ($criteria_names as $criteria_name) {
                    $nilai_field = 'nilai_' . $kd_ekskul . '_' . $criteria_name;
                    if (isset($_POST[$nilai_field])) {
                        $nilai = $_POST[$nilai_field];

                        // Dapatkan id_kriteria
                        $id_kriteria_query = "SELECT id_kriteria FROM kriteria WHERE nama_kriteria = '$criteria_name'";
                        $result_id_kriteria = $conn->query($id_kriteria_query);
                        if ($result_id_kriteria->num_rows > 0) {
                            $row_id_kriteria = $result_id_kriteria->fetch_assoc();
                            $id_kriteria = $row_id_kriteria['id_kriteria'];

                            // Masukkan ke tabel nilai_kriteria
                            $insert_nilai_query = "INSERT INTO nilai_kriteria (kd_detail, id_kriteria, nilai) VALUES ('$kd_detail', '$id_kriteria', '$nilai')";
                            if (!$conn->query($insert_nilai_query)) {
                                echo "Error: " . $insert_nilai_query . "<br>" . $conn->error;
                            }
                        }
                    } else {
                        echo "Error: Nilai untuk kriteria $criteria_name tidak ditemukan.";
                    }
                }
            } else {
                echo "Error: " . $insert_detail_query . "<br>" . $conn->error;
            }
        }
        echo "<script>
                alert('Data alternatif berhasil ditambah');
                window.location.href = 'index.php?i=siswa';
              </script>";
    } else {
        echo "Error: Gagal menambahkan data siswa.";
    }
}







if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
    // echo "kd_siswa: " . $_POST['kd_siswa'] . "<br>";
    // echo "nama_siswa: " . $_POST['nama_siswa'] . "<br>";

    $kd_siswa = $_POST['kd_siswa'];
    $nama_siswa = $_POST['nama_siswa'];

    // Loop through each extracurricular activity
    $query_ekskul = "SELECT * FROM ekskul";
    $result_ekskul = $conn->query($query_ekskul);
    while ($row_ekskul = $result_ekskul->fetch_assoc()) {
        $kd_ekskul = $row_ekskul['kd_ekskul'];
        // echo "Ekskul: " . $kd_ekskul . "<br>";

        // Get kd_detail for the specific student and ekskul
        $query_detail = "SELECT kd_detail FROM detail_siswa WHERE kd_siswa = '$kd_siswa' AND kd_ekskul = '$kd_ekskul'";
        $result_detail = $conn->query($query_detail);
        if ($result_detail->num_rows > 0) {
            $row_detail = $result_detail->fetch_assoc();
            $kd_detail = $row_detail['kd_detail'];
            // echo "kd_detail: " . $kd_detail . "<br>";

            // Update nilai_kriteria table for each criteria
            foreach ($criteria_names as $criteria_name) {
                $nilai = $_POST['edit_nilai_' . $kd_ekskul . '_' . str_replace(' ', '_', $criteria_name)];
                // echo "edit_nilai_{$kd_ekskul}_" . str_replace(' ', '_', $criteria_name) . ": " . $nilai . "<br>";

                $id_kriteria_query = "SELECT id_kriteria FROM kriteria WHERE nama_kriteria = '$criteria_name'";
                $result_id_kriteria = $conn->query($id_kriteria_query);
                if ($result_id_kriteria->num_rows > 0) {
                    $row_id_kriteria = $result_id_kriteria->fetch_assoc();
                    $id_kriteria = $row_id_kriteria['id_kriteria'];
                    // echo "id_kriteria: " . $id_kriteria . "<br>";

                    // Uncomment the following line to perform the update operation
                    $update_nama = "UPDATE siswa SET nm_siswa = '$nama_siswa' WHERE kd_siswa = '$kd_siswa'";
                    if (!$conn->query($update_nama)) {
                        echo "Error: " . $update_nilai_query . "<br>" . $conn->error;
                    }
                    $update_nilai_query = "UPDATE nilai_kriteria SET nilai = '$nilai' WHERE kd_detail = '$kd_detail' AND id_kriteria = '$id_kriteria'";
                    if (!$conn->query($update_nilai_query)) {
                        echo "Error: " . $update_nilai_query . "<br>" . $conn->error;
                    }
                }
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $kd_siswa_to_delete = intval($_POST['delete']); // Ambil ID siswa yang akan dihapus

    // Query untuk menghapus data dari tabel siswa
    $delete_query = "DELETE FROM siswa WHERE kd_siswa = $kd_siswa_to_delete";
    
    if ($conn->query($delete_query) === TRUE) {
        echo "<script>
                alert('Data siswa berhasil dihapus');
                window.location.href = 'index.php?i=siswa';
              </script>";
    } else {
        echo "Error: " . $delete_query . "<br>" . $conn->error;
    }
}




function UnNormalisasiAlternatif($nilai){
  switch ($nilai) {
    case '1':
      return "Sangat Kurang";
      break;
    case '2':
      return "Kurang";
      break;
    case '3':
      return "Cukup";
      break;
    case '4':
      return "Baik";
      break;
    case '5':
      return "Sangat Baik";
      break;
  }
}


?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h3>Data Siswa dan Ekstrakurikuler</h3>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahDataModal">Tambah
                Data Siswa</button>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Ekstrakurikuler</th>
                        <?php foreach ($kriteria as $nama_kriteria) : ?>
                            <th><?= $nama_kriteria; ?></th>
                        <?php endforeach; ?>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch data from detail_siswa and nilai_kriteria tables
                    $query_siswa = "
                                    SELECT s.kd_siswa, s.nm_siswa, e.kd_ekskul, e.nm_ekskul, k.nama_kriteria, nk.nilai
                                    FROM siswa s
                                    JOIN detail_siswa ds ON s.kd_siswa = ds.kd_siswa
                                    JOIN ekskul e ON ds.kd_ekskul = e.kd_ekskul
                                    JOIN nilai_kriteria nk ON ds.kd_detail = nk.kd_detail
                                    JOIN kriteria k ON nk.id_kriteria = k.id_kriteria
                                    ORDER BY s.kd_siswa, e.kd_ekskul, k.nama_kriteria ASC
                                ";
                    $result_siswa = $conn->query($query_siswa);
                    $current_siswa = null;
                    $current_ekskul = null;
                    $rowspan_count = 0;
                    $current_edit = null;
                    $kd_siswa_tampil = [];


                    while ($row_siswa = $result_siswa->fetch_assoc()) {
                        $kd_siswa = $row_siswa['kd_siswa'];
                        $nm_siswa = $row_siswa['nm_siswa'];
                        $kd_ekskul = $row_siswa['kd_ekskul'];
                        $nm_ekskul = $row_siswa['nm_ekskul'];
                        $nama_kriteria = $row_siswa['nama_kriteria'];
                        $nilai = UnNormalisasiAlternatif($row_siswa['nilai']);
                        

                        $previous_siswa = $current_siswa;
                        $previous_edit = $current_edit;
                        // $current_siswa = $kd_siswa;

                        if ($current_siswa != $kd_siswa) {
                            $current_siswa = $kd_siswa;

                            $query_count_ekskul = "SELECT COUNT(*) AS total_ekskul FROM detail_siswa WHERE
                                    kd_siswa = '$kd_siswa'";
                            $result_count_ekskul = $conn->query($query_count_ekskul);
                            if ($result_count_ekskul->num_rows > 0) {
                                $row_count_ekskul = $result_count_ekskul->fetch_assoc();
                                $rowspan_count = $row_count_ekskul['total_ekskul'];
                            }

                            echo "<tr>";
                            echo "<td rowspan='{$rowspan_count}'>{$nm_siswa}</td>";
                        }


                        if ($current_ekskul != $kd_ekskul) {
                            $current_ekskul = $kd_ekskul;
                            echo "<td>{$nm_ekskul}</td>";
                        }

                        echo "<td>{$nilai}</td>";

                        if ($nama_kriteria == end($criteria_names)) {
                            if (!in_array($kd_siswa, $kd_siswa_tampil)) {
                                echo "<td rowspan='{$rowspan_count}'>
                                                <button type='button' class='btn btn-primary btn-rounded btn-icon edit-btn' data-toggle='modal' data-target='#editDataModal' data-kd-siswa='{$kd_siswa}'>
                                                <i class='ti-pencil-alt'></i>
                                                </button>
                                                <button type='button' class='btn btn-danger btn-rounded btn-icon' data-toggle='modal' data-target='#modalHapus$kd_siswa'>
                                                <i class='ti-trash'></i>
                                            </button>
                                              </td>";
                                              echo '<div class="modal fade" id="modalHapus' . $kd_siswa . '" tabindex="-1" role="dialog" aria-labelledby="modalHapus' . $kd_siswa . 'Label" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="index.php?i=siswa" method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalHapus' . $kd_siswa . 'Label">Konfirmasi Hapus Kriteria</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Anda yakin ingin menghapus kriteria <strong>' . $nm_siswa . '</strong>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id_kriteria" value="' . $kd_siswa . '">
                                                                <button type="submit" class="btn btn-danger" value="'.$kd_siswa.'" name="delete">Hapus</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>';
                                $kd_siswa_tampil[] = $kd_siswa;
                            }
                            echo "</tr>";
                        }
                    }

                    
                    ?>
                </tbody>
            </table>

            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa</label>
                                    <input type="text" class='form-control' id="nama_siswa" name="nama_siswa" required>
                                </div>
                                <?php
                                // Fetch extracurricular activities and criteria dynamically
                                $query_ekskul = "SELECT * FROM ekskul";
                                $result_ekskul = $conn->query($query_ekskul);
                                while ($row_ekskul = $result_ekskul->fetch_assoc()) {
                                    $kd_ekskul = $row_ekskul['kd_ekskul'];
                                    $nm_ekskul = $row_ekskul['nm_ekskul'];

                                    echo "<h5><b>{$nm_ekskul}</b></h5>";

                                    if (count($criteria_names) == count($kriteria)) {
                                        foreach ($criteria_names as $index => $criteria_name) {
                                            $kriteria_name = $kriteria[$index];
                                            echo "<div class='form-group'>";
                                            echo "<label for='nilai_{$kd_ekskul}_{$criteria_name}'>{$kriteria_name}</label>";
                                            echo "<select class='form-control' id='nilai_{$kd_ekskul}_{$criteria_name}' name='nilai_{$kd_ekskul}_{$criteria_name}' required>";
                                            echo "<option value='1'>Sangat Kurang</option>";
                                            echo "<option value='2'>Kurang</option>";
                                            echo "<option value='3'>Cukup</option>";
                                            echo "<option value='4'>Baik</option>";
                                            echo "<option value='5'>Sangat Baik</option>";
                                            echo "</select>";
                                            echo "</div>";
                                        }
                                        
                                    } else {
                                        echo "Array lengths do not match.";
                                    }
                                }
                                ?>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <input type="hidden" name="action" value="add">
                            </form>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Modal Edit Data -->
            <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit Data Siswa</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" id="edit_kd_siswa" name="kd_siswa">
                            <div class="form-group">
                                <label for="edit_nama_siswa">Nama Siswa</label>
                                <input type="text" class="form-control" id="edit_nama_siswa" name="nama_siswa" required>
                            </div>
                            <!-- Dynamically generated select fields for criteria -->
                            <?php
                            // Fetch extracurricular activities and criteria dynamically
                            $query_ekskul = "SELECT * FROM ekskul";
                            $result_ekskul = $conn->query($query_ekskul);
                            while ($row_ekskul = $result_ekskul->fetch_assoc()) {
                                $kd_ekskul = $row_ekskul['kd_ekskul'];
                                $nm_ekskul = $row_ekskul['nm_ekskul'];

                                echo "<h5>{$nm_ekskul}</h5>";

                                foreach ($criteria_names as $index => $criteria_name) {
                                    $kriteria_name = $kriteria[$index];
                                    echo "<div class='form-group'>";
                                    echo "<label for='edit_nilai_{$kd_ekskul}_{$criteria_name}'>{$kriteria_name}</label>";
                                    echo "<select class='form-control' id='edit_nilai_{$kd_ekskul}_{$criteria_name}' name='edit_nilai_{$kd_ekskul}_{$criteria_name}' required>";
                                    echo "<option value='1'>Sangat Kurang</option>";
                                    echo "<option value='2'>Kurang</option>";
                                    echo "<option value='3'>Cukup</option>";
                                    echo "<option value='4'>Baik</option>";
                                    echo "<option value='5'>Sangat Baik</option>";
                                    echo "</select>";
                                    echo "</div>";
                                }
                            }
                            ?>

                            <div id="edit_criteria_fields"></div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <input type="hidden" name="action" value="edit">
                        </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIqvC2f0fUAKwj4+V/niGNDK5pF2I1BIeZlTAAeIV5W5YMe/iH" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgEPgkjsA3MCpBw1phtFfme6B2ntzlZ+z3h5Kd69zoT7rTAIGx4" crossorigin="anonymous">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var kdSiswa = this.getAttribute('data-kd-siswa');

                // Menggunakan Fetch API untuk mengambil data siswa yang dipilih
                fetch('fetch_data.php?kd_siswa=' + kdSiswa, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data yang diterima:');
                        console.log(data);

                        // Mengisi nilai form dengan data yang diterima
                        document.getElementById('edit_kd_siswa').value = data.data.kd_siswa;
                        document.getElementById('edit_nama_siswa').value = data.data
                            .nm_siswa;

                        // Loop untuk nilai_kriteria dan mengisi input fields yang sesuai
                        // for (var ekskulId in data.data.nilai_kriteria) {
                        //     if (data.data.nilai_kriteria.hasOwnProperty(ekskulId)) {
                        //         var kriteriaSet = data.data.nilai_kriteria[ekskulId];
                        //         console.log(kriteriaSet);

                        //         for (var kriteriaId in kriteriaSet) {
                        //             if (kriteriaSet.hasOwnProperty(kriteriaId)) {
                        //                 var kriteria = kriteriaSet[kriteriaId];
                        //                 var getNamaKriteria = inputElement.setAttribute(
                        //                     'data-nama-kriteria', kriteria.nama_kriteria
                        //                     );
                        //                 console.log(getNamaKriteria);
                        //                 var inputName = 'nilai_' + ekskulId + '_' +
                        //                     getNamaKriteria;


                        //                 console.log(inputName);
                        //                 var inputElement = document.querySelector(
                        //                     '[name="' + inputName + '"]');

                        //                 if (inputElement) {
                        //                     inputElement.value = kriteria.nilai;
                        //                 }
                        //             }
                        //         }
                        //     }
                        // }
                        // Loop untuk nilai_kriteria dan mengisi input fields yang sesuai
                        for (var ekskulId in data.data.nilai_kriteria) {
                            if (data.data.nilai_kriteria.hasOwnProperty(ekskulId)) {
                                var kriteriaSet = data.data.nilai_kriteria[ekskulId];

                                for (var kriteriaId in kriteriaSet) {
                                    if (kriteriaSet.hasOwnProperty(kriteriaId)) {
                                        var kriteria = kriteriaSet[kriteriaId];
                                        var inputName = 'edit_nilai_' + ekskulId + '_' +
                                            kriteria
                                            .nama_kriteria;
                                        console.log(inputName);


                                        var inputElement = document.querySelector(
                                            '[name="' + inputName + '"]');
                                        console.log(inputElement);
                                        if (inputElement) {
                                            inputElement.value = kriteria.nilai;
                                            console.log(kriteria.nilai);

                                            inputElement.setAttribute('data-nama-kriteria',
                                                kriteria.nama_kriteria);
                                        }
                                    }
                                }
                            }
                        }

                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            });
        });
    });
</script>