<?php
namespace app\controllers;

use yii\rest\ActiveController;
use app\repositories\CategoryRepository;

class CategoryController extends ActiveController
{
    public $modelClass = 'app\models\Category';

    protected CategoryRepository $categoryRepository;

    public function __construct(
        $id,
        $module,
        $config = [],
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($id, $module, $config);
        $this->categoryRepository = $categoryRepository;
    }

    public function actionList()  {
        $filter = (isset($_GET['filter']) && is_array($_GET['filter'])) ? $_GET['filter'] : [];
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $title = isset($filter['title']) ? $filter['title'] : null;

        $result = $this->categoryRepository->findByCriteria($page, $title);
            
        return $result;
    }
}