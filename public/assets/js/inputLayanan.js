import { postLayanan } from "/assets/js/app.js";

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.btn-layanan').addEventListener('click', async () => {
        const namaLayanan = document.querySelector('.layanan').value;
        const selectKategori = document.querySelector('.select-kategori').value;

        if (!namaLayanan) {
            return Swal.fire('Error', 'Nama layanan tidak boleh kosong', 'error');
        }

        if (!selectKategori || selectKategori === 'PILIH KATEGORI TUJUAN') {
            return Swal.fire('Error', 'Silahkan pilih kategori terlebih dahulu', 'error');
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin menambahkan layanan "${namaLayanan}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await postLayanan(namaLayanan, selectKategori);
                if (response.status === 'success') {
                    Swal.fire('Berhasil!', 'Layanan berhasil ditambahkan', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', response.message || 'Gagal menambahkan layanan', 'error');
                }
            }
        });
    });
}); 