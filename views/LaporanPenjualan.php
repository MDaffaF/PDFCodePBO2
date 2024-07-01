<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../koneksi/koneksi.php";
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <title>LAPORAN STOCK BARANG</title>

    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact; 
            }
            form, .btn {
                display: none !important;
            }
        }
        .center-logo {
            text-align: center;
            margin-top: -120px;
            margin-bottom: -80px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="center-logo">
        <img src="logo.png" alt="Logo" style="max-width: 300px;">
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center text-primary">Laporan Penjualan</h1>
            <br>
        </div>
    </div>
    <form method="post" class="form-inline justify-content-center mb-4">
        <div class="form-group mx-sm-3">
            <label for="dari" class="mr-2">Dari Tanggal</label>
            <input type="date" id="dari" name="dari" class="form-control">
        </div>
        <div class="form-group mx-sm-3">
            <label for="sampai" class="mr-2">Sampai</label>
            <input type="date" id="sampai" name="sampai" class="form-control">
        </div>
        <button type="submit" name="cek" class="btn btn-primary mr-2">Cek</button>
        <button type="button" name="print" class="btn btn-primary" onclick="printPage()">Print</button>
    </form>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>No Faktur</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Beli</th>
                    <th>Total Harga</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                    <th>Tanggal</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $where = '';
                if (isset($_POST['cek']) && !empty($_POST['dari']) && !empty($_POST['sampai'])) {
                    $dari = $_POST['dari'];
                    $sampai = $_POST['sampai'];
                    $where = "WHERE tanggal_masuk BETWEEN '$dari' AND '$sampai'";
                }

                $sql = "SELECT * FROM tbl_penjualan $where";
                $query = mysqli_query($con, $sql);

                if ($query) {
                    while ($r = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($r['id']); ?></td>
                            <td><?php echo htmlspecialchars($r['nofaktur']); ?></td>
                            <td><?php echo htmlspecialchars($r['kd_barang']); ?></td>
                            <td><?php echo htmlspecialchars($r['nama_barang']); ?></td>
                            <td><?php echo htmlspecialchars($r['hsatuan']); ?></td>
                            <td><?php echo htmlspecialchars($r['jumlah_beli']); ?></td>
                            <td><?php echo htmlspecialchars($r['jumlah_beli'] * $r['hsatuan']); ?></td>
                            <td><?php echo htmlspecialchars($r['bayar']); ?></td>
                            <td><?php echo htmlspecialchars($r['kembalian']); ?></td>
                            <td><?php echo htmlspecialchars($r['tgl']); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No data found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12 text-right">
            <p>Bandung, <span id="currentDate"></span></p>
            <p><br><br><br></p>
            <p>Pegawai</p>
        </div>
</div>

<script>
    function printPage() {
        window.print();
    }
    document.addEventListener('DOMContentLoaded', (event) => {
    const currentDate = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('currentDate').textContent = currentDate.toLocaleDateString('id-ID', options)
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

