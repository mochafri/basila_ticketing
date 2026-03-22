<?php

namespace App\Controllers;

class TicketController extends BaseController
{
    public function index(): string
    {
        return view('tiket/daftar/index', [
            'title' => 'Daftar Tiket',
            'tiket' => service('tiket')->getDataTiket(),
        ]);
    }

    public function create(): string
    {
        return view('tiket/pengajuan/index', [
            'title' => 'Pengajuan Tiket',
            'kategori' => service('kategori')->getKategori(),
        ]);
    }

    public function getLayananByID($slug)
    {
        $result = service('layanan')->getLayanan($slug);

        $statusCode = $result['status'] === 'success' ? 201 : 422;
        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function show($slug): string
    {
        return view('tiket/daftar/detail', [
            'title' => 'Detail Tiket',
            'detail' => service('tiket')->showTiket($slug)
        ]);
    }

    // Buat dpet akses ke file dokumen yg udh diupload
    public function getFile($fileName)
    {
        $fullPath = WRITEPATH . 'uploads/tiket/' . $fileName;

        if (!file_exists($fullPath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($fullPath))
            ->setBody(file_get_contents($fullPath));
    }

    public function createTiket()
    {
        $tiketRule = [
            'judul' => 'required|string',
            'kategori' => 'required|integer',
            'layanan' => 'required|integer',
            'deskripsi' => 'required|string',
            'lampiran_dokumen' => 'permit_empty|mime_in[lampiran_dokumen,image/png,image/jpeg,application/pdf]|max_size[lampiran_dokumen,10240]'
        ];

        if (!$this->validate($tiketRule)) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Failed request',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = $this->request->getPost();
        $file = $this->request->getFile('lampiran_dokumen');

        $result = service('tiket')->create($data, $file);

        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function approveTiket()
    {
        $data = $this->request->getPost();

        if (!$this->validateData($data, 'approveRule')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => 'failed',
                    'message' => 'Gagal approve tiket'
                ]);
        }

        $result = service('tiket')->approveTiket($data);

        return $this->response->setStatusCode(200)->setJSON($result);
    }

    public function rejectTiket($slug)
    {
        log_message('info', 'PARAM SLUG: ' . $slug);
        $result = service('tiket')->rejectTiket($slug);
        $statusCode = $result['status'] === 'success' ? 201 : 422;

        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function escalated($slug)
    {
        $result = service('tiket')->isEscalated($slug);
        $statusCode = $result['status'] === 'success' ? 201 : 422;

        return response()->setStatusCode($statusCode)->setJSON($result);
    }
}
