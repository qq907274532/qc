<?php
   namespace Manager\Controller;

   use Common\Model\JobApplyModel;
   use Common\Model\JobCateModel;
   use User\Model\UserModel;

   class JobApplyController extends AdminBaseController{
       private $model;
       private $jobCateModel;
       private $userModel;
       public function __construct() {
           parent::__construct();
           $this->model= new JobApplyModel();
           $this->jobCateModel= new JobCateModel();
           $this->userModel= new UserModel();

       }
       public function index(){
           $data=$this->page_com($this->model,['id'=>'desc']);
           $jobCateList=$this->jobCateModel->getJobCateList(['status'=>JobCateModel::STATUS_ENABLE]);
           $jobCateList=array_column($jobCateList,'name','id');
           $uidString=implode(',',array_unique(array_column($data['list'],'uid')));
           $userList=$this->userModel->getUserById($uidString);
           $userList=array_column($userList,'phone','id');
           foreach ($data['list'] as $k =>$v){
               $data['list'][$k]['typeName']='';
               $data['list'][$k]['userName']='';
               if(in_array($v['type'],array_keys($jobCateList))){
                   $data['list'][$k]['typeName']=$jobCateList[$v['type']];
               }
               if(in_array($v['uid'],array_keys($userList))){
                   $data['list'][$k]['userName']=$userList[$v['uid']];
               }
           }
           $this->assign('data',$data);
           $this->display();
       }
   }