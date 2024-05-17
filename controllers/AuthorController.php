<?php
namespace app\controllers;

use yii;
use yii\rest\ActiveController;
use app\repositories\AuthorRepository;

class AuthorController extends ActiveController
{
    public $modelClass = 'app\models\Author';

    protected AuthorRepository $authorRepository;

    public function __construct(
        $id,
        $module,
        $config = [],
        AuthorRepository $authorRepository
    ) {
        parent::__construct($id, $module, $config);
        $this->authorRepository = $authorRepository;
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
        $full_name = isset($filter['full_name']) ? trim($filter['full_name']) : null;
        $birth_year = isset($filter['birth_year']) ? intval($filter['birth_year']) : null;
        $biography = isset($filter['biography']) ? trim($filter['biography']) : null;

        $result = $this->authorRepository->findByCriteria($page, $full_name, $birth_year, $biography);
            
        return $result;
    }
}