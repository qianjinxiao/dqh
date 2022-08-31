<?php

namespace App\Admin\Repositories;

use App\Models\Rectification as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Rectification extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
