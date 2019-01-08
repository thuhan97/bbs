<?php

namespace App\Services;

abstract class AbstractService
{
    /*
     * @var \App\Models\Model $model
     */
    protected $model;

    /*
     * @var \App\Repositories\Contracts\BaseRepository $repository
     */
    protected $repository;
}
