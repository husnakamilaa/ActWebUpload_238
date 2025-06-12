<?php
$target_dir = "uploads/";

// Aksi hapus jika ada parameter delete
if (isset($_GET['delete'])) {
    $file = basename($_GET['delete']);
    $filePath = $target_dir . $file;
    if (file_exists($filePath)) unlink($filePath);
}

// Aksi upload
if (isset($_POST["submit"])) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES["fileToUpload"]["size"] > 500000) { echo "<p class='error'>Ukuran file terlalu besar.</p>"; $uploadOk = 0; }
    $allowed = ["jpg","jpeg","png","gif"];
    if (!in_array($fileType, $allowed)) { echo "<p class='error'>Hanya gambar (jpg/jpeg/png/gif) diizinkan.</p>"; $uploadOk = 0; }

    if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        echo "<p class='success'>File <b>" . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . "</b> berhasil diunggah.</p>";
    elseif ($uploadOk) echo "<p class='error'>Gagal mengunggah file.</p>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Galeri Upload</title>
<style>
  body { font-family: Arial, sans-serif; background:#D1D8BE; margin:0; padding:20px; }
  .container { max-width:800px; margin:auto; background:#EEEFE0; padding:20px; border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);}
  h2 { text-align:center; color:#333; }
  .msg { padding:10px; border-radius:6px; margin-bottom:15px; }
  .success { background:#d4edda; color:#155724; }
  .error { background:#f8d7da; color:#721c24; }
  .actions { text-align:right; margin-bottom:20px; }
  .actions a { display:inline-block; background:#819A91; color:white;
    padding:8px 14px; margin-left:8px; border-radius:6px; text-decoration:none;
    transition: background 0.3s; }
  .actions a:hover { background:#657b73; }
  .gallery { display: flex; flex-direction: column; gap: 15px; }
.item { display: flex; align-items: center; gap: 20px; background: #f9f9f9; padding: 10px; border-radius: 8px; }
.item img { width: 100px; height: auto; border-radius: 6px; }
.file-name { flex: 1; font-weight: bold; color: #333; }
  .item .btn { display:block; margin:4px 0; background:#28a745; color:white;
    padding:6px 10px; border:none; border-radius:6px; text-decoration:none;
    transition: background 0.3s; }
  .item .btn:hover { background:#218838; }
  .item .btn.delete { background:#dc3545; }
  .item .btn.delete:hover { background:#c82333; }
</style>
</head>
<body>

<div class="container">
  <h2>Daftar File Unggahanmu!</h2>

  <div class="actions">
    <a href="index.html">Kembali</a>
  </div>

  <?php
    $files = array_diff(scandir($target_dir), ['.','..']);
    if (empty($files)) {
      echo "<p>Tidak ada file.</p>";
    } else {
      echo "<div class='gallery'>";
      foreach ($files as $file) {
        $url = $target_dir . urlencode($file);
        echo "<div class='item'>";
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file))
        echo "<img src='$url' alt='$file'>";
        else
        echo "<div class='file-name'>$file</div>";
        echo "<div class='file-name'>$file</div>";
        echo "<a class='btn' href='$url' download>Download</a>";
        echo "<a class='btn delete' href='upload.php?delete=" . urlencode($file) . "' onclick=\"return confirm('Yakin hapus $file?')\">Hapus</a>";
        echo "</div>";
      }
      echo "</div>";
    }
  ?>
</div>

</body>
</html>
