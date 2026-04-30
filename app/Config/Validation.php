<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    public array $kategoriRule = [
        'nama_kategori' => [
            'label' => 'Nama Kategori',
            'rules' => 'required|string|min_length[3]|max_length[100]'
        ]
    ];

    public array $layananRule = [
        'nama_layanan' => [
            'label' => 'Nama Layanan',
            'rules' => 'required|string|min_length[3]|max_length[100]'
        ],
        'kategori_id' => [
            'label' => 'Kategori',
            'rules' => 'required|integer'
        ]
    ];

    public array $approveRule = [
        'approve' => [
            'label' => 'Approve Oleh',
            'rules' => 'required|string|max_length[100]'
        ],
        'assign_to_kaur' => [
            'label' => 'Assign Kaur',
            'rules' => 'required'
        ],
        'assign_to_kaur.*' => [
            'label' => 'Kaur',
            'rules' => 'required|string|max_length[100]'
        ],
        'user_id.*' => [
            'label' => 'User ID',
            'rules' => 'required|integer'
        ],
        'level_kesulitan' => [
            'label' => 'Level Kesulitan',
            'rules' => 'permit_empty|in_list[low,medium,high]'
        ]
    ];

    public array $rejectRule = [
        'catatan' => [
            'label' => 'Catatan Revisi',
            'rules' => 'required|string|min_length[3]'
        ]
    ];

    public array $assignTaskRule = [
        'task_instruction' => [
            'label' => 'Instruksi Tugas',
            'rules' => 'required|string|min_length[3]'
        ],
        'received_by.*' => [
            'label' => 'Staff',
            'rules' => 'required|string'
        ],
        'user_id.*' => [
            'label' => 'User ID',
            'rules' => 'required|integer'
        ]
    ];

    public array $tiketRule = [
        'judul' => [
            'label' => 'Judul',
            'rules' => 'permit_empty|string|max_length[255]'
        ],
        'kategori' => [
            'label' => 'Kategori',
            'rules' => 'required|integer'
        ],
        'layanan' => [
            'label' => 'Layanan',
            'rules' => 'required|integer'
        ],
        'deskripsi' => [
            'label' => 'Deskripsi',
            'rules' => 'required|string|min_length[5]'
        ],
        'lampiran_dokumen' => [
            'label' => 'Lampiran',
            'rules' => 'permit_empty|mime_in[lampiran_dokumen,image/png,image/jpeg,application/pdf]|max_size[lampiran_dokumen,10240]'
        ]
    ];

    public array $uploadTaskRule = [
        'dokumen_task' => [
            'label' => 'File Task',
            'rules' => 'permit_empty|mime_in[file_task,image/png,image/jpeg,application/pdf]|max_size[file_task,10240]'
        ],
        'laporan_task'=> [
            'label' => 'Laporan Task',
            'rules' => 'required|string|min_length[5]'
        ],
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public array $workLogRule = [
        'deskripsi' => [
            'label' => 'Deskripsi Pekerjaan',
            'rules' => 'required|string|min_length[5]'
        ],
        'bukti' => [
            'label' => 'Bukti Pekerjaan',
            'rules' => 'permit_empty|uploaded[bukti]|mime_in[bukti,image/png,image/jpeg,application/pdf]|max_size[bukti,10240]'
        ],
    ];
}
