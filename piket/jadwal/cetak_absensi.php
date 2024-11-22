<?php
require_once '../helper/connection.php';
require_once '../../TCPDF/tcpdf.php'; // Pastikan path ini benar

// Ambil jadwal_id dari parameter GET
$jadwal_id = isset($_GET['jadwal_id']) ? intval($_GET['jadwal_id']) : 0;

// Query untuk mendapatkan data absensi
$result_absensi = mysqli_query($connection, "
    SELECT 
        a.tanggal, 
        g.nama AS guru_nama,
        j.mata_pelajaran,
        SUM(CASE WHEN a.status_kehadiran = 'Tidak Hadir' THEN 1 ELSE 0 END) AS jumlah_tidak_hadir,
        SUM(CASE WHEN a.status_kehadiran = 'Izin' THEN 1 ELSE 0 END) AS jumlah_izin,
        SUM(CASE WHEN a.status_kehadiran = 'Sakit' THEN 1 ELSE 0 END) AS jumlah_sakit,
        GROUP_CONCAT(CASE WHEN a.status_kehadiran = 'Tidak Hadir' THEN CONCAT(s.nis, ': ', s.nama) END ORDER BY s.nis ASC SEPARATOR ', ') AS siswa_tidak_hadir,
        GROUP_CONCAT(CASE WHEN a.status_kehadiran = 'Izin' THEN CONCAT(s.nis, ': ', s.nama) END ORDER BY s.nis ASC SEPARATOR ', ') AS siswa_izin,
        GROUP_CONCAT(CASE WHEN a.status_kehadiran = 'Sakit' THEN CONCAT(s.nis, ': ', s.nama) END ORDER BY s.nis ASC SEPARATOR ', ') AS siswa_sakit
    FROM absensi a
    JOIN siswa s ON a.siswa_id = s.id_siswa
    JOIN guru g ON a.guru_id = g.id_guru
    JOIN jadwal j ON a.jadwal_id = j.id_jadwal
    WHERE a.jadwal_id = $jadwal_id 
    GROUP BY a.tanggal, g.nama, j.mata_pelajaran
");

if (!$result_absensi) {
    die("Query Error: " . mysqli_error($connection));
}

// Inisialisasi TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Absensi');
$pdf->SetTitle('Laporan Absensi Siswa');
$pdf->SetHeaderData('', 0, 'Laporan Absensi Siswa', "Mata Pelajaran: " . htmlspecialchars($result_absensi->fetch_assoc()['mata_pelajaran']));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Judul
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Laporan Absensi Siswa', 0, 1, 'C');
$pdf->Ln(5);

// Tabel Header
$pdf->SetFont('helvetica', '', 10);
$html = '
<table border="1" cellpadding="5">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="width:5%;">No</th>
            <th style="width:15%;">Tanggal</th>
            <th style="width:20%;">Guru</th>
            <th style="width:10%;">Tidak Hadir</th>
            <th style="width:10%;">Izin</th>
            <th style="width:10%;">Sakit</th>
            <th style="width:30%;">Nama Siswa</th>
        </tr>
    </thead>
    <tbody>';

// Mengisi Tabel dengan Data Absensi
$no = 1;
mysqli_data_seek($result_absensi, 0); // Reset pointer hasil query
while ($absensi = mysqli_fetch_assoc($result_absensi)) {
    // Sub-tabel untuk Nama Siswa per kategori
    $siswa_tidak_hadir_list = !empty($absensi['siswa_tidak_hadir']) ? explode(', ', $absensi['siswa_tidak_hadir']) : [];
    $siswa_izin_list = !empty($absensi['siswa_izin']) ? explode(', ', $absensi['siswa_izin']) : [];
    $siswa_sakit_list = !empty($absensi['siswa_sakit']) ? explode(', ', $absensi['siswa_sakit']) : [];

    // Menyiapkan konten sub-tabel dengan nama siswa di bawah kategori
    $siswa_nama_html = '<table cellpadding="3" border="0">';
    
    if (count($siswa_tidak_hadir_list) > 0) {
        $siswa_nama_html .= '<tr><td><strong>Tidak Hadir:</strong></td></tr>';
        foreach ($siswa_tidak_hadir_list as $index => $siswa) {
            $siswa_nama_html .= '<tr><td>' . ($index + 1) . '. ' . htmlspecialchars($siswa) . '</td></tr>';
        }
    } else {
        $siswa_nama_html .= '<tr><td><strong>Tidak Hadir:</strong></td><td>-</td></tr>';
    }

    if (count($siswa_izin_list) > 0) {
        $siswa_nama_html .= '<tr><td><strong>Izin:</strong></td></tr>';
        foreach ($siswa_izin_list as $index => $siswa) {
            $siswa_nama_html .= '<tr><td>' . ($index + 1) . '. ' . htmlspecialchars($siswa) . '</td></tr>';
        }
    } else {
        $siswa_nama_html .= '<tr><td><strong>Izin:</strong></td><td>-</td></tr>';
    }

    if (count($siswa_sakit_list) > 0) {
        $siswa_nama_html .= '<tr><td><strong>Sakit:</strong></td></tr>';
        foreach ($siswa_sakit_list as $index => $siswa) {
            $siswa_nama_html .= '<tr><td>' . ($index + 1) . '. ' . htmlspecialchars($siswa) . '</td></tr>';
        }
    } else {
        $siswa_nama_html .= '<tr><td><strong>Sakit:</strong></td><td>-</td></tr>';
    }

    $siswa_nama_html .= '</table>';

    $html .= '
        <tr>
            <td style="width:5%;">' . $no++ . '</td>
            <td style="width:15%;">' . htmlspecialchars($absensi['tanggal']) . '</td>
            <td style="width:20%;">' . htmlspecialchars($absensi['guru_nama']) . '</td>
            <td style="width:10%;">' . $absensi['jumlah_tidak_hadir'] . '</td>
            <td style="width:10%;">' . $absensi['jumlah_izin'] . '</td>
            <td style="width:10%;">' . $absensi['jumlah_sakit'] . '</td>
            <td style="width:30%;">' . $siswa_nama_html . '</td>
        </tr>';
}

$html .= '</tbody></table>';

// Output Tabel ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$pdf->Output('Laporan_Absensi_Siswa.pdf', 'I');
?>
