<?php
namespace app\repositories;
use yii\data\Pagination;
use app\models\Author;

class AuthorRepository
{
    public function findByCriteria(
        int $page = 1, 
        ?string $full_name = null, 
        ?int $birth_year = null, 
        ?string $biography = null
    )  {
        $query = Author::find()->where('');
        if ($full_name){
            $likeConditionFio = new \yii\db\conditions\LikeCondition('full_name', 'LIKE', '%' . $full_name . '%');
            $likeConditionFio->setEscapingReplacements(false);
            $query->andWhere($likeConditionFio);
        }
        if ($birth_year){
            $query->andWhere('birth_year = :birth_year', [':birth_year' => $birth_year]);
        }
        if ($biography){
            $likeConditionBio = new \yii\db\conditions\LikeCondition('biography', 'LIKE', '%' . $biography . '%');
            $likeConditionBio->setEscapingReplacements(false);
            $query->andWhere($likeConditionBio);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $pages->setPage($page-1);
        $pages->pageSizeParam = false;
        $result = $query->orderBy('full_name')->offset($pages->offset)->limit($pages->limit)->all();
            
        return $result;
    }
}