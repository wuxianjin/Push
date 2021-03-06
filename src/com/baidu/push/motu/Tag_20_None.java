package com.baidu.push.motu;

import java.io.File;
import java.io.IOException;

import com.android.uiautomator.core.UiObject;
import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.core.UiSelector;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class Tag_20_None extends UiAutomatorTestCase{
	public void testTag_2_None() throws UiObjectNotFoundException,InterruptedException,IOException {
		getUiDevice().pressHome(); 
		sleep(1000);
		getUiDevice().openNotification();
		sleep(1000);
		try{
		UiObject pushmsg= new UiObject(new UiSelector().text("百度魔图"));
		pushmsg.clickAndWaitForNewWindow();
		sleep(5000);
		//验证：已经废弃 跳转韩国商店 无需额外验证
		} catch (Exception e){
			e.printStackTrace();
		}finally{
		
        	File storeFile=new File("/data/local/tmp/push/motu/"+"motu.png");
        	getUiDevice().takeScreenshot(storeFile);
        	getUiDevice().pressBack();
		}
	}
}
