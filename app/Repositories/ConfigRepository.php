<?php

namespace App\Repositories;

use App\Models\Config;
use App\Repositories\Contracts\IConfigRepository;

/**
 * ConfigRepository class
 * Author: jvb
 * Date: 2018/11/15 16:31
 */
class ConfigRepository extends AbstractRepository implements IConfigRepository
{
    /**
     * ConfigModel
     *
     * @var  string
     */
    protected $modelName = Config::class;
}
