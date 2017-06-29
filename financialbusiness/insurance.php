<?php
//保险类api
class insurance extends Financialbusiness{//定义油漆工类
	public function working(){//实现继承的工作方法

			$data=$this->input->get_post('data');//json格式
			echo $data;
			echo "保险类api\n";
	}


}
?>
