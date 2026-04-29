import { postKategori } from "/assets/js/app.js";

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.btn-kategori').addEventListener('click', async () => {
        const namaKategori = document.querySelector('.kategori').value;
        
        await postKategori(namaKategori);
    });
}); 