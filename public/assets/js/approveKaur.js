const tokenCSRF = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

// --- KAUR SERVICE FUNCTIONS ---

async function approveKaur(id) {
    const res = await fetch(`/approve-task/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

async function assignToStaff(id, instruksi, namaStaff, nipStaff) {
    const res = await fetch(`/assign-staff/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            task_instruction: instruksi,
            assign_task_to_staff: namaStaff,
            user_id: nipStaff
        })
    });
    return await res.json();
}

async function editInstructionTask(id, instruction) {
    const res = await fetch(`/edit-instruction/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            instruction: instruction
        })
    });
    return await res.json();
}

async function verifikasiTugasTask(id) {
    const res = await fetch(`/verifikasi-tugas/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return res;
}

async function revisiTugasTask(id) {
    const res = await fetch(`/revisi-tugas/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return res;
}

async function selesaikanTugasKaur(id) {
    const res = await fetch(`/selesaikan-tugas-kaur/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

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

            if (res.status === 'success') {
                btnApproveKaur.style.display = 'none';

                if (formDelegasi) formDelegasi.style.display = 'block';
                if (btnSelesai) btnSelesai.style.display = 'block';
            } else {
                console.error(res.message || 'Gagal menerima penugasan');
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
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Pilih staff dulu'
                });
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

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Menugaskan staf dengan instruksi tersebut?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, tugaskan!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await assignToStaff(parseSlug, instruksi, namaStaff, nipStaff);
                    if (res.status === 'success' || res.status === 200) {
                        if (res.duplicates && res.duplicates.length > 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan Penugasan!',
                                html: `Berhasil menugaskan staf baru.<br><br><small class="text-muted">Catatan: Staf berikut sudah ditugaskan sebelumnya dan tidak ditambahkan lagi: <br><b>${res.duplicates.join(', ')}</b></small>`,
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'Berhasil memberikan tugas ke staf terkait',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
                        
                        btnAssignStaff.innerHTML = '+';
                        btnAssignStaff.disabled = false;
                        document.querySelector('.instruksi').value = '';
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal memberikan tugas'
                        });
                        btnAssignStaff.innerHTML = '+';
                        btnAssignStaff.disabled = false;
                    }
                } else {
                    btnAssignStaff.innerHTML = '+';
                    btnAssignStaff.disabled = false;
                }
            });
        });
    }

    document.querySelectorAll('.btn-verifikasi-task').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const taskId = e.target.getAttribute('data-id');
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin memverifikasi tugas ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, verifikasi!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await verifikasiTugasTask(taskId);
                    if (res.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Tugas diverifikasi',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memverifikasi tugas'
                        });
                    }
                }
            });
        });
    });

    document.querySelectorAll('.btn-revisi-task').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const taskId = e.target.getAttribute('data-id');
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin mengembalikan tugas ini untuk direvisi?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f39c12",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, revisi!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await revisiTugasTask(taskId);
                    if (res.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Tugas dikembalikan untuk direvisi',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal mengembalikan tugas untuk direvisi'
                        });
                    }
                }
            });
        });
    });

    document.querySelectorAll('.btn-edit-instruction').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const targetBtn = e.target.closest('.btn-edit-instruction');
            const taskId = targetBtn.getAttribute('data-id');
            const oldInstruction = targetBtn.getAttribute('data-instruction');

            const {
                value: newInstruction
            } = await Swal.fire({
                title: 'Ubah Instruksi',
                input: 'textarea',
                inputLabel: 'Masukan instruksi penugasan baru',
                inputValue: oldInstruction,
                inputPlaceholder: 'Tulis instruksi di sini...',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Simpan Perubahan',
                confirmButtonColor: '#3085d6',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Instruksi tidak boleh kosong!'
                    }
                }
            });

            if (newInstruction) {
                targetBtn.disabled = true;
                const res = await editInstructionTask(taskId, newInstruction.trim());
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Instruksi berhasil diubah',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: res.message || 'Gagal mengubah instruksi'
                    });
                }
                targetBtn.disabled = false;
            }
        });
    });

    const btnSelesaiPenugasan = document.querySelector('.btn-selesaikan-penugasan');
    if (btnSelesaiPenugasan) {
        btnSelesaiPenugasan.addEventListener('click', async () => {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Menyelesaikan seluruh bagian penugasan tiket ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, selesaikan!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await selesaikanTugasKaur(parseSlug);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message
                        });
                    }
                }
            });
        });
    }
});