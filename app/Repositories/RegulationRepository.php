<?php

namespace App\Repositories;

use App\Models\Regulation;
use App\Repositories\Contracts\IRegulationRepository;

/**
 * RegulationRepository class
 * Author: jvb
 * Date: 2019/01/11 09:23
 */
class RegulationRepository extends AbstractRepository implements IRegulationRepository
{
    /**
     * RegulationModel
     *
     * @var  string
     */
    protected $modelName = Regulation::class;
}
