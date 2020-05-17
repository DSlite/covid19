# EAS Pemrograman Integratif

Oleh: I Made Dindra Setyadharma (05311840000008)

---

## Setup

* Database terdapat pada link berikut: [Database](https://github.com/DSlite/covid19/blob/master/covid19.sql)
* Konfigurasi koneksi database terdapat pada link berikut: [Constants.php](https://github.com/DSlite/covid19/blob/master/app/core/Constants.php)

> *Note: untuk penjelasan kodingan sudah terdapat pada masing-masing kode program*

## Controllers

Disini, saya menggunakan satu controller yaitu [**`DonasiController`**](https://github.com/DSlite/covid19/blob/master/app/controllers/DonasiController.php). Dalam controller tersebut terdapat beberapa method:
* **`home()`**: digunakan untuk mengatur `$_SESSION` yang akan digunakan dan mengarahkan view yang digunakan jika belum mengisi dan sudah mengisi informasi donatur.
* **`rekap()`**: digunakan untuk mengatur rekapan yang akan ditampilkan. Rekapan yang ditampilkan bisa seluruh kategori atau berdasarkan kategori yang diinginkan.
* **`tambahData()`**: digunakan untuk menambahkan data pada `$_SESSION` kedalam database dan mengatur `FlashMessage` yang ditampilkan.
* **`deleteDonasi()`**: digunakan untuk menghilangkan entry `donasi` spesifik pada `$_SESSION`.
* **`destroy()`**: digunakan untuk menghilangkan data `$_SESSION`.

## Models

Disini, saya menggunakan dua model untuk masing-masing tabel, yaitu [**`Donasi`**](https://github.com/DSlite/covid19/blob/master/app/models/Donasi.php) dan [**`Kategori`**](https://github.com/DSlite/covid19/blob/master/app/models/Kategori.php).

Struktur dari tabel **`Donasi`** sebagai berikut:
* **`id`**: menyimpan id masing-masing donasi.
* **`id_transaksi`**: menyimpan id untuk masing-masing transaksi.
* **`donatur`**: menyimpan nama donatur.
* **`email_donatur`**: menyimpan alamat email donatur.
* **`id_kategori`**: menyimpan id dari kategori yang didonasikan (foreign key ke tabel **`Kategori`**).
* **`deskripsi`**: penjelasan mengenai barang yang didonasikan (misal uang, beras, masker, dll).
* **`kuantitas`**: kuantitas dari barang yang didonasikan (kalau uang dimasukkan nominal).
* **`date`**: menyimpan tanggal dan waktu transaksi.

Struktur dari tabel **`kategori`** sebagai berikut:
* **`id`**: menyimpan id kategori.
* **`nama_kategori`**: menyimpan nama kategori.

Pada model **`Donasi`** terdapat beberapa method:
* **`create()`**: digunakan memasukkan setiap data donasi tiap transaksi kedalam tabel sesuai dengan inputnya.
* **`getAll()`**: digunakan untuk mendapatkan seluruh entry pada tabel **`Donasi`** dengan mengambil `nama_kategori` pada tabel **`Kategori`**.
* **`getByCategory()`**: mirip dengan method `getAll()`, tetapi mengambil berdasarkan `id_kategori` yang diinputkan.
* **`getLatestIdTransaksi()`**: digunakan untuk mendapatkan `id_transaksi` terakhir pada tabel **`Donasi`**.

Pada model **`Kategori`** terdapat beberapa method:
* **`getById()`**: digunakan untuk mendapatkan `nama_kategori` berdasarkan `id` yang diinputkan.
* **`getAll()`**: digunakan untuk mendapatkan seluruh entry pada tabel **`Kategori`**.

## Views

Disini, saya menggunakan 3 view untuk beberapa fungsionalitas. View yang saya gunakan yaitu [**`index`**](https://github.com/DSlite/covid19/blob/master/app/views/donasi/index.html), [**`donasi`**](https://github.com/DSlite/covid19/blob/master/app/views/donasi/donasi.html), dan [**`rekap`**](https://github.com/DSlite/covid19/blob/master/app/views/donasi/rekap.html).

* **`index`**: digunakan untuk menambahkan informasi mengenai donatur (nama donatur dan alamat email). Berikut screenshot pada view **`index`**

![index](https://user-images.githubusercontent.com/17781660/82135010-968e9400-9830-11ea-81fb-243b5cd27fd7.png)

* **`donasi`**: digunakan untuk menambahkan data donasi yang dikirimkan oleh donatur. Berikut screenshot pada view **`donasi`**

![donasi](https://user-images.githubusercontent.com/17781660/82135035-d786a880-9830-11ea-906d-d2f3449d9710.png)
![donasi](https://user-images.githubusercontent.com/17781660/82135040-dc4b5c80-9830-11ea-9dac-32665e631586.png)
![donasi](https://user-images.githubusercontent.com/17781660/82135042-e2d9d400-9830-11ea-8261-455ac293b83a.png)
![donasi](https://user-images.githubusercontent.com/17781660/82135053-000ea280-9831-11ea-973c-6a61c0ab2a58.png)

* **`rekap`**: digunakan untuk melihat rekapan data donasi. Berikut screenshot pada view **`rekap`**

![rekap](https://user-images.githubusercontent.com/17781660/82135095-4401a780-9831-11ea-9bc2-1bbc29ebdbbe.png)
![rekap](https://user-images.githubusercontent.com/17781660/82135117-77dccd00-9831-11ea-87ff-f40e17a8b7cf.png)
![rekap](https://user-images.githubusercontent.com/17781660/82135098-46640180-9831-11ea-80ce-b660638f1a36.png)
