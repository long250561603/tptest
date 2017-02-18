<?php 
/**
	 * 邮件发送函数
	 * @param  string $to      邮件接收者
	 * @param  string $from    邮件发送者
	 * @param  string $content 邮件内容
	 * @return 无         
	 */
	function sendMail($to, $from, $content){
		/*
		 * sohu 邮箱测试：smtp.sohu.com
		 * username: gogery@sohu.com
		 * password: php1234
		*/

		header("Content-type:text/html;charset=utf-8");
		//引入邮件类
		require './class.phpmailer.php';
		
		$mail = new PHPMailer();

		/*服务器相关信息*/
		$mail->IsSMTP();    //设置使用SMTP服务器发送
		$mail->SMTPAuth   = true;     //开启SMTP认证
		//设置 SMTP 服务器,自己注册邮箱服务器地址
		$mail->Host       = 'smtp.sohu.com';   

		// 自己配置  在搜狐注册的账号
		$mail->Username   = 'gogery';  	//发信人的邮箱用户名
		$mail->Password   = 'php1234';  //发信人的邮箱密码

		/*内容信息*/
		//指定邮件内容格式为：html
		// 邮件内容是否支持html标签
		$mail->IsHTML(true); 	
		$mail->CharSet    ="UTF-8";	//编码
		$mail->From       = 'gogery@sohu.com';	 //发件人完整的邮箱名称
		$mail->FromName   = $from;	//发信人署名
		$mail->Subject    = "PHP邮件测试";  	 //信的标题
		$mail->MsgHTML( $content );  	//发信主体内容
		$mail->AddAttachment("2.gif"); //附件

		//发送邮件
		$mail->AddAddress( $to );  //收件人地址
				
		//使用send方法进行发送
		if( $mail->Send() ) {

		  	echo "success";

		} else {
		    	//如果发送失败，则返回错误提示	
		    	
		    	echo $mail->ErrorInfo;
		    	
		}

	}
	sendMail('250561603@qq.com', 'php17', '测试内容');


 ?>