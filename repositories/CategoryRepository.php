<?php
namespace app\repositories;
use yii\data\Pagination;
use app\models\Category;

class CategoryRepository
{
    public function findByCriteria(
        int $page = 1, 
        ?string $title = null
    )  {
        $query = Category::find()->where('');
        if ($title){
            $likeConditionTitle = new \yii\db\conditions\LikeCondition('title', 'LIKE', '%' . $title . '%');
            $likeConditionTitle->setEscapingReplacements(false);
            $query->andWhere($likeConditionTitle);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $pages->setPage($page-1);
        $pages->pageSizeParam = false;
        $result = $query->orderBy('title')->offset($pages->offset)->limit($pages->limit)->all();
            
        return $result;
    }
}