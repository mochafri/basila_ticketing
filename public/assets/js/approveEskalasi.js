const tokenCSRF = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

// --- ESKALASI SERVICE FUNCTIONS ---

async function approveEscalated(id) {
    const res = await fetch(`/approve-escalated/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

async function rejectEscalated(id, catatan) {
    const res = await fetch(`/reject-escalated/${id}`, {
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

document.addEventListener('DOMContentLoaded', () => {
    const segments = window.location.pathname.split('/');
    const slug = segments.pop();
    const parseSlug = parseInt(slug);

    const btnApproveEscalated = document.querySelector('.btn-approve-escalated');
    if (btnApproveEscalated) {
        btnApproveEscalated.addEventListener('click', async () => {
            btnApproveEscalated.innerHTML = 'Loading...';
            btnApproveEscalated.disabled = true;

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin menyetujui eskalasi tiket ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, setujui!",
                cancelButtonText: "Batal"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const res = await approveEscalated(parseSlug);
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
                        btnApproveEscalated.innerHTML = 'Setujui Eskalasi';
                        btnApproveEscalated.disabled = false;
                    }
                } else {
                    btnApproveEscalated.innerHTML = 'Setujui Eskalasi';
                    btnApproveEscalated.disabled = false;
                }
            });
        });
    }

    const btnRejectEscalated = document.querySelector('.btn-reject-escalated');
    if (btnRejectEscalated) {
        btnRejectEscalated.addEventListener('click', async () => {
            btnRejectEscalated.innerHTML = 'Loading...';
            btnRejectEscalated.disabled = true;

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Ingin menolak eskalasi tiket ini?",
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
                    const res = await rejectEscalated(parseSlug, result.value);
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
                        btnRejectEscalated.innerHTML = 'Tolak Eskalasi';
                        btnRejectEscalated.disabled = false;
                    }
                } else {
                    btnRejectEscalated.innerHTML = 'Tolak Eskalasi';
                    btnRejectEscalated.disabled = false;
                }
            });
        });
    }
});
