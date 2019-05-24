<?php


namespace App\Utils;


use App\Models\User;

class OranizationUtils
{
    /**
     * @return mixed
     */
    public static function getMasters()
    {
        $userModel = self::getUserModel();

        return $userModel->where('jobtitle_id', MASTER_ROLE);
    }

    /**
     * @return mixed
     */
    public static function getManagers()
    {
        $userModel = self::getUserModel();

        return $userModel->where('jobtitle_id', MANAGER_ROLE);
    }

    /**
     * @return mixed
     */
    public static function getTeamLeaders()
    {
        $userModel = self::getUserModel();

        return $userModel->where('jobtitle_id', TEAMLEADER_ROLE);
    }

    private static function getUserModel($selects = ['*'], $conditions = [], $isGet = true)
    {
        $model = User::select($selects)
            ->where('contract_type', STAFF_CONTRACT_TYPES)
            ->where('status', ACTIVE_STATUS)->where($conditions);

        if ($isGet) {
            return $model->get();

        } else {
            return $model;
        }
    }
}
