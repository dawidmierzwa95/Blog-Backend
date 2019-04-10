<?php namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     *
     * @return mixed
     */
    public function all();

    /**
     * Get specific record
     *
     * @param $id
     * @return mixed
     */
    public function show($id);

    /**
     * Create a new one
     *
     * @param $data
     * @return mixed
     */
    public function create($data);

    /**
     * Update record
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data);

    /**
     * Delete record
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
