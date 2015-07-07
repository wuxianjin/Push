package com.baidu.push.motu;

import java.io.File;
import java.io.IOException;
import com.android.uiautomator.core.UiObject;
import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.core.UiSelector;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class Tag_24_All_ms extends UiAutomatorTestCase{
	public void testTag_24_All() throws UiObjectNotFoundException,InterruptedException,IOException {
		getUiDevice().pressHome();
		sleep(1000);
		getUiDevice().openNotification();
		sleep(1000);
		try{
		UiObject pushmsg = new UiObject(new UiSelector().text("百度魔图"));
		sleep(5000);
		// 反向验证---收不到消息
		assertFalse("pass", pushmsg.exists());
		}catch (Exception e){
			e.printStackTrace();
		}finally{
		File storeFile = new File("/data/local/tmp/push/motu/" + "motu.png");
		getUiDevice().takeScreenshot(storeFile);
		getUiDevice().pressBack();
		}
	}
}
