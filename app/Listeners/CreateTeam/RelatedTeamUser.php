<?php

namespace App\Listeners\CreateTeam;

use App\Events\CreateTeam;
use App\TeamUser;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\BaseException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RelatedTeamUser
{

    public function handle(CreateTeam $event)
    {
        $this->RelatedTeamUser(explode(",", $event->user_list), $event->team->id);
    }

    public function RelatedTeamUser($user_list, $team_id)
    {
        DB::beginTransaction();
        try {
            if (is_array($user_list)) {
                foreach ($user_list as $user_id) {
                    TeamUser::create([
                        'team_id' => $team_id,
                        'user_id' => $user_id
                    ]);
                }
            } else {
                TeamUser::create([
                    'team_id' => $team_id,
                    'user_id' => $user_list
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new BaseException([
                'msg' => '队伍成员关联失败'
            ], 408);
        }
    }
}
