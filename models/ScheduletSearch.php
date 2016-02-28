<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ScheduletSearch represents the model behind the search form about `app\models\Schedule`.
 */
class ScheduletSearch extends Schedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'visit', 'patient_id', 'doctor_id'], 'integer'],
            [['start_at', 'finish_at', 'created_at', 'comment', 'patient.user.fullname'], 'safe'],
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

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['patient.user.fullname']);
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
        $query = Schedule::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'visit' => $this->visit,
            //'start_at' => $this->start_at,
            //'finish_at' => $this->finish_at,
            'created_at' => $this->created_at,
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
        ]);

        if($this->finish_at){
            $query->andFilterWhere(['<=',  'finish_at', $this->finish_at]);
        }

        if($this->start_at){
            $query->andFilterWhere(['>=',  'start_at', $this->start_at]);
        }

        $query->orderBy(['start_at' => SORT_ASC]);
        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
