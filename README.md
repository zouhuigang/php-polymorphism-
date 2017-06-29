### php多态的实现

好处：

	对修改封闭，对扩展开放



例如：对外暴露接口 

	URL+ financialbusiness/datahandler

	请求参数：

	type:credit|insurance 为financialbusiness文件夹下的子类

	data:任意json格式数据

	返回：

	根据子类返回不同的参数



实现了对外面只暴露了一个接口，可实现像贷款类，信用卡类等多种金融业务,类似Switch条件控制。

end...

	


