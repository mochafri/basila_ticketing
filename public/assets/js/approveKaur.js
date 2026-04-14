import { approveKaur, assignToStaff, verifikasiTugasTask, revisiTugasTask, selesaikanTugasKaur } from './app.js';

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

const btnApproveKaur = document.querySelector('.btn-approve-kaur');

if (btnApproveKaur) {
    btnApproveKaur.addEventListener('click', async () => {
        btnApproveKaur.innerHTML = 'Loading...';
        btnApproveKaur.disabled = true;

        const res = await approveKaur(parseSlug);

        alert(res.message || 'Penugasan berhasil diterima');

        if (res.status === 'success') {
            btnApproveKaur.style.display = 'none';

            if (formDelegasi) formDelegasi.style.display = 'block';
            if (btnSelesai) btnSelesai.style.display = 'block';
        } else {
            btnApproveKaur.disabled = false;
            btnApproveKaur.innerHTML = 'Terima & Mulai Penugasan';
        }
    });
}

    const formDelegasi = document.querySelector('.delegasi-wrapper');
    const btnSelesai = document.querySelector('.btn-selesaikan-penugasan');


    const btnAssignStaff = document.querySelector('.btn-assign-staff');
    if (btnAssignStaff) {
        btnAssignStaff.addEventListener('click', async () => {
            console.log('click');

            const selected = document.querySelectorAll('input[name="staff_id[]"]:checked');
            const instruksi = document.querySelector('.instruksi').value;

            if (selected.length === 0) {
                alert('Pilih staff dulu');
                return;
            }

            btnAssignStaff.innerHTML = 'Loading...';
            btnAssignStaff.disabled = true;

            const nipStaff = [];
            const namaStaff = [];

            selected.forEach(item => {
                const nip = item.value;
                const label = item.closest('label');
                const staff = label.querySelector('span').innerText;

                nipStaff.push(nip);
                namaStaff.push(staff);
            });

            const res = await assignToStaff(parseSlug, instruksi, namaStaff, nipStaff);
            alert(res.message || 'Berhasil memberikan tugas ke staf terkait');
            // location.reload();
        });
    }

    document.querySelectorAll('.btn-verifikasi-task').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const taskId = e.target.getAttribute('data-id');
            const res = await verifikasiTugasTask(taskId);
            if (res.ok) {
                alert('Tugas diverifikasi');
                location.reload();
            } else {
                alert('Gagal memverifikasi tugas');
            }
        });
    });

    document.querySelectorAll('.btn-revisi-task').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const taskId = e.target.getAttribute('data-id');
            const res = await revisiTugasTask(taskId);
            if (res.ok) {
                alert('Tugas dikembalikan untuk direvisi');
                location.reload();
            } else {
                alert('Gagal mengembalikan tugas untuk direvisi');
            }
        });
    });

    const btnSelesaiPenugasan = document.querySelector('.btn-selesaikan-penugasan');
    if (btnSelesaiPenugasan) {
        btnSelesaiPenugasan.addEventListener('click', async () => {
            const result = await selesaikanTugasKaur(parseSlug);
            alert(result.message);
            if (result.status === 'success') {
                location.reload();
            }
        });
    }
});