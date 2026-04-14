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
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Tolong isi form penyelesaian tugas secara mendetail!'
                });
                return;
            }

            btnKirim.innerHTML = 'Loading...';
            btnKirim.disabled = true;

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Anda akan mengirim laporan penyelesaian tugas ini.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, kirim!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await uploadTask(parseSlug, uploadFile, laporanTask);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message || 'Berhasil mengunggah laporan tugas',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal mengunggah laporan tugas'
                        });
                        btnKirim.innerHTML = 'Kirim Laporan';
                        btnKirim.disabled = false;
                    }
                } else {
                    btnKirim.innerHTML = 'Kirim Laporan';
                    btnKirim.disabled = false;
                }
            });
        });
    }
});