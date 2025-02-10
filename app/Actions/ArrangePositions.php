<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class ArrangePositions {
    public static function run(int $id) {
        DB::update("
        with RankedPositions AS (
            select id, row_number() over(order by hours asc) as p
            from proposals
            where project_id = :project
        )
        UPDATE proposals
        SET position = (select p from RankedPositions where proposals.id = RankedPositions.id)
        WHERE project_id = :project
    ", ['project' => $id]);
    }
}