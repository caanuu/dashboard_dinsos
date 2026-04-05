

JUDUL: Implementasi SIKASOS Berbasis Web dengan Framework Laravel pada Dinas Sosial Kota Tebing Tinggi
maka konsep sistem beserta **alur interaksi antar role** bisa dibuat seperti ini:

---

## **Konsep Sistem: SIKASOS (Sistem Informasi Kesejahteraan Sosial)**

### 1. **Tujuan Sistem**

* Mempermudah digitalisasi pelayanan kesejahteraan sosial di Dinas Sosial Kota Tebing Tinggi.
* Mempercepat proses pengajuan dan verifikasi bantuan sosial.
* Menyediakan data penerima bantuan yang terpusat dan real-time.
* Memberikan transparansi kepada masyarakat mengenai status pengajuan bantuan.

---

### 2. **Role Pengguna**

Role: Admin/Petugas

Fungsi / Hak Akses:

- Mengelola pengajuan bantuan (verifikasi, approve/reject)
- Mengupdate data lapangan
- Mengelola data penerima bantuan
- Melihat laporan dan statistik
- Mengirim notifikasi kepada masyarakat


Role:Masyarakat / Penerima Bantuan


Fungsi / Hak Akses:
- Mengajukan bantuan sosial
- Upload dokumen pendukung
- Melacak status pengajuan
- Menerima notifikasi status pengajuan
---


### 3. **Fitur Sistem**

1. **Autentikasi Pengguna**

   * Login & register (Admin/Petugas dan Masyarakat)
   * Reset password via email

2. **Pengajuan Bantuan Sosial (Masyarakat)**

   * Form pengajuan bantuan online
   * Upload dokumen pendukung (KTP, KK, foto pendukung)
   * Status pengajuan: Pending → Diverifikasi → Disetujui / Ditolak

3. **Verifikasi & Approval (Admin/Petugas)**

   * Admin/Petugas menerima notifikasi pengajuan baru
   * Memeriksa kelengkapan dokumen dan validitas data
   * Approve / Reject pengajuan → update status real-time

4. **Manajemen Data Penerima Bantuan**

   * Admin/Petugas dapat melihat, mencari, dan memfilter data penerima bantuan berdasarkan kategori, lokasi, jenis bantuan

5. **Laporan & Statistik**

   * Dashboard menampilkan jumlah pengajuan, pengajuan disetujui, laporan bulanan
   * Export laporan ke PDF / Excel

6. **Notifikasi & Reminder**

   * Notifikasi untuk pengajuan baru dan status pengajuan
   * Reminder masyarakat untuk melengkapi dokumen jika kurang

---

### 4. **Alur Sistem (Flow Sederhana)**

**Langkah-langkah interaksi antar role:**

1. **Masyarakat**:

   * Masuk/login → Mengisi formulir pengajuan → Upload dokumen → Submit

2. **Admin/Petugas**:

   * Menerima notifikasi pengajuan baru
   * Membuka detail pengajuan → Verifikasi dokumen → Approve / Reject
   * Update status pengajuan di sistem → Notifikasi terkirim ke masyarakat

3. **Masyarakat**:

   * Menerima notifikasi status pengajuan
   * Jika disetujui → Bantuan dicairkan
   * Jika ditolak → Masyarakat bisa mengajukan ulang atau melengkapi dokumen

4. **Admin/Petugas**:

   * Melihat laporan dan statistik bantuan yang sudah disetujui / ditolak
   * Export laporan untuk evaluasi bulanan

---

### 5. **Diagram Alur Sistem (Deskripsi)**

```
[Masyarakat]
   |
   |--> Login / Register
   |--> Ajukan Bantuan
   |--> Upload Dokumen
   |--> Submit
   v
[Admin/Petugas]
   |
   |--> Menerima Notifikasi Pengajuan Baru
   |--> Verifikasi & Approve / Reject
   |--> Update Status Pengajuan
   v
[Masyarakat]
   |
   |--> Menerima Notifikasi Status Pengajuan
   |--> Proses Bantuan (Jika Disetujui)
   
[Admin/Petugas]
   |
   |--> Monitoring Dashboard & Statistik
   |--> Export Laporan
```

---

* **Storage**: Laravel Storage untuk dokumen pendukung
* **Notifikasi**: Laravel Notifications (email & dashboard)
* **Export Laporan**: Laravel-Dompdf


