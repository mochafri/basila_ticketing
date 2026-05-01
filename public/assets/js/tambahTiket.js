const tokenCSRF = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

// --- TIKET SERVICE FUNCTIONS ---

async function getLayananById(id) {
    const res = await fetch(`/get-layanan/${id}`);
    const data = await res.json();
    return data;
}

async function postTiket(judul, kategori, layanan, deskripsi, dokumenLampiran) {
    const formData = new FormData();
    formData.append('judul', judul);
    formData.append('kategori', kategori);
    formData.append('layanan', parseInt(layanan));
    formData.append('deskripsi', deskripsi);
    if(dokumenLampiran) formData.append('lampiran_dokumen', dokumenLampiran);

    const res = await fetch('/create-tiket', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: formData
    });

    return await res.json();
}

document.addEventListener('DOMContentLoaded', () => {
    const layananSelect = document.querySelector('.layanan');

    const btnSubmit = document.querySelector('.btn-submit');
    if (btnSubmit) {
        btnSubmit.addEventListener('click', async (e) => {
            // Karena bukan form submit, tidak perlu preventDefault. Teman Anda akan lebih leluasa pasang SweetAlert di sini.
            btnSubmit.innerHTML = 'Loading...';
            btnSubmit.disabled = true;

            const kategori = document.querySelector('.kategori').value;
            const layanan = document.querySelector('.layanan').value;
            const deskripsi = document.querySelector('#validationTextarea').value;
            const dokumenLampiran = document.querySelector('#inputGroupFile02');
            const file = dokumenLampiran.files ? dokumenLampiran.files[0] : null;

            if (!kategori || !layanan || !deskripsi) {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan!",
                    text: "Mohon lengkapi semua isian terlebih dahulu."
                });
                btnSubmit.innerHTML = 'Submit form';
                btnSubmit.disabled = false;
                return;
            }

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Anda akan membuat tiket baru dengan data ini.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, ajukan!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await postTiket('', kategori, layanan, deskripsi, file);

                    if (res.status === 'success') {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/tiket';
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: res.message || "Gagal menambahkan tiket."
                        });
                        btnSubmit.innerHTML = 'Submit form';
                        btnSubmit.disabled = false;
                    }
                } else {
                    btnSubmit.innerHTML = 'Submit form';
                    btnSubmit.disabled = false;
                }
            });
        });
    }

    const kategoriSelect = document.querySelector('.kategori');
    if (kategoriSelect) {
        kategoriSelect.addEventListener('change', async (e) => {
            const idKategori = e.target.value;

            if (!idKategori) {
                return;
            }

            const data = await getLayananById(idKategori);

            if (data.status === 'success' && Array.isArray(data.data) && layananSelect) {
                layananSelect.innerHTML = '<option value="" selected disabled>-- Pilih Layanan --</option>';
                data.data.forEach(layanan => {
                    const opt = document.createElement('option');
                    opt.value = layanan.id;
                    opt.text = layanan.per_kategori_layanan;
                    layananSelect.append(opt);
                });
            }
        });
    }
});