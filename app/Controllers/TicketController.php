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
        $result = service('layanan')->getLayananById($slug);

        $statusCode = $result['status'] === 'success' ? 201 : 422;
        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function show($slug): string
    {
        $nip = session('user_identifier');

        return view('tiket/daftar/detail', [
            'title' => 'Detail Tiket',
            'detail' => service('tiket')->showTiket($slug),
            'kaur' => service('kaurstaff')->getKaur(),
            'staff' => service('kaurstaff')->getStaff($nip),
            'taskStaff' => service('tiket')->getTaskStaff($slug, $nip),
            'taskStaffOnKaur' => service('tiket')->getTaskKaurByTiket($slug),
        ]);
    }

    # Buat dpet akses ke file dokumen yg udh diupload
    public function getFileUsers($fileName)
    {
        $fullPath = WRITEPATH . 'uploads/tiket/users/' . $fileName;

        if (!file_exists($fullPath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($fullPath))
            ->setBody(file_get_contents($fullPath));
    }

    public function getFileAdmin($fileName)
    {
        $fullPath = WRITEPATH . 'uploads/tiket/admin/' . $fileName;

        if (!file_exists($fullPath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($fullPath))
            ->setBody(file_get_contents($fullPath));
    }

    # Fungsi untuk membuat tiket baru
    public function createTiket()
    {
        $data = $this->request->getPost();

        if (!$this->validateData($data, 'tiketRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Failed request',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $file = $this->request->getFile('lampiran_dokumen');

        $result = service('tiket')->create($data, $file);

        if ($result['status'] === 'success') {
            return $this->response->setStatusCode(200)->setJSON($result);
        } else {
            return $this->response->setStatusCode(400)->setJSON($result);
        }
    }

    # controller buat kaur
    public function approveTiket($slug)
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'approveRule')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => 'failed',
                    'message' => 'Gagal approve tiket'
                ]);
        }

        $result = service('tiket')->approveTiket($data, $slug);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function rejectTiket($slug)
    {
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

    # assign tiket to staff / controller buat kabag
    public function approveTask($slug)
    {
        $user_identifier = session('user_identifier');
        $result = service('tiket')->approveTask($slug);

        $statusCode = $result['status'] === 'success' ? 201 : 422;
        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function asssignTiket($slug)
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'assignTaskRule')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => 'failed',
                    'message' => $this->validator->getErrors()
                ]);
        }

        $user_identifier = session('user_identifier');
        $result = service('tiket')->assignToStaff($slug, $data, $user_identifier);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function uploadTask($slug)
    {
        $data = $this->request->getPost();
        $file = $this->request->getFile('dokumen_task');

        if (!$this->validateData($data, 'uploadTaskRule')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => 'failed',
                    'message' => $this->validator->getErrors()
                ]);
        }

        $result = service('tiket')->updateTask($slug, $data, $file);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function verifikasiTask($taskId)
    {
        $result = service('tiket')->verifikasiTask($taskId);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function revisiTask($taskId)
    {
        $result = service('tiket')->revisiTask($taskId);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function selesaikanTugasKaur($slug)
    {
        $nipKaur = session('user_identifier');
        $result = service('tiket')->selesaikanTugasKaur($slug, $nipKaur);

        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function closeTicket($slug)
    {
        $result = service('tiket')->tutupTiket($slug);
        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }
}
