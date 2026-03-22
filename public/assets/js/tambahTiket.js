import { postTiket, getLayanan } from "./app.js";

document.addEventListener('DOMContentLoaded', () => {
    const layananSelect = document.querySelector('#layanan');

    document.querySelector('.btn-submit').addEventListener('click', async () => {
        const judul = document.querySelector('#judul').value;
        const kategori = document.querySelector('#kategori').value;
        const layanan = document.querySelector('#layanan').value;
        const deskripsi = document.querySelector('#deskripsi').value;
        const dokumenLampiran = document.querySelector('#input-file-dokumen');
        const file = dokumenLampiran.files[0];

        await postTiket(judul, kategori, layanan, deskripsi, file);
    });

    document.querySelector('#kategori').addEventListener('change', async (e) => {
        const idKategori = e.target.value;

        if (!idKategori) {
            return;
        }

        const data = await getLayanan(idKategori);
        console.log(data);

        if (data.status === 'success' || Array.isArray(data.data)) {
            data.data.forEach(layanan => {
                const opt = document.createElement('option');
                opt.value = layanan.id;
                opt.text = layanan.per_kategori_layanan;
                layananSelect.append(opt);
            });
        }
    });
});