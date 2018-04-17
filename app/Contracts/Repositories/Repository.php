<?php

namespace App\Contracts\Repositories;

use App\Repositories\RepositoryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

interface Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string;

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel();

    /**
     * @return Collection
     */
    public function all();

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param string|int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function update(array $data, $id);

    /**
     * @param string|int $id
     * @return int
     */
    public function delete($id);

    /**
     * @param int|string $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function show($id);
}