<?php

namespace App\Services;

use Illuminate\Support\Arr;

class SimInstallmentService
{
    private int $price_from;
    private float $lai_suat;
    public function __construct()
    {
        $constant = config('constant.sim_dep_tra_gop');
        $this->price_from = Arr::get($constant, 'price_from', 10000000);
        $this->lai_suat = Arr::get($constant, 'tra_gop.lai_suat');
    }

    public function transform($data): array
    {
        if(!empty($data)) {
            foreach ($data as $i=>$simItem) {
                if($this->isInstallment($simItem)) {
                    $data[$i] = [
                        ...$simItem,
                        'inslm_info'=> $this->calculateInstallment($simItem)
                    ];
                }
            }
        }
        return $data;
    }

    public function isInstallment(array $simItem): bool
    {
        if(!empty($simItem['pn'])) {
            if($simItem['pn'] >= $this->price_from){
                return true;
            }
        }
        return false;
    }

    public function calculateInstallment(array $simItem, int $traTruoc = 30, int $kyHan = 12): array | null
    {
        if (!empty($simItem['pn'])) {
            $soTienTraTruoc = ((int)$simItem['pn'] * $traTruoc) / 100;
            $soTienNo = (int)$simItem['pn'] - $soTienTraTruoc;
            $soTienMoiThang = ($soTienNo / $kyHan) * (1 + (($kyHan + 1) * $this->lai_suat) / 2);
            return [
                'so_tien_tra_truoc' =>  $soTienTraTruoc,
                'so_tien_no'        =>  $soTienNo,
                'so_tien_moi_thang' =>  round($soTienMoiThang, -3),
                'tra_truoc'         =>  $traTruoc,
                'ky_han'            =>  $kyHan
            ];
        }
        return null;
    }
}
