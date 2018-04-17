<?php

namespace App\Repositories;

use App\Contracts\Repositories\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\{
    Collection, Model, ModelNotFoundException
};
use Illuminate\Contracts\Cache\Repository as CacheContract;

abstract class Repository implements RepositoryContract
{
    use Cacheable;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     * @throws RepositoryException
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->model = $this->makeModel();

        $this->setCacheRepository(
            $app->make(CacheContract::class)
        );
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $model;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param string|int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function update(array $data, $id)
    {
        $record = $this->show($id);

        return $record->update($data);
    }

    /**
     * @param string|int $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param int|string $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}