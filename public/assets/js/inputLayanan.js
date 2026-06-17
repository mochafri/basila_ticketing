const tokenCSRF = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

// --- MASTER SERVICE FUNCTIONS ---

async function postLayanan(namaLayanan, idKategori, kebutuhanDokumen, templateDokumenFile) {
    const formData = new FormData();
    formData.append('nama_layanan', namaLayanan);
    formData.append('kategori_id', idKategori);
    if (kebutuhanDokumen) {
        formData.append('kebutuhan_dokumen', kebutuhanDokumen);
    }
    if (templateDokumenFile) {
        formData.append('template_dokumen', templateDokumenFile);
    }

    const res = await fetch('/create-layanan', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': tokenCSRF
        },
        body: formData
    });

    return await res.json();
}

document.addEventListener('DOMContentLoaded', () => {
    const btnLayanan = document.querySelector('.btn-layanan');
    if (btnLayanan) {
        btnLayanan.addEventListener('click', async () => {
            const namaLayanan = document.querySelector('#inputLayanan').value;
            const selectKategori = document.querySelector('.select-kategori').value;
            const kebutuhanDokumen = document.querySelector('#inputKebutuhanDokumen').value;
            const templateDokumenInput = document.querySelector('#inputTemplateDokumen');
            const templateDokumenFile = templateDokumenInput.files.length > 0 ? templateDokumenInput.files[0] : null;

            if (!namaLayanan) {
                return Swal.fire('Error', 'Nama layanan tidak boleh kosong', 'error');
            }

            if (!selectKategori || selectKategori === 'PILIH KATEGORI TUJUAN') {
                return Swal.fire('Error', 'Silahkan pilih kategori terlebih dahulu', 'error');
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin menambahkan layanan "${namaLayanan}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const response = await postLayanan(namaLayanan, selectKategori, kebutuhanDokumen, templateDokumenFile);
                    if (response.status === 'success') {
                        Swal.fire('Berhasil!', 'Layanan berhasil ditambahkan', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', response.message || 'Gagal menambahkan layanan', 'error');
                    }
                }
            });
        });
    }

    // Event listeners for info icons
    const infoIcons = document.querySelectorAll('.btn-info-layanan');
    infoIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            const nama = icon.dataset.nama;
            const kebutuhan = icon.dataset.kebutuhan || 'Tidak ada kebutuhan dokumen khusus.';
            const template = icon.dataset.template;

            let htmlContent = `<div class="text-start mt-3">
                <p class="mb-2"><strong>Kebutuhan Dokumen:</strong><br/>${kebutuhan.replace(/\n/g, '<br/>')}</p>
            `;
            if (template) {
                htmlContent += `<p class="mb-0"><strong>Template Dokumen:</strong><br/>
                    <a href="${template}" target="_blank" class="btn btn-sm btn-outline-primary mt-1" style="border-radius: 8px;"><iconify-icon icon="mdi:download"></iconify-icon> Download Template</a>
                </p>`;
            }
            htmlContent += `</div>`;

            Swal.fire({
                title: `Info Layanan: ${nama}`,
                html: htmlContent,
                icon: 'info',
                confirmButtonText: 'Tutup'
            });
        });
    });
}); 