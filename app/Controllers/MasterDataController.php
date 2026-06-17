<?php

namespace App\Controllers;

class MasterDataController extends BaseController
{
    public function user()
    {
        $service = service('userManagement');
        $search = $this->request->getGet('search');
        $roleFilter = $this->request->getGet('role');

        $userRolesData = $service->getUserRoles($search, $roleFilter);

        $data = [
            'title' => 'Data User',
            'roles' => $service->getRoles(),
            'userRoles' => $userRolesData['data'],
            'pager' => $userRolesData['pager'],
            'users' => $service->getUsers(),
            'search' => $search,
            'roleFilter' => $roleFilter
        ];

        return view('manajemen/user/index', $data);
    }

    public function createRole()
    {
        $request = $this->request->getJSON(true);
        $result = service('userManagement')->createRole($request);

        return $this->response->setJSON([
            'status' => $result ? 'success' : 'fail',
            'message' => $result ? 'Role berhasil ditambahkan' : 'Gagal menambahkan role'
        ]);
    }

    public function createUserMapping()
    {
        $request = $this->request->getJSON(true);
        $result = service('userManagement')->createUserMapping($request);

        return $this->response->setJSON([
            'status' => $result ? 'success' : 'fail',
            'message' => $result ? 'Mapping user berhasil' : 'Gagal melakukan mapping'
        ]);
    }

    public function deleteUserMapping($id)
    {
        $result = service('userManagement')->deleteUserMapping($id);

        return $this->response->setJSON([
            'status' => $result ? 'success' : 'fail',
            'message' => $result ? 'Mapping berhasil dihapus' : 'Gagal menghapus mapping'
        ]);
    }

    public function kategori()
    {
        $layanan = service('layanan')->getLayanan();
        $group = [];

        foreach($layanan as $ly){
            $group[$ly['fk_kategori']][] = $ly;
        }   

        return view('manajemen/kategori/index', [
            'title' => 'Data Kategori',
            'kategori' => service('kategori')->getKategori(),
            'allLayanan' => $layanan,
            'group' => $group
        ]);
    }

    public function createKategori()
    {
        # Set method request for client to send form
        $request = $this->request->getJSON(true);

        # Check validation request
        if (!$this->validateData($request, 'kategoriRule')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'message' => 'Failed request'
                ]);
        }

        # Call function with instance on construct
        $result = service('kategori')->create($request);

        # Set status code berdasarkan return function
        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function createLayanan()
    {
        // validate automatically checks post and file data
        if (!$this->validate('layananRule')) {
            return $this->response->setStatusCode(422)->setJSON([
                'message' => 'Validasi gagal: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        $data = [
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'kebutuhan_dokumen' => $this->request->getPost('kebutuhan_dokumen'),
            'template_dokumen' => $this->request->getFile('template_dokumen')
        ];

        $result = service('layanan')->create($data);

        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }

    public function deleteKategori($id)
    {
        $result = service('kategori')->delete($id);

        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }
    public function deleteLayanan($id)
    {
        $result = service('layanan')->delete($id);

        $statusCode = $result['status'] === 'success' ? 200 : 500;

        return $this->response->setStatusCode($statusCode)->setJSON($result);
    }
}