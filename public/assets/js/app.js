// Consume endpoint/API on js

const tokenCSRF = document
    .querySelector('meta[name="X-CSRF-TOKEN"]')
    .getAttribute('content');

export async function postKategori(namaKategori) {
    const res = await fetch('/create-kategori', {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            nama_kategori: namaKategori
        })
    });

    if (res) {
        console.log('berhasil');
    }
}

export async function postLayanan(namaLayanan, idKategori) {
    const res = await fetch('/create-layanan', {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            nama_layanan: namaLayanan,
            kategori_id: idKategori
        })
    });

    if (res) {
        console.log('berhasil');
    }
}

export async function postTiket(judul, kategori, layanan, deskripsi, dokumenLampiran) {
    const formData = new FormData();

    formData.append('judul', judul);
    formData.append('kategori', kategori);
    formData.append('layanan', parseInt(layanan));
    formData.append('deskripsi', deskripsi);
    if(dokumenLampiran) formData.append('lampiran_dokumen', dokumenLampiran);

    const res = await fetch('/create-tiket', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: formData
    });

    return await res.json();
}

export async function getLayananById(id) {
    const res = await fetch(`/get-layanan/${id}`);
    const data = await res.json();

    return data;
}

export async function reject(id) {
    const res = await fetch(`/reject-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

export async function escalated(id) {
    const res = await fetch(`/escalated-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

export async function approveTiket(id, userId, nama) {
    const res = await fetch(`/approve-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            user_id: userId, 
            assign_to_kaur: nama,
            approve: 'buk fira'
        })
    });
    return await res.json();
}

export async function approveKaur(id) {
    const res = await fetch(`/approve-task/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

export async function assignToStaff(id, instruksi, namaStaff, nipStaff) {
    const res = await fetch(`/assign-staff/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
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

export async function uploadTask(id, dokumenTask, laporanTask) {
    const formData = new FormData();
    formData.append('laporan_task', laporanTask);
    
    if (dokumenTask) {
        formData.append('dokumen_task', dokumenTask);
    }

    const res = await fetch(`/upload-task/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: formData
    });
    return await res.json();
}

export async function verifikasiTugasTask(id) {
    const res = await fetch(`/verifikasi-tugas/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return res;
}

export async function revisiTugasTask(id) {
    const res = await fetch(`/revisi-tugas/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return res;
}

export async function selesaikanTugasKaur(id) {
    const res = await fetch(`/selesaikan-tugas-kaur/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

export async function closeTicket(id) {
    const res = await fetch(`/tutup-tiket/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

export async function editInstructionTask(id, instruction) {
    const res = await fetch(`/edit-instruction/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: JSON.stringify({
            instruction: instruction
        })
    });
    return await res.json();
}

export async function approveEscalated(id) {
    const res = await fetch(`/approve-escalated/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

export async function rejectEscalated(id) {
    const res = await fetch(`/reject-escalated/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}