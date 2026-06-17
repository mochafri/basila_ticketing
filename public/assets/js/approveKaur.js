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

async function acceptTaskDirect(id) {
    const res = await fetch(`/accept-task/${id}`, {
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
            received_by: namaStaff,
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

async function revisiTugasTask(id, catatan) {
    const res = await fetch(`/revisi-tugas/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            catatan: catatan
        })
    });
    return res;
}

async function selesaikanTugasKaur(id, catatanPenyelesaian = null) {
    const res = await fetch(`/selesaikan-tugas-kaur/${id}`, {
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

async function updateCatatanKaurAPI(id, catatan) {
    const res = await fetch(`/update-catatan-kaur/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            catatan_penyelesaian: catatan
        })
    });
    return await res.json();
}

async function uploadTaskKaur(id, dokumenTask, laporanTask, isDownloadable, note) {
    const formData = new FormData();
    formData.append('laporan_task', laporanTask);
    formData.append('is_downloadable', isDownloadable);
    formData.append('catatan_penyelesaian', note);

    if (dokumenTask) {
        formData.append('dokumen_task', dokumenTask);
    }

    const res = await fetch(`/upload-task-kaur/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: formData
    });

    return await res.json();
}

async function addLogNote(id, note) {
    const res = await fetch(`/add-log-note/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            note: note
        })
    });
    return await res.json();
}

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

    // --- LOG NOTE LOGIC ---
    const btnAddLogNote = document.querySelector('.btn-add-log-note');
    if (btnAddLogNote) {
        btnAddLogNote.addEventListener('click', async () => {
            const {
                value: note
            } = await Swal.fire({
                title: 'Tambah Catatan Progress',
                input: 'textarea',
                inputLabel: 'Tuliskan catatan kemajuan pengerjaan tiket ini',
                inputPlaceholder: 'Contoh: Sedang berkoordinasi dengan pihak IT...',
                showCancelButton: true,
                confirmButtonText: 'Simpan Catatan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan tidak boleh kosong!'
                    }
                }
            });

            if (note) {
                const res = await addLogNote(parseSlug, note.trim());
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Catatan berhasil ditambahkan ke riwayat aktifitas',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: res.message || 'Gagal menambahkan catatan'
                    });
                }
            }
        });
    }

    // Logic kaur menyelesaikan tugas
    const btnSelesaikanMandiri = document.getElementById('btnSelesaikanTugas');
    const wrapperPenyelesaianMandiri = document.getElementById('wrapperPenyelesaian');
    const btnKirimLaporanMandiri = document.getElementById('btnKirimLaporan');
    const btnBatalMandiri = document.getElementById('btnBatalPenyelesaian');
    const uploadInput = document.getElementById('uploadBukti');
    const fileNameDisplay = document.getElementById('fileName');
    const isDownloadableInput = document.getElementById('isDownloadable');

    if (btnSelesaikanMandiri && wrapperPenyelesaianMandiri) {
        btnSelesaikanMandiri.addEventListener('click', () => {
            wrapperPenyelesaianMandiri.classList.toggle('show');
            if (wrapperPenyelesaianMandiri.classList.contains('show')) {
                btnSelesaikanMandiri.textContent = 'Tutup Form Penyelesaian';
                btnSelesaikanMandiri.classList.remove('btn-danger');
                btnSelesaikanMandiri.classList.add('btn-secondary');
            } else {
                btnSelesaikanMandiri.textContent = 'Selesaikan Tugas';
                btnSelesaikanMandiri.classList.remove('btn-secondary');
                btnSelesaikanMandiri.classList.add('btn-danger');
            }
        });
    }

    if (btnBatalMandiri && wrapperPenyelesaianMandiri) {
        btnBatalMandiri.addEventListener('click', () => {
            wrapperPenyelesaianMandiri.classList.remove('show');
            btnSelesaikanMandiri.textContent = 'Selesaikan Tugas';
            btnSelesaikanMandiri.classList.remove('btn-secondary');
            btnSelesaikanMandiri.classList.add('btn-danger');

            // Reset form
            document.querySelector('#formPenyelesaianTugas textarea').value = '';
            if (uploadInput) uploadInput.value = '';
            if (fileNameDisplay) fileNameDisplay.textContent = '';
        });
    }

    if (uploadInput && fileNameDisplay) {
        uploadInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileNameDisplay.textContent = e.target.files[0].name;
            }
        });
    }

    if (btnKirimLaporanMandiri) {
        btnKirimLaporanMandiri.addEventListener('click', async () => {
            const laporan = document.querySelector('#formPenyelesaianTugas textarea').value;
            const file = uploadInput ? uploadInput.files[0] : null;
            const isDownloadable = isDownloadableInput && isDownloadableInput.checked ? 1 : 0;

            if (!laporan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Tolong isi laporan penyelesaian tugas Anda!'
                });
                return;
            }

            btnKirimLaporanMandiri.innerHTML = 'Kirim Laporan...';
            btnKirimLaporanMandiri.disabled = true;

            const { value: noteKabag } = await Swal.fire({
                title: 'Tambah feedback kepada pengaju',
                input: 'textarea',
                inputLabel: 'Tuliskan feedback penting untuk pengaju',
                showCancelButton: true,
                confirmButtonText: 'Simpan feedback',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Feedback tidak boleh kosong'
                    }
                }
            });

            if (noteKabag) {
                const res = await uploadTaskKaur(parseSlug, file, laporan, isDownloadable, noteKabag);
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Berhasil menyelesaikan tugas mandiri',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: res.message || 'Gagal mengirim laporan'
                    });

                    btnKirimLaporanMandiri.innerHTML = 'KIRIM LAPORAN';
                    btnKirimLaporanMandiri.disabled = false;
                }
            }
        });
    }

    const btnAccTask = document.querySelector('.btn-acc-task');

    if (btnAccTask) {
        btnAccTask.addEventListener('click', async () => {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin menerima dan mengerjakan tugas ini sendiri?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, terima!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    btnAccTask.innerHTML = 'Loading...';
                    btnAccTask.disabled = true;

                    const res = await acceptTaskDirect(parseSlug);

                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Berhasil menerima tugas',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal menerima tugas'
                        });
                        btnAccTask.disabled = false;
                        btnAccTask.innerHTML = 'Terima Tugas';
                    }
                }
            });
        });
    }

    const btnApproveKaur = document.querySelector('.btn-approve-kaur');

    if (btnApproveKaur) {
        btnApproveKaur.addEventListener('click', async () => {
            Swal.fire({
                title: "Konfirmasi Terima Tugas",
                text: "Anda akan menerima tugas ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, terima!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    btnApproveKaur.innerHTML = 'Loading...';
                    btnApproveKaur.disabled = true;

                    const res = await approveKaur(parseSlug);

                    if (res.status === 'success') {
                        btnApproveKaur.style.display = 'none';

                        if (formDelegasi) formDelegasi.style.display = 'block';
                        if (btnSelesai) btnSelesai.style.display = 'block';

                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message || 'Gagal menerima penugasan'
                        });
                        btnApproveKaur.disabled = false;
                        btnApproveKaur.innerHTML = 'Terima Tugas';
                    }
                }
            });
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

            const {
                value: catatan
            } = await Swal.fire({
                title: 'Konfirmasi Revisi',
                text: "Berikan catatan revisi untuk staf terkait",
                input: 'textarea',
                inputPlaceholder: 'Tulis catatan revisi di sini...',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f39c12",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, revisi!",
                cancelButtonText: "Batal",
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan revisi tidak boleh kosong!'
                    }
                }
            });

            if (catatan) {
                const res = await revisiTugasTask(taskId, catatan.trim());
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
            const { value: catatan } = await Swal.fire({
                title: 'Catatan Penyelesaian',
                text: "Berikan catatan penyelesaian (feedback) yang akan diteruskan ke Kabag dan Pengguna.",
                input: 'textarea',
                inputPlaceholder: 'Tulis catatan di sini...',
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Selesaikan & Simpan",
                cancelButtonText: "Batal",
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan tidak boleh kosong!'
                    }
                }
            });

            if (catatan) {
                const res = await selesaikanTugasKaur(parseSlug, catatan.trim());
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
    }

    const btnEditCatatanKaur = document.querySelectorAll('.btn-edit-catatan-kaur');
    btnEditCatatanKaur.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const taskId = e.target.closest('.btn-edit-catatan-kaur').getAttribute('data-id');
            const oldCatatan = e.target.closest('.btn-edit-catatan-kaur').getAttribute('data-catatan');

            const { value: newCatatan } = await Swal.fire({
                title: 'Edit Catatan Penyelesaian',
                input: 'textarea',
                inputValue: oldCatatan,
                inputPlaceholder: 'Tulis catatan di sini...',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Simpan Perubahan",
                cancelButtonText: "Batal",
                inputValidator: (value) => {
                    if (!value) {
                        return 'Catatan tidak boleh kosong!'
                    }
                }
            });

            if (newCatatan) {
                const res = await updateCatatanKaurAPI(taskId, newCatatan.trim());
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
});