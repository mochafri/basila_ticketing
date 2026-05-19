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

    # List tiket yang ada di table setiap user
    public function index(): string
    {
        $roles = [session('role_name')];
        $nip = session('user_identifier');
        $kategori = $this->request->getGet('kategori');
        $status = $this->request->getGet('status') ?? 'All';
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

    # Detail tiket
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

    public function create(): string
    {
        $client = \Config\Services::curlrequest();

        $fakultas = env("URL_FACULTY");

        $getFakultas = $client->get($fakultas, [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TOKEN'),
                'Content-Type' => 'application/json',
            ],
            'http_errors' => false
        ]);

        $statusCode = $getFakultas->getStatusCode();
        if ($statusCode == 401 || $statusCode == 403) {
            $data = [];
        } else {
            $response = json_decode($getFakultas->getBody(), true);
            $data = $response['data'] ?? $response;
        }

        return view('tiket/pengajuan/index', [
            'title' => 'Pengajuan Tiket',
            'kategori' => $this->kategoriService->getKategori(),
            'fakultas' => $data
        ]);
    }

    public function getLayananByID($slug)
    {
        $result = $this->layananService->getLayananById($slug);

        $statusCode = $result['status'] === 'success' ? 201 : 422;
        return response()->setStatusCode($statusCode)->setJSON($result);
    }

    public function getProdi($id)
    {
        $client = \Config\Services::curlrequest();
        $prodi = env("URL_PRODY");

        $getProdi = $client->get($prodi . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TOKEN'),
                'Content-Type' => 'application/json'
            ],
            'http_errors' => false
        ]);

        $statusCode = $getProdi->getStatusCode();
        if ($statusCode == 401 || $statusCode == 403) {
            $data = [];
        } else {
            $response = json_decode($getProdi->getBody(), true);
            $data = $response['data'] ?? $response;
        }

        return response()->setStatusCode(201)->setJSON($data);
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
        $data['fakultas'] = (session('fakultas') === '-' || empty(session('fakultas'))) ? $this->request->getPost('fakultas') : session('fakultas');
        $data['prodi'] = (session('prodi') === '-' || empty(session('prodi'))) ? $this->request->getPost('prodi') : session('prodi');
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
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'escalatedRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => 'Gagal eskalasi tiket'
            ]);
        }

        $result = $this->kabagService->isEscalated($slug, $data['notes_escalated']);
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

    public function acceptTask($slug)
    {
        $nip = session('user_identifier');
        $result = $this->kaurService->acceptTask($slug, $nip);
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
        $payload = $this->request->getJSON(true);
        $catatan = $payload['catatan'] ?? 'Mohon revisi pekerjaan Anda.';

        $result = $this->kaurService->revisiTask($taskId, $catatan);
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function selesaikanTugasKaur($slug)
    {
        $nip = session('user_identifier');
        $payload = $this->request->getJSON(true);
        $catatanPenyelesaian = $payload['catatan_penyelesaian'] ?? null;
        
        $result = $this->kaurService->selesaikanTugasKaur($slug, $nip, $catatanPenyelesaian);

        $statusCode = $result['status'] === 'success' ? 200 : 400;
        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function closeTicket($slug)
    {
        $payload = $this->request->getJSON(true);
        $catatanPenyelesaian = $payload['catatan_penyelesaian'] ?? null;
        
        $result = $this->kabagService->tutupTiket($slug, $catatanPenyelesaian);
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
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'escalatedRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => 'Gagal dalam menerima eskalasi tiket'
            ]);
        }

        $result = $this->eskalasiService->approveEscalated($slug, $data['notes_escalated']);

        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function rejectEscalated($slug)
    {
        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, 'escalatedRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'failed',
                'message' => 'Gagal menolak eskalasi tiket'
            ]);
        }

        $result = $this->eskalasiService->rejectEscalated($slug, $data['notes_escalated']);
        $statusCode = $result['status'] === 'success' ? 200 : 400;
        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function submitWorkLog($id)
    {
        $data = $this->request->getPost();
        $file = $this->request->getFile('bukti');

        if (!$this->validateData($data, 'workLogRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'fail',
                'message' => $this->validator->getErrors()
            ]);
        }

        $result = $this->riwayatService->addLog(
            $id,
            'Catatan Pekerjaan',
            $data['deskripsi'],
            session('username') ?? 'Staff',
            session('user_identifier'),
            $file
        );

        if ($result) {
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'message' => 'Berhasil menambahkan catatan pekerjaan'
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'status' => 'fail',
            'message' => 'Gagal menambahkan catatan pekerjaan'
        ]);
    }
    public function addLogNote($id)
    {
        $data = $this->request->getJSON(true);
        $note = $data['note'] ?? '';

        if (empty($note)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'fail',
                'message' => 'Catatan tidak boleh kosong'
            ]);
        }

        $result = $this->kaurService->addLogNote($id, $note);

        if ($result) {
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'message' => 'Catatan log berhasil ditambahkan'
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'status' => 'fail',
            'message' => 'Gagal menambahkan catatan log'
        ]);
    }

    public function updateCatatanKaur($slug)
    {
        $payload = $this->request->getJSON(true);
        $catatan = $payload['catatan_penyelesaian'] ?? '';

        $result = $this->kaurService->updateCatatanKaur($slug, $catatan);
        
        $statusCode = $result['status'] === 'success' ? 200 : 400;
        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }
}
