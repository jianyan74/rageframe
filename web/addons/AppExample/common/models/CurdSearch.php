<?php

namespace addons\AppExample\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use addons\AppExample\common\models\Curd;

/**
 * CurdSearch represents the model behind the search form about `addons\AppExample\common\models\Curd`.
 */
class CurdSearch extends Curd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cate_id', 'manager_id', 'sort', 'position', 'sex', 'views', 'stat_time', 'end_time', 'status', 'append', 'updated'], 'integer'],
            [['title', 'content', 'cover', 'covers', 'attachfile', 'keywords', 'description', 'email', 'provinces', 'city', 'area', 'ip'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Curd::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cate_id' => $this->cate_id,
            'manager_id' => $this->manager_id,
            'sort' => $this->sort,
            'position' => $this->position,
            'sex' => $this->sex,
            'price' => $this->price,
            'views' => $this->views,
            'stat_time' => $this->stat_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'append' => $this->append,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'covers', $this->covers])
            ->andFilterWhere(['like', 'attachfile', $this->attachfile])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'provinces', $this->provinces])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
