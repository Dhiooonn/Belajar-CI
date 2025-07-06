<?= $this->extend('layout'); ?>

<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if ($validation->getErrors()) : ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Terdapat Kesalahan:</strong>
    <ul class="mb-0">
        <?php foreach ($validation->getErrors() as $error) : ?>
        <li><?= esc($error) ?></li>
        <?php endforeach ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>


<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg"></i> Tambah Data
</button>


<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal (Rp)</th>
            <th scope="col" style="width: 15%;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($diskon as $index => $d) : ?>
        <tr>
            <th scope="row"><?= $index + 1 ?></th>
            <td><?= date('d F Y', strtotime($d['tanggal'])); ?></td>
            <td><?= number_format($d['nominal'], 0, ',', '.'); ?></td>
            <td>
                <button type="button" class="btn btn-success btn-sm btn-edit" data-id="<?= $d['id']; ?>">
                    Ubah
                </button>
                <a href="<?= base_url('diskon/delete/' . $d['id']); ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    Hapus
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('diskon/store'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="<?= old('tanggal'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal (Rp)</label>
                        <input type="number" class="form-control" id="nominal" name="nominal"
                            placeholder="Contoh: 100000" value="<?= old('nominal'); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Diskon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="formEdit">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal_edit" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_edit" name="tanggal" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nominal_edit" class="form-label">Nominal (Rp)</label>
                        <input type="number" class="form-control" id="nominal_edit" name="nominal" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log("DEBUG: Halaman selesai dimuat. Script dijalankan.");

    // Definisikan elemen modal dan form di luar listener
    const modalEditEl = document.getElementById('modalEdit');
    if (!modalEditEl) {
        console.error("DEBUG ERROR: Elemen modal dengan ID 'modalEdit' tidak ditemukan!");
        return; // Hentikan script jika modal tidak ada
    }
    const modalEdit = new bootstrap.Modal(modalEditEl);

    const formEdit = document.getElementById('formEdit');
    const tanggalEditInput = document.getElementById('tanggal_edit');
    const nominalEditInput = document.getElementById('nominal_edit');

    console.log("DEBUG: Modal dan form berhasil diinisialisasi.");

    // Gunakan Event Delegation pada body dokumen
    document.body.addEventListener('click', function(event) {
        console.log("DEBUG: Sebuah klik terdeteksi di halaman.");

        // Cek apakah yang diklik adalah tombol "Ubah" dengan class .btn-edit
        if (event.target && event.target.classList.contains('btn-edit')) {
            console.log("DEBUG: Checkpoint 1 - Tombol .btn-edit BERHASIL diklik!");

            const button = event.target;
            const diskonId = button.getAttribute('data-id');
            console.log("DEBUG: Checkpoint 2 - Mendapatkan data-id:", diskonId);

            if (!diskonId) {
                console.error("DEBUG ERROR: Atribut 'data-id' kosong atau tidak ada pada tombol!");
                return;
            }

            // Setel URL action untuk form edit secara dinamis
            formEdit.action = `<?= base_url('diskon/update/') ?>${diskonId}`;
            console.log("DEBUG: Checkpoint 3 - Form action diubah menjadi:", formEdit.action);

            // Ambil data terbaru dari server
            console.log("DEBUG: Checkpoint 4 - Memulai proses fetch ke:",
                `<?= base_url('diskon/edit/') ?>${diskonId}`);
            fetch(`<?= base_url('diskon/edit/') ?>${diskonId}`)
                .then(response => {
                    console.log("DEBUG: Checkpoint 5 - Menerima respons dari server.", response);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("DEBUG: Checkpoint 6 - Data berhasil di-parse menjadi JSON.", data);

                    tanggalEditInput.value = data.tanggal;
                    nominalEditInput.value = data.nominal;
                    console.log("DEBUG: Checkpoint 7 - Form telah diisi dengan data baru.");

                    // Tampilkan modal
                    modalEdit.show();
                    console.log(
                        "DEBUG: Checkpoint 8 - Perintah modalEdit.show() telah dijalankan.");
                })
                .catch(error => {
                    // Blok ini akan menangkap error dari fetch atau parsing JSON
                    console.error('DEBUG FINAL ERROR:', error);
                    alert(
                        'Terjadi kesalahan saat mengambil data. Silakan cek console (F12) untuk melihat detail errornya.'
                    );
                });
        } else if (event.target) {
            // Log ini akan muncul jika Anda mengklik elemen lain selain tombol .btn-edit
            console.log("DEBUG: Anda mengklik elemen lain, bukan tombol .btn-edit. Elemen yang diklik:",
                event.target);
        }
    });
});
</script>

<?= $this->endSection(); ?>