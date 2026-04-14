<?php

namespace App\Services;

use \App\Models\Kaur;
use \App\Models\Staff;

class KaurService
{
    protected $kaur;
    protected $staff;

    public function __construct()
    {
        $this->kaur = new Kaur();
        $this->staff = new Staff();
    }

    public function getKaur()
    {
        $getKaur = $this->kaur->findAll();
        return $getKaur;
    }

    public function getStaff($nip)
    {
        $getId = $this->kaur->where('nip_kaur', $nip)->first();

        if (!isset($getId)) {
            return null;
        }

        $getStaff = $this->staff->where('fk_kaur', $getId['id'])->findAll();

        if (!isset($getStaff)) {
            return null;
        }

        return $getStaff;
    }
}
