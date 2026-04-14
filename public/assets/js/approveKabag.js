import { reject, escalated, approveTiket, closeTicket } from "./app.js";

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

    const btnReject = document.querySelector('.btn-reject');
    if (btnReject) {
        btnReject.addEventListener('click', async () => {
            btnReject.innerHTML = 'Loading...';
            btnReject.disabled = true;
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin menolak tiket ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, tolak!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await reject(parseSlug);
                    if (res.status === 'success' || res.status === 201 || res.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message || 'Tiket berhasil direject',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal mereject tiket'
                        });
                        btnReject.innerHTML = 'Tolak';
                        btnReject.disabled = false;
                    }
                } else {
                    btnReject.innerHTML = 'Tolak';
                    btnReject.disabled = false;
                }
            });
        });
    }

    const btnEscalated = document.querySelector('.btn-escalated');
    if (btnEscalated) {
        btnEscalated.addEventListener('click', async () => {
            btnEscalated.innerHTML = 'Loading...';
            btnEscalated.disabled = true;
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin mengeskalasi tiket ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, eskalasi!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await escalated(parseSlug);
                    if (res.status === 'success' || res.status === 201 || res.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message || 'Tiket berhasil dieskalasi',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal eskalasi tiket'
                        });
                        btnEscalated.innerHTML = 'Eskalasi';
                        btnEscalated.disabled = false;
                    }
                } else {
                    btnEscalated.innerHTML = 'Eskalasi';
                    btnEscalated.disabled = false;
                }
            });
        });
    }

    const btnApprove = document.querySelector('.btn-approve');
    if (btnApprove) {
        btnApprove.addEventListener('click', async () => {
            const selected = document.querySelectorAll('input[name="kaur_id[]"]:checked');

            if (selected.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Pilih kaur dulu'
                });
                return;
            }

            btnApprove.innerHTML = 'Loading...';
            btnApprove.disabled = true;

            const idKaurList = [];
            const namaKaurList = [];

            selected.forEach(item => {
                idKaurList.push(item.value);

                const label = item.closest('label');
                const namaKaur = label.querySelector('span').innerText;
                namaKaurList.push(namaKaur);
            });

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin menyetujui tiket ini dan menugaskan ke KAUR?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, setujui & tugaskan!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await approveTiket(parseSlug, idKaurList, namaKaurList);
                    if (res.status === 'success' || res.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message || 'Berhasil assign tiket ke KAUR',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal assign tiket'
                        });
                        btnApprove.innerHTML = 'Setujui & Tugaskan';
                        btnApprove.disabled = false;
                    }
                } else {
                    btnApprove.innerHTML = 'Setujui & Tugaskan';
                    btnApprove.disabled = false;
                }
            });
        });
    }

    const btnClosed = document.querySelector('.btn-tutup-tiket');
    if (btnClosed) {
        btnClosed.addEventListener('click', async () => {
            btnClosed.innerHTML = 'Loading...';
            btnClosed.disabled = true;
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin menutup tiket ini (Selesai)?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, tutup tiket!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await closeTicket(parseSlug);
                    if (res.status === 'success' || res.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message || 'Tiket berhasil ditutup',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal menutup tiket'
                        });
                        btnClosed.innerHTML = 'Tutup Tiket (Selesai)';
                        btnClosed.disabled = false;
                    }
                } else {
                    btnClosed.innerHTML = 'Tutup Tiket (Selesai)';
                    btnClosed.disabled = false;
                }
            });
        });
    }
});