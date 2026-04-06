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

// export async function postTiket(judul, kategori, layanan, deskripsi, dokumenLampiran) {
//     const formData = new FormData();

//     formData.append('judul', judul);
//     formData.append('kategori', kategori);
//     formData.append('layanan', parseInt(layanan));
//     formData.append('deskripsi', deskripsi);
//     formData.append('lampiran_dokumen', dokumenLampiran);

//     const res = await fetch('/create-tiket', {
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': tokenCSRF
//         },
//         body: formData
//     });

//     if (res) {
//         console.log('berhasil');
//     }
// }

export async function getLayananById(id) {
    const res = await fetch(`/get-layanan/${id}`);
    const data = await res.json();

    return data;
}

export async function reject(id) {
    await fetch(`/reject-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
}

export async function escalated(id) {
    await fetch(`/escalated-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'Application/json',
            'X-CSRF-TOKEN': tokenCSRF
        }
    });
}

export async function approveTiket(id, userId, nama) {
    return fetch(`/approve-tiket/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: [userId], 
            assign_to_kabag: [nama],
            approve: 'buk fira'
        })
    });
}