<?php
    namespace app\models;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use app\models\Posts;

    class PostSearch extends Posts{

        public function rules()
        {
            return [
                [['id'],'integer'],
                [['title','description','category'],'safe']
            ];
        }

        public function scenarios()
        {
            return Model::scenarios();
        }

        public function search($params)
        {
            $query = Posts::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            $this->load($params);
            if(!$this->validate())
            {
                return $dataProvider;
            }
            $query->andFilterWhere(['id' => $this->id]);
            $query->orFilterWhere(['like','title',$this->title])
                  ->orFilterWhere(['like','description',$this->description])
                  ->orFilterWhere(['like','category',$this->category]);

            return $dataProvider;
        }
    }
?>