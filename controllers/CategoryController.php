<?php
namespace app\controllers;

use yii;
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

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return $this->asJson($result);
    }

    public function actionList()  {
        $filter = Yii::$app->request->get('filter');
        $filter = (isset($filter)) && is_array($filter) ? $filter : [];
        $page = (Yii::$app->request->get('page')) ? intval(Yii::$app->request->get('page')) : 1;
        $title = isset($filter['title']) ? trim($filter['title']) : null;

        $result = $this->categoryRepository->findByCriteria($page, $title);

        return $result;
    }
}