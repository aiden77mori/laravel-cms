<?php namespace Fully\Repositories;

/**
 * Interface CrudableInterface
 * @package Fully\Repositories
 * @author Sefa Karagöz
 */
interface CrudableInterface {

    /**
     * Get data by id
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create new data
     * @param $attributes
     * @return mixed
     */
    public function create($attributes);

    /**
     * Update data
     * @param $id
     * @param $attributes
     * @return mixed
     */
    public function update($id, $attributes);

    /**
     * Delete data by id
     * @param $id
     * @return mixed
     */
    public function delete($id);
}