# Penjelasan Aplikasi Manajemen Data Menu

## Deskripsi
Aplikasi ini adalah sistem berbasis PHP untuk mengelola data menu, yang mencakup fitur penambahan, pengeditan, penghapusan, dan tampilan data dalam bentuk tabel. Aplikasi ini memungkinkan pengguna untuk mengelola menu dengan mudah, serta memastikan bahwa urutan ID pada menu tetap berurutan meskipun ada data yang dihapus.

## Fitur Aplikasi
1. **Menambah Data Menu**: Pengguna dapat menambahkan data menu baru dengan mengisi nama menu, harga, dan foto menu (opsional). Harga yang dimasukkan otomatis diformat dengan tanda titik sebagai pemisah ribuan (misalnya, "10.000").
2. **Mengedit Data Menu**: Pengguna dapat mengedit data menu yang sudah ada, termasuk foto, harga, dan nama menu.
3. **Menghapus Data Menu**: Pengguna dapat menghapus data menu berdasarkan ID. Setelah data dihapus, ID lainnya akan di-reset sehingga urutannya tetap berkelanjutan dan tidak ada celah pada urutan ID.
4. **Menampilkan Data Menu**: Semua data menu yang ada akan ditampilkan dalam sebuah tabel yang terorganisir berdasarkan tanggal dibuatnya menu. Setiap baris pada tabel menunjukkan ID, foto menu, nama menu, harga, tanggal pembuatan, dan tanggal pembaruan terakhir.

## Cara Kerja Aplikasi

### 1. **Menambah Data Menu**
   - Pengguna mengakses halaman untuk menambah data (`tambah_data.php`).
   - Formulir input menerima data seperti nama menu, harga, dan foto (opsional).
   - Jika foto diunggah, file gambar disimpan di folder `uploads` dan path-nya disimpan di database.
   - Setelah pengguna mengklik "Tambah Data", data disimpan ke dalam tabel `menu` di database menggunakan query SQL `INSERT INTO`.

### 2. **Mengedit Data Menu**
   - Pengguna dapat memilih menu yang ingin diedit dari daftar menu di halaman utama (`index.php`).
   - Pengguna dapat mengubah nama menu, harga, dan foto menu (jika ada) dan kemudian menyimpan perubahan tersebut.
   - Pembaruan data dilakukan dengan query SQL `UPDATE`.

### 3. **Menghapus Data Menu**
   - Pengguna dapat menghapus data menu dari halaman utama. Setiap menu memiliki tombol **Hapus** yang memungkinkan pengguna untuk menghapus menu berdasarkan ID.
   - Setelah data dihapus, ID lainnya akan di-reset agar tetap berurutan menggunakan query SQL `ALTER TABLE`.
   - Proses penghapusan menggunakan query SQL `DELETE FROM`.

### 4. **Menampilkan Data Menu**
   - Data yang sudah ada ditampilkan dalam bentuk tabel yang dikelompokkan berdasarkan tanggal pembuatan menu.
   - Tabel ini menampilkan informasi seperti ID, foto menu (jika ada), nama menu, harga, tanggal dibuat, dan tanggal terakhir diperbarui.
   - Setiap harga menu akan diformat menggunakan fungsi PHP `number_format()` untuk menampilkan angka dengan format yang benar (misalnya, "10.000").

## Cara Reset ID Setelah Penghapusan
Untuk memastikan urutan ID tetap konsisten setelah penghapusan data, aplikasi ini menggunakan query SQL `ALTER TABLE` yang mengatur ulang urutan AUTO_INCREMENT setelah data dihapus. Dengan begitu, ID berikutnya tidak akan ada celah meskipun ada data yang dihapus.

## Struktur Database

    Aplikasi ini menggunakan tabel menu yang memiliki kolom-kolom berikut:

    1. id: Kolom ini merupakan primary key dengan tipe INT dan menggunakan AUTO_INCREMENT agar ID secara otomatis bertambah setiap kali data baru ditambahkan.
    2. foto_menu: Kolom ini menyimpan path ke file gambar menu (opsional).
    3. menu: Kolom ini menyimpan nama menu.
    4. harga: Kolom ini menyimpan harga menu.
    5. created_at: Kolom ini menyimpan tanggal dan waktu menu ditambahkan.
    6. updated_at: Kolom ini menyimpan tanggal dan waktu menu terakhir kali diperbarui.

### Langkah-langkah Umum dalam Aplikasi 

1. Tambah Data: Formulir input mengumpulkan nama menu, harga, dan foto (jika ada).
Data disimpan di database menggunakan query INSERT INTO.

2. Edit Data: Pengguna memilih menu yang ingin diedit dan mengubah data menu, kemudian disimpan menggunakan query UPDATE.

3. Hapus Data: Pengguna menghapus data dengan memilih menu berdasarkan ID. Setelah penghapusan, ID ID lainnya diatur ulang menggunakan ALTER TABLE.

4. Tampilkan Data: Semua data menu yang ada ditampilkan dalam tabel di halaman utama.
Data dikelompokkan berdasarkan tanggal pembuatan.

# Lisensi

Aplikasi ini menggunakan lisensi **MIT License**.

## Hak Cipta (Copyright)

Copyright (c) 2024 Abdul Kuswardanu

## Lisensi MIT

Izinkan orang lain untuk menggunakan, menyalin, memodifikasi, menggabungkan, menerbitkan, mendistribusikan, memindahkan, atau menjual salinan perangkat lunak ini, dengan atau tanpa modifikasi, dengan ketentuan bahwa pemberitahuan hak cipta dan pernyataan lisensi ini dimasukkan dalam semua salinan perangkat lunak tersebut.

### Ketentuan

Perangkat lunak ini diberikan "sebagaimana adanya", tanpa jaminan apapun, baik yang tersurat maupun tersirat, termasuk namun tidak terbatas pada jaminan atas kelayakan jual, kecocokan untuk tujuan tertentu, atau tidak adanya pelanggaran. Dalam hal apapun, pengarang atau pemegang hak cipta tidak bertanggung jawab atas klaim, kerusakan, atau kewajiban lainnya, baik dalam tindakan kontrak, gugatan perdata, atau sebaliknya, yang timbul dari, keluar dari, atau terkait dengan perangkat lunak ini atau penggunaan atau transaksi lainnya dalam perangkat lunak ini.

## Pemberian Lisensi

Lisensi ini memberikan izin untuk:
- Menggunakan perangkat lunak ini secara gratis untuk penggunaan pribadi atau komersial.
- Memodifikasi perangkat lunak dan mendistribusikan versi modifikasi.
- Menyertakan perangkat lunak ini dalam proyek lain, baik yang bersifat open-source atau proprietary.

Namun, jika Anda menggunakan atau mendistribusikan perangkat lunak ini, Anda harus menyertakan pemberitahuan hak cipta dan lisensi ini di dalam perangkat lunak tersebut.