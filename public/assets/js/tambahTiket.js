import { getLayananById, postTiket } from "/assets/js/app.js";

document.addEventListener('DOMContentLoaded', () => {
    const layananSelect = document.querySelector('.layanan');

    const btnSubmit = document.querySelector('.btn-submit');
    if (btnSubmit) {
        btnSubmit.addEventListener('click', async (e) => {
            // Karena bukan form submit, tidak perlu preventDefault. Teman Anda akan lebih leluasa pasang SweetAlert di sini.
            btnSubmit.innerHTML = 'Loading...';
            btnSubmit.disabled = true;

            const judul = document.querySelector('#validationCustom01').value;
            const kategori = document.querySelector('.kategori').value;
            const layanan = document.querySelector('.layanan').value;
            const deskripsi = document.querySelector('#validationTextarea').value;
            const dokumenLampiran = document.querySelector('#inputGroupFile02');
            const file = dokumenLampiran.files ? dokumenLampiran.files[0] : null;

            if (!judul || !kategori || !layanan || !deskripsi) {
                alert("Mohon lengkapi semua isian terlebih dahulu.");
                btnSubmit.innerHTML = 'Submit form';
                btnSubmit.disabled = false;
                return;
            }

            const res = await postTiket(judul, kategori, layanan, deskripsi, file);
            
            if (res.status === 'success') {
                alert(res.message);
                window.location.href = '/tiket'; // Lempar ke halaman daftar tiket
            } else {
                alert(res.message || 'Gagal menambahkan tiket.');
            }

            btnSubmit.innerHTML = 'Submit form';
            btnSubmit.disabled = false;
        });
    }

    document.querySelector('.kategori').addEventListener('change', async (e) => {
        const idKategori = e.target.value;

        if (!idKategori) {
            return;
        }

        const data = await getLayananById(idKategori);

        if (data.status === 'success' && Array.isArray(data.data)) {
            data.data.forEach(layanan => {
                const opt = document.createElement('option');
                opt.value = layanan.id;
                opt.text = layanan.per_kategori_layanan;
                layananSelect.append(opt);
            });
        }
    });
});