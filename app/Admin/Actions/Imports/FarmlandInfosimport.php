<?php

namespace App\Admin\Actions\Imports;


use App\Models\Farmland\FarmlandInfo;
use App\Models\User;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FarmlandInfosimport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        // 0代表的是第一列 以此类推
        // $row 是每一行的数据
        foreach ($rows as $row) {
            $farmlandinfo = new FarmlandInfo([
                'villagers' => $row[0],
                'name' => $row[1],
                'address' => $row[2],
                'type' => $row[3],
                'mj1' => $row[4],
                'mj2' => $row[5],
                'mj3' => $row[6],
                'mj4' => $row[7],
                'mj5' => $row[8],
                'quo' => $row[9],
                'desc' => $row[10],
            ]);
            $farmlandinfo->save();
        }
//        dd(1);

    }


    /**
     * 从第几行开始处理数据 就是不处理标题
     * @return int
     */
    public function startRow(): int
    {
        return 4;
    }


}
