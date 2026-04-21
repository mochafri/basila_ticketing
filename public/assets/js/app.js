// Consume endpoint/API on js

const tokenCSRF = document
    .querySelector('meta[name="X-CSRF-TOKEN"]')
    .getAttribute('content');

// --- MASTER SERVICE ---

// buat kategori
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

// buat layanan
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

// ambil layanan by id
export async function getLayananById(id) {
    const res = await fetch(`/get-layanan/${id}`);
    const data = await res.json();

    return data;
}


// --- TIKET SERVICE ---

// buat tiket
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

// tutup tiket
export async function closeTicket(id) {
    const res = await fetch(`/tutup-tiket/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}


// --- KABAG SERVICE ---

// approve tiket dari kabag ke kaur
export async function approveTiket(id, userId, nama) {
    const res = await fetch(`/approve-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
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

// reject tiket dari kabag
export async function reject(id, catatan) {
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

// eskalasi tiket
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

// -- Eskalasi Service --

// approve eskalasi
export async function approveEscalated(id) {
    const res = await fetch(`/approve-escalated/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

// reject eskalasi
export async function rejectEscalated(id, catatan) {
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


// --- KAUR SERVICE ---

// kaur terima/approve tugas
export async function approveKaur(id) {
    const res = await fetch(`/approve-task/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}

// kaur assign tugas ke staff
export async function assignToStaff(id, instruksi, namaStaff, nipStaff) {
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

// kaur edit instruksi tugas
export async function editInstructionTask(id, instruction) {
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

// kaur verifikasi tugas staff
export async function verifikasiTugasTask(id) {
    const res = await fetch(`/verifikasi-tugas/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return res;
}

// kaur minta revisi ke staff
export async function revisiTugasTask(id) {
    const res = await fetch(`/revisi-tugas/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return res;
}

// kaur kirim revisi balik 
export async function revisiKaur(id, catatan) {
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

// kaur selesaikan tugas keseluruhan
export async function selesaikanTugasKaur(id) {
    const res = await fetch(`/selesaikan-tugas-kaur/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
    return await res.json();
}


// --- STAFF SERVICE ---

// staff upload hasil tugas / laporan
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