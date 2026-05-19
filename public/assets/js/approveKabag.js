const tokenCSRF = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

// --- KABAG SERVICE FUNCTIONS ---

async function approveTiket(id, userId, nama, levelKesulitan) {
    const res = await fetch(`/approve-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            user_id: userId,
            assign_to_kaur: nama,
            approve: 'buk fira',
            level_kesulitan: levelKesulitan
        })
    });
    return await res.json();
}

async function reject(id, catatan) {
    const res = await fetch(`/reject-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            catatan: catatan
        })
    });
    return await res.json();
}

async function escalated(id, catatan) {
    const res = await fetch(`/escalated-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            notes_escalated: catatan
        })
    });
    return await res.json();
}

async function revisiKaur(id, catatan) {
    const res = await fetch(`/revisi-kaur`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            assign_id: id,
            catatan: catatan
        })
    });
    return await res.json();
}

async function closeTicket(id, catatanPenyelesaian = null) {
    const res = await fetch(`/tutup-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            catatan_penyelesaian: catatanPenyelesaian
        })
    });
    return await res.json();
}

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

    const btnRevisiIndividual = document.querySelectorAll('.btn-revisi-kaur-individual');
    if (btnRevisiIndividual.length > 0) {
        btnRevisiIndividual.forEach(btn => {
            btn.addEventListener('click', async () => {
                const assignId = btn.getAttribute('data-id');
                const kaurName = btn.getAttribute('data-name');
                const originalText = btn.innerHTML;

                Swal.fire({
                    title: `Revisi untuk ${kaurName}?`,
                    text: `Berikan catatan apa yang perlu diperbaiki oleh ${kaurName}:`,
                    input: 'textarea',
                    inputPlaceholder: 'Ketik catatan revisi di sini...',
                    inputAttributes: {
                        'aria-label': 'Ketik catatan revisi di sini'
                    },
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#f39c12",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Kirim Revisi!",
                    cancelButtonText: "Batal",
                    preConfirm: (value) => {
                        if (!value) {
                            Swal.showValidationMessage('Catatan revisi wajib diisi!')
                        }
                        return value;
                    }
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        btn.innerHTML = '<iconify-icon icon="line-md:loading-loop" class="fs-6"></iconify-icon> Processing...';
                        btn.disabled = true;

                        const res = await revisiKaur(assignId, result.value);
                        if (res.status === 'success' || res.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || `Berhasil mengirim permintaan revisi ke ${kaurName}`,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: res.message || 'Gagal mengirim permintaan revisi'
                            });
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }
                    }
                });
            });
        });
    }

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
                confirmButtonColor: "#f39c12",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Tolak!",
                cancelButtonText: "Batal",
                preConfirm: (value) => {
                    if (!value) {
                        Swal.showValidationMessage('Catatan revisi wajib diisi!')
                    }
                    return value;
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await reject(parseSlug, result.value);
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
                input: "textarea",
                inputPlaceholder: 'Ketik catatan eskalasi di sini...',
                inputAttributes: {
                    'aria-label': 'Ketik catatan eskalasi di sini'
                },
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, eskalasi!",
                cancelButtonText: "Batal",
                preConfirm: (value) => {
                    if (!value) {
                        Swal.showValidationMessage('Catatan eskalasi wajib diisi!')
                    }
                    return value;
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await escalated(parseSlug, result.value);
                    if (res.status === 'success' || res.status === 200) {
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
            const levelKesulitan = document.getElementById('level_kesulitan').value;

            if (selected.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Pilih kaur dulu'
                });
                return;
            }

            if (!levelKesulitan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Pilih level kesulitan dulu'
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
                    const res = await approveTiket(parseSlug, idKaurList, namaKaurList, levelKesulitan);
                    if (res.status === 'success' || res.status === 200) {
                        if (res.duplicates && res.duplicates.length > 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan Penugasan!',
                                html: `Berhasil menyetujui tiket.<br><br><small class="text-muted">Catatan: Kaur berikut sudah ditugaskan sebelumnya pada tiket ini: <br><b>${res.duplicates.join(', ')}</b></small>`,
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'Berhasil assign tiket ke KAUR',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
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
            const oldCatatan = btnClosed.getAttribute('data-catatan');
            
            Swal.fire({
                title: "Tutup Tiket (Selesai)?",
                text: "Anda dapat memodifikasi catatan penyelesaian sebelum tiket ditutup.",
                icon: "question",
                input: 'textarea',
                inputValue: oldCatatan,
                inputPlaceholder: 'Tulis catatan penyelesaian di sini...',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, tutup tiket!",
                cancelButtonText: "Batal",
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan penyelesaian tidak boleh kosong!'
                    }
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    btnClosed.innerHTML = 'Loading...';
                    btnClosed.disabled = true;
                    
                    const res = await closeTicket(parseSlug, result.value.trim());
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
                }
            });
        });
    }
});