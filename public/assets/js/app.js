// Consume endpoint/API on js

const tokenCSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
    await fetch('/create-layanan', {
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
}

export async function postTiket(judul, kategori, layanan, deskripsi, dokumenLampiran) {
    const formData = new FormData();

    formData.append('judul', judul);
    formData.append('kategori', kategori);
    formData.append('layanan', parseInt(layanan));
    formData.append('deskripsi', deskripsi);
    formData.append('lampiran_dokumen', dokumenLampiran);

    const res = await fetch('/create-tiket', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: formData
    });

    if (res) {
        console.log('berhasil');
    }
}

export async function getLayanan(id) {
    const res = await fetch(`/get-layanan/${id}`);
    const data = await res.json();

    return data;
}