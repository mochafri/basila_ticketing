<div class="card mt-5 border-0 shadow-sm tiket-tabel">
    <table class="table align-middle mb-0">

        <thead>
            <tr>
                <th>ID</th>
                <th>NIM PEMOHON</th>
                <th>KATEGORI / LAYANAN</th>
                <th>DESKRIPSI</th>
                <th>TANGGAL</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $page = $tiket['pager']->getCurrentPage();
                $perPage = $tiket['pager']->getPerPage();
                $i = 1 + ($page - 1) * $perPage;
                foreach ($tiket['data'] as $data):
                $statusClass = '';
                switch ($data['tiket_status']) {
                    case 'Waiting':
                        $statusClass = 'bg-status-waiting';
                        break;
                    case 'Open':
                        $statusClass = 'bg-status-open';
                        break;
                    case 'In Progress':
                        $statusClass = 'bg-status-inprogress';
                        break;
                    case 'Closed':
                        $statusClass = 'bg-status-closed';
                        break;
                    case 'Rejected':
                        $statusClass = 'bg-status-rejected';
                        break;
                    default:
                        $statusClass = '';
                }
            ?>
                <tr>
                    <td class="tiket-id"><?= $i++ ?></td>
                    <td class="tiket-judul">
                        <?= $data['nip_creator'] ?>
                    </td>
                    <td class="tiket-kategori">
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-dark text-uppercase custom-small-font"><?= $data['kategori_layanan'] ?></span>
                            <span class="text-muted italic custom-small-font"><?= $data['per_kategori_layanan'] ?></span>
                        </div>
                    </td>
                    <td class="custom-small-font text-muted">
                        <?= strlen($data['deskripsi_permohonan']) > 50 ? substr(esc($data['deskripsi_permohonan']), 0, 50) . '...' : esc($data['deskripsi_permohonan']) ?>
                    </td>
                    <td class="tiket-tanggal">
                        <?= date('Y-m-d', strtotime($data['created_at'])) ?>
                    </td>
                    <td>
                        <span class="tiket-status-badge <?= $statusClass ?>">
                            <?= $data['tiket_status'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= site_url('tiket/' . $data['id']) ?>" class="tiket-btn-aksi">
                            <iconify-icon icon="hugeicons:arrow-right-02"></iconify-icon>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center p-4 pt-0">
        <div class="pager-info d-none d-md-block">
            <span class="text-secondary custom-small-font">
                Showing <b><?= (($tiket['pager']->getCurrentPage() - 1) * $tiket['pager']->getPerPage()) + 1 ?></b>
                to <b><?= min($tiket['pager']->getCurrentPage() * $tiket['pager']->getPerPage(), $tiket['pager']->getTotal()) ?></b>
                of <b><?= $tiket['pager']->getTotal() ?></b> entries
            </span>
        </div>
        <div>
            <?= $tiket['pager']->links('default', 'premium') ?>
        </div>
    </div>
</div>