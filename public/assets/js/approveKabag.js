import { reject, escalated, approveTiket, closeTicket } from "/assets/js/app.js";

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

    const btnReject = document.querySelector('.btn-reject');
    if (btnReject) {
        btnReject.addEventListener('click', async () => {
            btnReject.innerHTML = 'Loading...';
            btnReject.disabled = true;
            const res = await reject(parseSlug);
            alert(res.message || 'Tiket berhasil direject');
            location.reload();
        });
    }

    const btnEscalated = document.querySelector('.btn-escalated');
    if (btnEscalated) {
        btnEscalated.addEventListener('click', async () => {
            btnEscalated.innerHTML = 'Loading...';
            btnEscalated.disabled = true;
            const res = await escalated(parseSlug);
            alert(res.message || 'Tiket berhasil dieskalasi');
            location.reload();
        });
    }

    const btnApprove = document.querySelector('.btn-approve');
    if (btnApprove) {
        btnApprove.addEventListener('click', async () => {
            const selected = document.querySelectorAll('input[name="kaur_id[]"]:checked');

            if (selected.length === 0) {
                alert('Pilih kaur dulu');
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

            const res = await approveTiket(parseSlug, idKaurList, namaKaurList);
            alert(res.message || 'Berhasil assign tiket ke KAUR');
            location.reload();
        });
    }

    const btnClosed = document.querySelector('.btn-tutup-tiket');
    if (btnClosed) {
        btnClosed.addEventListener('click', async () => {
            btnClosed.innerHTML = 'Loading...';
            btnClosed.disabled = true;
            const res = await closeTicket(parseSlug);
            alert(res.message || 'Tiket berhasil ditutup');
            location.reload();
        });
    }
});