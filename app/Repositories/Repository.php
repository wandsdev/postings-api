<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findAll()
    {
        return $this->model->all();
    }

    /**
     * Get the specified model
     *
     * @param $id
     *
     * @return Model
     */
    public function find($id): Model
    {
        return $this->model->find($id);
    }

    /**
     * Create new Register
     *
     * @param array $params
     *
     * @return Model
     */
    public function create(array $params): Model
    {
        return $this->model->create($params);
    }

    /**
     * Update register
     *
     * @param array $params
     * @param $id
     *
     * @return Model
     */
    public function update(array $params, $id): Model
    {
        /** @var Model $model */
        $model = $this->model->find($id);
        $model->fill($params);
        $model->save();
        return $model;
    }

    /**
     * Delete the specified model
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id): int
    {
        return $this->model->destroy($id);
    }

}
