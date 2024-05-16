<?php
namespace app\controllers;

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

    public function actionList()  {
        $filter = (isset($_GET['filter']) && is_array($_GET['filter'])) ? $_GET['filter'] : [];
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $full_name = isset($filter['full_name']) ? $filter['full_name'] : null;
        $birth_year = isset($filter['birth_year']) ? intval($filter['birth_year']) : null;
        $biography = isset($filter['biography']) ? $filter['biography'] : null;

        $result = $this->authorRepository->findByCriteria($page, $full_name, $birth_year, $biography);
            
        return $result;
    }
}