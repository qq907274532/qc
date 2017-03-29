<?php

    namespace Manager\Controller;

    class  LogisticsController extends AdminBaseController
    {

        private $model;

        public function __construct()
        {
            parent::__construct();

        }
        public function index(){
            $this->display();
        }
    }