<?php
class Financialbusiness extends CI_Controller{

		public function __construct(){
			parent::__construct('');
		    date_default_timezone_set('PRC'); //设置本地时区
		    $this->load->model("M_app","m_app",true);
			$this->load->model("Commonmodel","commonmodel",true);
			$this->getAllInclude();//包含文件	

			$this->predefinedClasses=array(
				"M_app","mysql","Publics","commonModel"
			);
		}

		private function getAllInclude(){
			//	require_once 'insurance.php';
			//  require_once 'credit.php';
			$basedir = dirname(__FILE__); //当前文件的目录
			foreach (glob($basedir."/financialbusiness/*.php") as $filename){
   				 require_once $filename;
		    }
		}

		// "多态的实现，对修改封闭，对扩展开放";
		public function datahandler(){
			//得到请求参数class类
			$typeClass=$this->input->get_post('type');//需过滤不存在的类

			//得到所有子类
			$userDefinedClasses=$this->getClass();
			//print_r($userDefinedClasses);die;
			if(!in_array($typeClass,$userDefinedClasses)){
					$this->msg['status'] = 501;
					$this->msg['info'] = '参数错误，请重新提交';
					$this->msg['data'] = (object)array();
					$this->publics->return_json($this->msg);
			}
	
			//过滤垃圾类别后得到有效子类,进入各自不同的方法
			$this->switchClassDispatcher(new $typeClass());
			
		}

		protected function working(){
				echo "本方法需要在子类中重载!";
		}

		//切换子类
		private function switchClassDispatcher($obj){//定义处理方法
				if($obj instanceof Financialbusiness){//进一步判断obj是否是Financialbusiness的子类
					$obj->working();
				}else{//否则显示错误信息
					echo "Error: 对象错误！";
				}	
		}

		//返回当前父类下，所有子类
		private function getClass(){
						//$aMethods = get_declared_classes();//得到所有类
						$userDefinedClasses = array_filter(get_declared_classes(),function($className) {
        													return !call_user_func(
           						 							array(new ReflectionClass($className), 'isInternal')
        											);}
						);

						//过滤CI_开头的class以及父类class
						$filtered = array_filter($userDefinedClasses, function($item){ 
									$search = '/^CI_*/';
									if(!preg_match($search,$item)) {
											return $item!=__CLASS__; 
									}
				
                 				
						});
						//再过滤一些定义的函数
						$filtered=array_diff($filtered, $this->predefinedClasses);
						return array_values($filtered);
		}
	
	
}



?> 

