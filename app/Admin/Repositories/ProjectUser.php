<?php

namespace App\Admin\Repositories;

use App\Models\ProjectUser as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ProjectUser extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
