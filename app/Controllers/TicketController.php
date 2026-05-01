<?php

namespace App\Controllers;

class TicketController extends BaseController
{
    protected $tiketService;
    protected $kaurService;
    protected $kabagService;
    protected $staffService;
    protected $layananService;
    protected $kategoriService;
    protected $riwayatService;
    protected $eskalasiService;

    public function __construct()
    {
        $this->tiketService = service('tiket');
        $this->kaurService = service('kaur');
        $this->kabagService = service('kabag');
        $this->staffService = service('staff');
        $this->layananService = service('layanan');
        $this->kategoriService = service('kategori');
        $this->riwayatService = service('riwayat');
        $this->eskalasiService = service('eskalasi');
    }

    public function index(): string
    {
        $roles = [session('role_name')];
        $nip = session('user_identifier');
        $kategori = $this->request->getGet('kategori');
        $status = $this->request->getGet('status') ?? 'Active';
        $search = $this->request->getGet('search');

        return view('tiket/daftar/index', [
            'title' => 'Daftar Tiket',
            'tiket' => $this->tiketService->getDataTiket($roles, $nip, $kategori, $status, $search),
            'categories' => $this->kategoriService->getKategori(),
            'filter_kategori' => $kategori,
            'filter_status' => $status,
            'search' => $search
        ]);
    }

    public function create(): string
    {
        return view('tiket/pengajuan/index', [
            'title' => 'Pengajuan Tiket',
            'kategori' => $this->kategoriService->getKategori(),
        ]);
    }

    public function getLayananByID($slug)
    {
        $result = $this->layananService->getLayananById($slug);

        $statusCode = $result['status'] === 'success' ? 201 : 422;
        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function show($slug): string
    {
        $nip = session('user_identifier');

        return view('tiket/daftar/detail', [
            'title' => 'Detail Tiket',
            'detail' => $this->tiketService->showTiket($slug),
            'kaur' => $this->kabagService->getKaur() ?? [],
            'staff' => $this->kaurService->getStaff($nip) ?? [],
            'taskStaff' => $this->staffService->getTaskStaff($slug, $nip),
            'taskStaffOnKaur' => $this->kaurService->getTaskStaffOnKaur($slug, $nip) ?? [],
            'allTaskStaffOnKaur' => $this->kaurService->getAllTaskStaffByTiket($slug) ?? [],
            'kaurByTiketOpen' => $this->kabagService->getKaurByTiketOpen($slug),
            'riwayat' => $this->riwayatService->getRiwayat($slug) ?? [],
        ]);
    }

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

    public function createTiket()
    {
        $data = $this->request->getPost();
        $data['fakultas'] = session('fakultas');
        $data['prodi'] = session('prodi');
        $username = session('username');

        if (!$this->validateData($data, 'tiketRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Failed request',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $file = $this->request->getFile('lampiran_dokumen');
        $result = $this->tiketService->create($data, $file, $username);

        if ($result['status'] === 'success') {
            return $this->response->setStatusCode(200)->setJSON($result);
        }

        return redirect()->back()->with('failed', 'Gagal membuat tiket.');
    }

    public function approveTiket($slug)
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'approveRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => 'Gagal approve tiket'
            ]);
        }

        $result = $this->kabagService->assignTiket($data, $slug);

        if ($result['status'] === 'success') {
            return $this->response->setStatusCode(200)->setJSON($result);
        }

        return $this->response->setStatusCode(400)->setJSON($result);
    }

    public function rejectTiket($slug)
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'rejectRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => 'Gagal reject tiket'
            ]);
        }

        $result = $this->kabagService->rejectTiket($slug, $data['catatan']);
        $statusCode = $result['status'] === 'success' ? 200 : 422;

        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function escalated($slug)
    {
        $result = $this->kabagService->isEscalated($slug);
        $statusCode = $result['status'] === 'success' ? 200 : 422;

        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function approveTask($slug)
    {
        $nip = session('user_identifier');
        $result = $this->kaurService->approveTask($slug, $nip);

        $statusCode = $result['status'] === 'success' ? 200 : 422;
        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function assignTiket($slug)
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'assignTaskRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => $this->validator->getErrors()
            ]);
        }

        $nip = session('user_identifier');
        $result = $this->kaurService->assignToStaff($slug, $data, $nip);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function uploadTask($slug)
    {
        $data = $this->request->getPost();
        $file = $this->request->getFile('dokumen_task');
        $nip = session('user_identifier');

        if (!$this->validateData($data, 'uploadTaskRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => $this->validator->getErrors()
            ]);
        }

        $nip = session('user_identifier');
        $result = $this->staffService->updateTask($slug, $data, $file, $nip);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function verifikasiTask($taskId)
    {
        $result = $this->kaurService->verifikasiTask($taskId);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function revisiTask($taskId)
    {
        $result = $this->kaurService->revisiTask($taskId);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function selesaikanTugasKaur($slug)
    {
        $nip = session('user_identifier');
        $result = $this->kaurService->selesaikanTugasKaur($slug, $nip);

        $statusCode = $result['status'] === 'success' ? 200 : 400;
        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function closeTicket($slug)
    {
        $result = $this->kabagService->tutupTiket($slug);
        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function updateTaskInstruction($taskId)
    {
        $data = $this->request->getJSON(true);
        $instruction = $data['instruction'] ?? '';

        if (empty($instruction)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'fail',
                'message' => 'Instruksi tidak boleh kosong'
            ]);
        }

        $result = $this->kaurService->updateInstruction($taskId, $instruction);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function revisiKaur()
    {
        $payload = $this->request->getJSON(true);
        $id = $payload['assign_id'] ?? null;
        $catatan = $payload['catatan'] ?? null;

        if (!$id) {
             return $this->response->setStatusCode(400)->setJSON([
                'status' => 'fail',
                'message' => 'ID penugasan tidak ditemukan'
            ]);
        }
        $result = $this->kabagService->tolakHasilKaur($id, $catatan);
        $statusCode = $result['status'] === 'success' ? 200 : 422;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function approveEscalated($slug)
    {
        $result = $this->eskalasiService->approveEscalated($slug);

        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function rejectEscalated($slug)
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'rejectRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => 'Gagal reject tiket'
            ]);
        }

        $result = $this->eskalasiService->rejectEscalated($slug, $data['catatan']);
        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }
}
