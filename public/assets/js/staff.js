import { uploadTask } from "/assets/js/app.js";

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

    const btnKirim = document.getElementById('btnKirimLaporan');
    if (btnKirim) {
        btnKirim.addEventListener('click', async () => {
            const laporanTask = document.querySelector('#formPenyelesaianTugas textarea').value;
            // Get the file
            const uploadFile = document.getElementById('uploadBukti').files[0];

            if (!laporanTask) {
                alert('Tolong isi form penyelesaian tugas secara mendetail!');
                return;
            }

            btnKirim.innerHTML = 'Loading...';
            btnKirim.disabled = true;

            const res = await uploadTask(parseSlug, uploadFile, laporanTask);
            alert(res.message || 'Berhasil mengunggah laporan tugas');
            location.reload();
        });
    }
});