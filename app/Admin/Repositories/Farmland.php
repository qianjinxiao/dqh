<?php

namespace App\Admin\Repositories;

use App\Models\Farmland\Farmland as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Farmland extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
