<?php namespace Fully\Repositories\Category;

use Fully\Repositories\Category\CategoryInterface;

/**
 * Class AbstractCategoryDecorator
 * @package Fully\Repositories\Category
 * @author Sefa Karagöz
 */
abstract class AbstractCategoryDecorator implements CategoryInterface {

    /**
     * @var CategoryInterface
     */
    protected $category;

    /**
     * @param CategoryInterface $category
     */
    public function __construct(CategoryInterface $category) {

        $this->category = $category;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id) {

        return $this->category->find($id);
    }

    /**
     * @return mixed
     */
    public function all() {

        return $this->category->all();
    }

    /**
     * @param int $page
     * @param int $limit
     * @param bool $all
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false) {

        return $this->category->paginate($page = 1, $limit = 10, $all = false);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getArticlesBySlug($slug) {

        return $this->category->getArticlesBySlug($slug);
    }
}