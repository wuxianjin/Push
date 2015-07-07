package com.baidu.push.motu;

import java.io.File;
import java.io.IOException;

import com.android.uiautomator.core.UiObject;
import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.core.UiSelector;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class Tag_4_None extends UiAutomatorTestCase {
	public void testTag_2_None() throws UiObjectNotFoundException,
			InterruptedException, IOException {
		getUiDevice().pressHome();
		sleep(1000);
		getUiDevice().openNotification();
		sleep(1000);
		try{
		UiObject pushmsg = new UiObject(new UiSelector().text("百度魔图"));
		pushmsg.clickAndWaitForNewWindow();
		sleep(5000);
		// 进入特效相机---已废弃 能打开消息即可
		// 判读是否首次打开
		/*UiObject sure = new UiObject(new UiSelector().text("确定"));
		if (sure.exists()) {
			sure.click();
		}*/
		}catch (Exception e){
			e.printStackTrace();
		}finally{
		File storeFile = new File("/data/local/tmp/push/motu/" + "motu.png");
		getUiDevice().takeScreenshot(storeFile);
		getUiDevice().pressBack();
		}
	}
}
