<?php

namespace app\modules\system\models\users;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\system\models\users\UsersOrders;

/**
 * UsersOrdersSearch represents the model behind the search form of `app\modules\system\models\users\UsersOrders`.
 */
class UsersOrdersSearch extends UsersOrders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sitetype', 'user_id'], 'integer'],
            [['url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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

        $query = (Yii::$app->user->identity->id === 1) ? UsersOrders::find() : UsersOrders::find()->where(['user_id' => Yii::$app->user->identity->id]);

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
            'sitetype' => $this->sitetype,
            'user_id' => $this->user_id
        ]);

        $query->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
