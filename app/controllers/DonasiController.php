<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Donasi;
use App\Models\Kategori;
use App\Core\FlashMessage;

class DonasiController {

    // Method Home untuk mengatur ketika masuk ke /donasi
    public function home($params) {
        // Jika terdapat $_POST untuk data donatur dan email_donatur, akan dimasukkan kedalam session
        if (isset($_POST['donatur']) && isset($_POST['email_donatur'])) {
            $_SESSION['donatur'] = $_POST['donatur'];
            if ($_POST['donatur'] == "") {
                $_SESSION['donatur'] = "Anonymous";
            } else {
                $_SESSION['donatur'] = $_POST['donatur'];
            }
            if ($_POST['email_donatur'] == "") {
                $_SESSION['email_donatur'] = "Anonymous";
            } else {
                $_SESSION['email_donatur'] = $_POST['email_donatur']; 
            }
        }

        // Jika terdapat $_POST untuk informasi donasi, maka informasi donasi akan dipush kedalam $_SESSION['donasi'] dalam bentuk array
        if (isset($_POST['id_kategori']) && isset($_POST['deskripsi']) && isset($_POST['kuantitas'])) {
            array_push($_SESSION['donasi'], array("id_kategori" => $_POST['id_kategori'], "deskripsi" => $_POST['deskripsi'], "kuantitas" => $_POST['kuantitas']));
        }

        // Set array $_SESSION['donasi'] jika belum ada
        if (!isset($_SESSION['donasi'])) {
            $_SESSION['donasi'] = array();
        }

        // Jika informasi donatur belum di set, maka akan menampilkan view "index.html". Jika sudah akan menampilkan view "donasi.html" dengan data data yang terdapat $_SESSION 
        if (!isset($_SESSION['donatur'])) {
            View::render("donasi/index.html");
        } else {
            $donasiArr = $_SESSION['donasi'];
            foreach ($donasiArr as &$donasi) {
                $donasi = array_merge($donasi, array("nama_kategori"=>Kategori::getById($donasi["id_kategori"])["nama_kategori"]));                
            }

            View::render("donasi/donasi.html", [
                "donatur" => $_SESSION['donatur'],
                "donasiArr" => $donasiArr,
                "kategoriArr" => Kategori::getAll()
            ]);
        }
    }

    // Method untuk mengatur rekap
    public function rekap($params) {
        // Jika pada parameter ke-0 tidak terdapat data, maka akan menampilkan semua kategori
        if (!isset($params[0])) {
            $data = Donasi::getAll();
            $judul = "Semua Kategori";
        } else { // Jika terdapat parameter, maka akan dicari data sesuai dengan id_kategori dari parameter ke-0
            $data = Donasi::getByCategory($params[0]);
            $judul = Kategori::getById($params[0])["nama_kategori"];
        }
        $kategori = Kategori::getAll();
        // Lalu akan menampilkan view "rekap.html"
        View::render("donasi/rekap.html", [
            "dataArr" => $data,
            "kategoriArr" => $kategori,
            "judul" => $judul
        ]);
    }

    // Method untuk menambahkan data transaksi kedalam database
    public function tambahData() {
        // Jika terdapat $_SESSION['donasi'], maka data pada $_SESSION akan dimasukkan kedalam database menggunakan model "Donasi". Lalu session akan diset ulang dan akan mengset FlashMessage  yang sesuai
        if (isset($_SESSION['donasi'])) {
            if (Donasi::create($_SESSION) > 0) {
                session_destroy();
                session_start();
                FlashMessage::setFlash('Berhasil', 'Ditambahkan', 'success');
            } else {
                FlashMessage::setFlash('Gagal', 'Ditambahkan', 'danger');
            }
        }
        // Redirect ke url awal
        header('Location:' . BASE_URL . '/donasi/home');
    }

    // Method untuk menghapus satu entry donasi
    public function deleteDonasi($param) {
        // Entry pada $_SESSION['donasi'] akan diunset()
        unset($_SESSION['donasi'][$param[0]]);
        // Redirect ke url awal
        header('Location:'. BASE_URL . '/donasi/home');
    }

    // Method untuk menghapus session
    public function destroy() {
        // Menghapus session
        session_destroy();
        // Redirect ke url awal
        header('Location:' . BASE_URL . '/donasi/home');
    }
}

?>