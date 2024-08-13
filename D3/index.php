<?php
// Path ke gambar asli dan gambar watermark
$sourceFile = 'images.jpg'; // Gambar asli
$watermarkFile = 'apple.png'; // Gambar watermark

// Muat gambar asli
$sourceImage = imagecreatefromjpeg($sourceFile);
if (!$sourceImage) {
    die('Gagal memuat gambar asli.');
}

// Muat gambar watermark
$watermarkImage = imagecreatefrompng($watermarkFile);
if (!$watermarkImage) {
    die('Gagal memuat watermark.');
}

// Ambil ukuran gambar asli dan watermark
$sourceWidth = imagesx($sourceImage);
$sourceHeight = imagesy($sourceImage);
$watermarkWidth = imagesx($watermarkImage);
$watermarkHeight = imagesy($watermarkImage);

// Tentukan posisi watermark (misalnya, kanan bawah)
$x = $sourceWidth - $watermarkWidth - 10; // Jarak dari sisi kanan
$y = $sourceHeight - $watermarkHeight - 10; // Jarak dari sisi bawah

// Tambahkan watermark ke gambar asli
imagecopy($sourceImage, $watermarkImage, 230, 0, 0, 0, $watermarkWidth, $watermarkHeight);


header('Content-Type: image/png');

// Hapus gambar dari memori
imagepng($sourceImage);
imagedestroy($sourceImage);
?>
