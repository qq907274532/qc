<?php

    namespace Manager\Controller;

    class  LogisticsController extends AdminBaseController
    {

        private $model;
        private $articleCateModel;

        public function __construct()
        {
            parent::__construct();
            $this->model = new ArticleModel();
            $this->articleCateModel = new ArticleCateModel();

        }
        public function index(){
            $this->display();
        }
    }