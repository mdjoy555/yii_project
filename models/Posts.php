<?php
    namespace app\models;
    use Yii;
    use yii\db\Query;
    use yii\db\ActiveRecord;


    class Posts extends ActiveRecord{
        private $title;
        private $description;
        private $category;
        
        public static function tablename()
        {
            return 'posts';
        }

        public function rules()
        {
            return [
                    [['title','description','category'],'required'],
                ];
        }

        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'title' => 'Title',
                'description' => 'Description',
                'category' => 'Category'
            ];
        }
    }
?>