import { postKategori } from "./app.js";

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.btn-kategori').addEventListener('click', async () => {
        const namaKategori = document.querySelector('.kategori').value;
        
        await postKategori(namaKategori);
        location.reload();
    });
}); 