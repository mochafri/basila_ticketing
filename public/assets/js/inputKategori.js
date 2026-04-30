const tokenCSRF = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

// --- MASTER SERVICE FUNCTIONS ---

async function postKategori(namaKategori, deskripsi) {
    const res = await fetch('/create-kategori', {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            nama_kategori: namaKategori,
            deskripsi: deskripsi
        })
    });

    return await res.json();
}

document.addEventListener('DOMContentLoaded', () => {
    const btnKategori = document.querySelector('.btn-kategori');
    if (btnKategori) {
        btnKategori.addEventListener('click', async () => {
        const namaKategori = document.querySelector('#inputKategori').value;
        const deskripsi = document.querySelector('#inputDeskripsi').value;

        if (!namaKategori) {
            return Swal.fire('Error', 'Nama kategori tidak boleh kosong', 'error');
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin menambahkan kategori "${namaKategori}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await postKategori(namaKategori, deskripsi);
                if (response.status === 'success') {
                    Swal.fire('Berhasil!', 'Kategori berhasil ditambahkan', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', response.message || 'Gagal menambahkan kategori', 'error');
                }
            }
        });
    });
}
}); 