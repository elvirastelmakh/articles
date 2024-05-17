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
        $subQueryParents = (new \yii\db\Query())
            ->from(['c2'=> 'categories'])
            ->select(['title'])
            ->where('c2.id = categories.parent_id')
            ->limit(1);

        $query = Category::find();
        $query->select(['title', 'description',  'parent'=>$subQueryParents]);
        $query->where('');
        if ($title){
            $likeConditionTitle = new \yii\db\conditions\LikeCondition('title', 'LIKE', '%' . $title . '%');
            $likeConditionTitle->setEscapingReplacements(false);
            $query->andWhere($likeConditionTitle);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $pages->setPage($page-1);
        $pages->pageSizeParam = false;
        $result = $query->orderBy('title')->offset($pages->offset)->limit($pages->limit)->createCommand()->queryAll();
            
        return $result;
    }
}