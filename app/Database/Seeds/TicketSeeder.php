<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_kategori' => 1,
                'id_layanan' => 2, // Gangguan Koneksi WiFi / LAN
                'judul_permohonan' => 'WiFi di Gedung Fakultas Mati Total',
                'deskripsi_permohonan' => 'Koneksi WiFi area lobi tidak bisa diakses sejak pagi, tolong segera diperiksa.',
                'dokumen_lampiran' => '171228221_error_wifi.png',
                'original_dokumen_name' => 'error_wifi.png',
                'is_escalated' => false,
                'approve_by' => null,
                'tiket_status' => 'Waiting',
                'catatan' => null,
                'created_at' => Time::now()->subDays(2)->toDateTimeString(),
                'updated_at' => Time::now()->subDays(2)->toDateTimeString(),
            ],
            [
                'id_kategori' => 2,
                'id_layanan' => 3, // Perbaikan Bug pada Sistem Akademik
                'judul_permohonan' => 'Bug Import Nilai pada Sistem',
                'deskripsi_permohonan' => 'Saat melakukan import file excel, muncul response error 500.',
                'dokumen_lampiran' => '171228222_bug_report.pdf',
                'original_dokumen_name' => 'bug_report.pdf',
                'is_escalated' => false,
                'approve_by' => null,
                'tiket_status' => 'Waiting',
                'catatan' => null,
                'created_at' => Time::now()->subDays(1)->toDateTimeString(),
                'updated_at' => Time::now()->subHours(5)->toDateTimeString(),
            ],
            [
                'id_kategori' => 3,
                'id_layanan' => 6, // Perbaikan Komputer / Printer Rusak
                'judul_permohonan' => 'Printer Ruang Biro Akademik Rusak',
                'deskripsi_permohonan' => 'Printer Epson tidak merespon print job meskipun indikator menyala.',
                'dokumen_lampiran' => '171228223_printer_log.docx',
                'original_dokumen_name' => 'printer_log.docx',
                'is_escalated' => false,
                'approve_by' => null,
                'tiket_status' => 'Waiting',
                'catatan' => null,
                'created_at' => Time::now()->subHours(10)->toDateTimeString(),
                'updated_at' => Time::now()->subHours(10)->toDateTimeString(),
            ],
            [
                'id_kategori' => 4,
                'id_layanan' => 7, // Reset Password Akun SSO
                'judul_permohonan' => 'Lupa Password SSO Dosen Baru',
                'deskripsi_permohonan' => 'Mohon reset password SSO atas nama Bapak Budi karena lupa password setelah registrasi.',
                'dokumen_lampiran' => '171228224_surat_permohonan.pdf',
                'original_dokumen_name' => 'surat_permohonan.pdf',
                'is_escalated' => false,
                'approve_by' => null,
                'tiket_status' => 'Waiting',
                'catatan' => null,
                'created_at' => Time::now()->subDays(5)->toDateTimeString(),
                'updated_at' => Time::now()->subDays(4)->toDateTimeString(),
            ],
            [
                'id_kategori' => 5,
                'id_layanan' => 9, // Pembuatan Email Institusi Baru
                'judul_permohonan' => 'Pembuatan Email Organisasi BEM',
                'deskripsi_permohonan' => 'Mohon dibuatkan akun email resmi untuk operasional BEM periode berjalan.',
                'dokumen_lampiran' => '171228225_sk_bem.pdf',
                'original_dokumen_name' => 'sk_bem.pdf',
                'is_escalated' => false,
                'approve_by' => null,
                'tiket_status' => 'Waiting',
                'catatan' => null,
                'created_at' => Time::now()->toDateTimeString(),
                'updated_at' => Time::now()->toDateTimeString(),
            ]
        ];
        
        $this->db->table('tikets')->insertBatch($data);
    }
}

