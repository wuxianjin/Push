<?php

class PushController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionShowPush()
	{
		/*
		$content="";
		$this->layout=false;
		$this->render('push_motu',array('content' => $content));
		 */
		$this->showPushPage("motu","android");
	}

	public function showPushPage($app,$label){
		$obj = new PushRecord();
		$obj->updateDB($label,$app);
		$result=$obj->getPushRecord($app,$label);
		$content="";
		if(!empty($result)){
		$length=count($result['time']);
		for($i=0;$i<$length;$i++){
		    if($result['status'][$i]=="doing"){
			$content.=htmlspecialchars("<tr><td>".$result['username'][$i]."</td><td>".$result['time'][$i]."</td><td>".$result['status'][$i]."</td><td>".$result['total_num'][$i]."</td><td>".$result['auto_num'][$i]."</td><td><a href=\"".$result['result_link'][$i]."\" class=\"bt btn-active btn-xs\">"."停止"."</a></td></tr>",ENT_QUOTES);
		    }else if($result['status'][$i]=="success"){
		    	$content.=htmlspecialchars("<tr><td>".$result['username'][$i]."</td><td>".$result['time'][$i]."</td><td>".$result['status'][$i]."</td><td>".$result['total_num'][$i]."</td><td>".$result['auto_num'][$i]."</td><td><a href=\"".$result['result_link'][$i]."\" target=\"_blank\" class=\"bt btn-active btn-xs\">"."查看结果"."</a></td></tr>",ENT_QUOTES);
		    }else{
			$content.=htmlspecialchars("<tr><td>".$result['username'][$i]."</td><td>".$result['time'][$i]."</td><td>".$result['status'][$i]."</td><td>".$result['total_num'][$i]."</td><td>".$result['auto_num'][$i]."</td><td><span class=\"bt btn-active btn-xs\">"."无结果"."</span></td></tr>",ENT_QUOTES);
		    }
		}
		}
		$obj= new PhoneInfo();
		$option=$obj->phoneOption();
		$this->layout=false;
		if($label=="android" && $app=="motu")
			$this->render('push_motu',array('content' => $content,'option' =>$option));

	}

	public function actionStartPush_Motu(){
		/*
		$time=date('Y-m-d H:i:s');
		$data = array('app_id'=>2487804,'message_title'=>'motu','tag_name'=>'3.2.1','message_desc'=>$time,'is_static'=>0,'to_page'=>24);  //定义参数	
		$data = @http_build_query($data);  //把参数转换成URL数据
		$aContext = array('http' => array('method' => 'POST',
			          'header'  => 'Content-type: application/x-www-form-urlencoded',
				  'content' => $data ));
		$cxContext  = stream_context_create($aContext);
		$sUrl = 'http://10.48.24.46:8080/push/push_motu.php';//推送接口
		$d = @file_get_contents($sUrl,false,$cxContext);
		$ret = json_decode($d,true);
		 */
		require_once("/home/chenyuan01/Baidu-Push-SDK-Php-2.0.4-advanced/Channel.class.php");
		$username=isset($_COOKIE['tsplat_user'])?$_COOKIE['tsplat_user']:"hacker";
		$authobj= new Authority();
		$authtype=$authobj->getAuthority($username);
		if($authtype !=100 && $authtype!=2){
		    $result['error']='22000';
		    echo json_encode($result);
		    return ;
		}
		$tag=$_GET['tag'];
		$phonename=$_GET['phonename'];
		$username=$_GET['username'];
		$phoneobj=new PhoneInfo();
		$phoneobj->setPhoneInfo($phonename,0,"推送自动化");
		$res=$phoneobj->getPhoneInfo($phonename);
		$imei=$res['device_id'];
		$api_key="EpNbxpoTPurhfxj8OS3RUDcD";
		$secret_key="a2xNF0SKuooXoFbsaWBGWBkUt9O6iau4";
		$channel = new Channel ($api_key, $secret_key) ;
		$push_type = 3;
		$optional[Channel::MESSAGE_TYPE] = 2;
		$pushcase = new MotuPushCase();
		$ret = $pushcase->getPushCaseInfo('motu');
		$total=$pushcase->getTotalCase('motu');
		$stoplink="/testservice/push?r=push/stopJob&tag=".$tag;
		$pushrecord = new PushRecord();
		$pushrecord->addPushRecord($username,$tag,"doing",$total,$total,$stoplink,"android","motu");
		//var_dump($ret);	
		
		foreach($ret as $key=>$r){
			//if($key!=36)
			//	continue;
			if($pushrecord->getJobStauts($tag,"android","motu")=="stoped")
				break;
			$push_time=date('Y-m-d_H:i:s');
			$add_fields = $r['add_fields'];
			$content = $r['content'];
			$exp_result = $r['exp_result'];
			$case_name = $r['case_name'];
			$case_id=$r['id'];
			$messages = array();
			if($add_fields=='none'){
				$messages = array(
					"description"=> '{"title":"百度魔图","description":"'.$push_time.'","custom_content":{'.$content.'}}'
				);
			}else{
				$tmp=array();
				$tmp=explode(":",$add_fields);
				if(count($tmp)==2){
				    $key=$tmp[0];
				    $value=$tmp[1];
				    $messages = array(
					"custom_content"=>array($key=>$value),
					"description"=> '{"title":"百度魔图","description":"'.$push_time.'","custom_content":{'.$content.'}}'
															                                    		  );
				}else if(count($tmp)==3){
				    $key1=$tmp[0];
				    $value2=$tmp[2];
				    $temp=array();
				    $temp=explode(" ",$tmp[1]);
				    $value1=$temp[0];
				    $key2=$temp[1];
				    $messages = array(
					"custom_content"=>array($key1=>$value1,$key2=>$value2),
					"description"=> '{"title":"百度魔图","description":"'.$push_time.'","custom_content":{'.$content.'}}'
				    );
				}
			}
			$message = ''.json_encode($messages);

			$message_keys="msg_key";
			if($case_id==1){
				$cmd="cd /home/chenyuan01/qa/zhl/Push; sudo sh ./prehandle.sh ".$imei;
				exec($cmd);
			}	
			$re = $channel->pushMessage($push_type, $message, $message_keys, $optional);
			if(isset($re['response_params']['success_amount']) && $re['response_params']['success_amount']==1){
				//$case_id=$r['id'];
				$cmd="cd /home/chenyuan01/qa/zhl/Push; sudo sh ./run_push.sh ".$imei." ".$tag." ".$case_id." ".$push_time." ".$total." ".$case_name." ".$content." '".$add_fields."' ".$exp_result;
				sleep(10);
				//var_dump($cmd);
				exec($cmd);
			}
			//var_dump($messages);	
		}
		 
		$phoneobj->setPhoneInfo($phonename,1,"");
		$result['error']=0;
		echo json_encode($result);
	}

	public function actionStopJob(){
		$username=isset($_COOKIE['tsplat_user'])?$_COOKIE['tsplat_user']:"hacker";
		$authobj= new Authority();
		$authtype=$authobj->getAuthority($username);
		if($authtype !=100 && $authtype!=2){
		    $result['error']='22000';
		    echo json_encode($result);
		    return ;
		}
		$tag=$_GET['tag'];
		$label="android";
		$app="motu";
		$pushrecord= new PushRecord();
		//$pushrecord->setJobStatus($tag,$label,$app);
		$ret=PushRecord::model()->findByAttributes(array('status'=>'doing','time'=>$tag,'label'=>$label,'product'=>$app));
		if($ret!=null){
			$ret->status="stoped";
			$ret->result_link="";
			$ret->save();
			$phonename="googleNexus 4";
			$phoneobj->setPhoneInfo($phonename,1,"");
		}
		header("Location:http://172.22.142.242/testservice/push/?r=push/showPush");
	}
	
	public function actionShowResult(){
		$tag=$_GET['tag'];
		$app=$_GET['remarks'];
	        $cur_page=$_GET['cur_page'];
	        $page_size=$_GET['page_size'];
	        $label=$_GET['label'];
	        $caseobj=new PushResult();
	        $result=$caseobj->getPushResultByPage($app,$label,$tag,$cur_page,$page_size);
	        $total_case=$caseobj->getTotalCase($tag,$label,$app);
	        $total_page=(int)($total_case/$page_size)+1;
	        $page_list=$this->getPageList($tag,$app,$total_page,$cur_page,$page_size,$label);
	        $offset=($cur_page-1)*$page_size;
	        $content="";
	        if(!empty($result)){
	            $length=count($result['content']);
		    for($i=0;$i<$length;$i++){
			if($result['result_pic'][$i] != " "){
				$content.=htmlspecialchars("<tr><td>".($offset+$i+1)."</td><td>".$result['time'][$i]."</td><td>".$result['content'][$i]."</td><td>".$result['add_fields'][$i]."</td><td>".$result['exp_result'][$i]."</td><td>".$result['is_auto'][$i]."</td><td>".$result['result'][$i]."</td><td><a href=\"".$result['result_pic'][$i]."\" target=\"_blank\" class=\"bt btn-active btn-xs\">"."截图"."</a></td></tr>",ENT_QUOTES);
			}else{
				$content.=htmlspecialchars("<tr><td>".($offset+$i+1)."</td><td>".$result['time'][$i]."</td><td>".$result['content'][$i]."</td><td>".$result['add_fields'][$i]."</td><td>".$result['exp_result'][$i]."</td><td>".$result['is_auto'][$i]."</td><td>".$result['result'][$i]."</td><td><span class=\"bt btn-active btn-xs\">"."截图"."</span></td></tr>",ENT_QUOTES);
			}
		    }
		}
		$this->layout=false;
                $this->render('push_result',array('content' => $content,'page_list' => $page_list,'total_case' => $total_case,'label' => $label));
	}

	public function getPageList($tag,$app,$total_page,$cur_page,$page_size,$label){
		$pre="";
		$html="";
		$next="";
		if($cur_page>1){
		    $pre=htmlspecialchars("<a href="."\"/testservice/push?r=push/showResult&tag=".$tag."&remarks=".$app."&cur_page=".($cur_page-1)."&page_size=".$page_size."&label=".$label."\">"."<"." </a>",ENT_QUOTES);
		}else{												        
		    $pre=htmlspecialchars("<span> < </span>",ENT_QUOTES);
	        }
	        if($cur_page<$total_page){
	            $next=htmlspecialchars("<a href="."\"/testservice/push?r=push/showResult&tag=".$tag."&remarks=".$app."&cur_page=".($cur_page+1)."&page_size=".$page_size."&label=".$label."\">"." > </a>",ENT_QUOTES);
		}else{
	            $next=htmlspecialchars("<span> > </span>",ENT_QUOTES);
	        }
	        for($i=1;$i<=$total_page;$i++){
	            if($i==$cur_page){
	                $html.=htmlspecialchars("<span class=\"active\">".$i." </span>",ENT_QUOTES);
	            }else{
	                $html.=htmlspecialchars("<a href="."\"/testservice/push?r=push/showResult&tag=".$tag."&remarks=".$app."&cur_page=".$i."&page_size=".$page_size."&label=".$label."\">".$i." </a>",ENT_QUOTES);
		    }
		}
		return $pre.$html.$next;
        }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
