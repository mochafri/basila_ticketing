const tokenCSRF = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

// --- TIKET SERVICE FUNCTIONS ---

async function getLayananById(id) {
    const res = await fetch(`/get-layanan/${id}`);
    const data = await res.json();
    return data;
}

async function getProdiById(id) {
    const res = await fetch(`/get-prodi/${id}`);
    const data = await res.json();
    return data;
}

async function postTiket(judul, kategori, layanan, deskripsi, dokumenLampiran, fakultas = null, prodi = null) {
    const formData = new FormData();
    formData.append('judul', judul);
    formData.append('kategori', kategori);
    formData.append('layanan', parseInt(layanan));
    formData.append('deskripsi', deskripsi);
    if(fakultas) formData.append('fakultas', fakultas);
    if(prodi) formData.append('prodi', prodi);
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
            const fakultasEl = document.querySelector('.fakultas-select');
            const prodiEl = document.querySelector('.prodi-select');
            
            const isLainnya = fakultasEl && fakultasEl.value === 'lainnya';
            const direktoratNama = isLainnya ? document.querySelector('#direktorat_nama').value : null;

            const fakultas = isLainnya ? direktoratNama : (fakultasEl ? fakultasEl.options[fakultasEl.selectedIndex].text : null);
            const prodi = isLainnya ? '-' : (prodiEl ? prodiEl.value : null);
            const dokumenLampiran = document.querySelector('#inputGroupFile02');
            const file = dokumenLampiran.files ? dokumenLampiran.files[0] : null;

            if (!kategori || !layanan || !deskripsi || (fakultasEl && !fakultas) || (!isLainnya && prodiEl && !prodi)) {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan!",
                    text: "Mohon lengkapi semua isian termasuk Fakultas/Unit dan Prodi jika diminta."
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
                    const res = await postTiket('', kategori, layanan, deskripsi, file, fakultas, prodi);

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

    // --- DYNAMIC PRODI LOGIC ---
    const fakultasSelect = document.querySelector('.fakultas-select');
    const prodiSelect = document.querySelector('.prodi-select');

    if (fakultasSelect && prodiSelect) {
        fakultasSelect.addEventListener('change', async (e) => {
            const idFakultas = e.target.value;
            const direktoratContainer = document.getElementById('direktorat-container');
            const prodiContainer = document.getElementById('prodi-container');

            if (idFakultas === 'lainnya') {
                direktoratContainer.style.display = 'block';
                prodiContainer.style.display = 'none';
                prodiSelect.innerHTML = '<option selected value="-">-</option>';
                prodiSelect.disabled = true;
                return;
            } else {
                direktoratContainer.style.display = 'none';
                prodiContainer.style.display = 'block';
            }
            
            prodiSelect.innerHTML = '<option selected disabled value="">Loading...</option>';
            prodiSelect.disabled = true;

            const data = await getProdiById(idFakultas);

            if (data && Array.isArray(data)) {
                prodiSelect.innerHTML = '<option selected disabled value="">Pilih Prodi...</option>';
                data.forEach(p => {
                    const opt = document.createElement('option');
                    // Gunakan nama sebagai value agar konsisten dengan data session yang biasanya string
                    const prodiName = p.studyprogramname ?? p.nama_prodi ?? p.NAMA_PRODI ?? p.study_program ?? p.STUDY_PROGRAM ?? p.name ?? p.NAME;
                    opt.value = prodiName;
                    opt.text = prodiName;
                    prodiSelect.add(opt);
                });
                prodiSelect.disabled = false;
            } else {
                prodiSelect.innerHTML = '<option selected disabled value="">Gagal memuat data</option>';
            }
        });
    }
});