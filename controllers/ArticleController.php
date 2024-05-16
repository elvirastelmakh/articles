<?php
namespace app\controllers;

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

    public function actionList()  {
        $filter = (isset($_GET['filter']) && is_array($_GET['filter'])) ? $_GET['filter'] : [];
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $title = isset($filter['title']) ? $filter['title'] : null;
        $author = isset($filter['author']) ? $filter['author'] : null;
        $category = isset($filter['category']) ? $filter['category'] : null;

        $result = $this->articleRepository->findByCriteria($page, $title, $author, $category);
            
        return $result;
    }
    public function actionGet()  {
    }
}