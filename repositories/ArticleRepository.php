<?php
namespace app\repositories;

use Yii;
use yii\data\Pagination;
use app\models\Article;

class ArticleRepository
{
    public function findByCriteria(
        int $page = 1, 
        ?string $title = null,
        ?string $author = null,
        ?string $category = null
    )  {
        $subQuery = (new \yii\db\Query())
            ->from(['ac'=> 'article_categories'])
            ->select(['ac.article_id as id', 'GROUP_CONCAT(c.title separator \', \') as categories']);
        $subQuery->join('JOIN', ['c' => 'categories'], 'c.id  = ac.category_id');
        $subQuery->groupBy('ac.article_id');


        $query = Article::find();
        $query->select(['title', 'authors.full_name as author', 'announcement', 'text', 'ac2.categories']);
        $query->join('JOIN', 'authors', 'articles.author_id = authors.id');
        $query->leftJoin(['ac2' => $subQuery], 'ac2.id = articles.id');

        $query = $query->where('');
        
        if ($title){
            $likeConditionFio = new \yii\db\conditions\LikeCondition('title', 'LIKE', '%' . $title . '%');
            $likeConditionFio->setEscapingReplacements(false);
            $query->andWhere($likeConditionFio);
        }
        if ($author){
            $likeConditionAuthor = new \yii\db\conditions\LikeCondition('authors.full_name', 'LIKE', '%' . $author . '%');
            $likeConditionAuthor->setEscapingReplacements(false);
            $query->andWhere($likeConditionAuthor);
        }
        if ( $category) {
            $categoryForLike = Yii::$app->db->quoteValue('%' . $category . '%');
            $sqlCategories = "WITH RECURSIVE
                cte AS ( SELECT id, parent_id, title path
                        FROM categories
                        WHERE title LIKE " . $categoryForLike . "
                    UNION ALL
                        SELECT c.id, c.parent_id, CONCAT(cte.path, ' / ', c.title)
                        FROM categories c
                        JOIN cte ON cte.id = c.parent_id )
                SELECT * FROM cte;";
            $categories = Yii::$app->db->createCommand($sqlCategories)->queryAll();
            if ( !is_array($categories ) || count($categories) == 0 || !isset($categories[0]['id']) ) {
                return [];
            }
            $categoryIds = implode(',', array_column($categories, 'id'));

            $sqlArticleCategories = "SELECT article_id
                FROM article_categories
                WHERE article_categories.category_id IN ($categoryIds)";
            $articleCategories = Yii::$app->db->createCommand($sqlArticleCategories)->queryAll();
            if ( !is_array($articleCategories ) || count($articleCategories) == 0 || !isset($articleCategories[0]['article_id']) ) {
                return [];
            }
            $articleIds = implode(',', array_column($articleCategories, 'article_id'));
            $query->andFilterWhere(['IN','articles.id', $articleIds]);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $pages->setPage($page-1);
        $pages->pageSizeParam = false;
        $result = $query->orderBy('title')->offset($pages->offset)->limit($pages->limit)->createCommand()->queryAll();
            
        return $result;
    }
}