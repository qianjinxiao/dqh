<?php

namespace App\Admin\Repositories;

use App\Models\Farmland\FarmlandInfo as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class FarmlandInfo extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
