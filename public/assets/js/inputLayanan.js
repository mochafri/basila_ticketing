import { postLayanan } from "/assets/js/app.js";

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.btn-layanan').addEventListener('click', async () => {
        const namaLayanan = document.querySelector('.layanan').value;
        const selectKategori = document.querySelector('.select-kategori').value;
        
        console.log('click');

        await postLayanan(namaLayanan, selectKategori);
    });
}); 