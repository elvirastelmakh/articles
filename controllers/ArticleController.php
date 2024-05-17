<?php
namespace app\controllers;

use yii;
use yii\rest\ActiveController;
use app\repositories\ArticleRepository;

class ArticleController extends ActiveController
{
    public $modelClass = 'app\models\Article';

    protected ArticleRepository $articleRepository;

    public function __construct(
        $id,
        $module,
        $config = [],
        ArticleRepository $articleRepository
    ) {
        parent::__construct($id, $module, $config);
        $this->articleRepository = $articleRepository;
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
        $author = isset($filter['author']) ? trim($filter['author']) : null;
        $category = isset($filter['category']) ? trim($filter['category']) : null;

        $result = $this->articleRepository->findByCriteria($page, $title, $author, $category);

        return $result;
    }
}