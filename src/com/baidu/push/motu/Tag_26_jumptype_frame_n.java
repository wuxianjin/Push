package com.baidu.push.motu;

import java.io.File;
import java.io.IOException;

import com.android.uiautomator.core.UiObject;
import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.core.UiSelector;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class Tag_26_jumptype_frame_n extends UiAutomatorTestCase {
	public void testTag_26_jumptype_all() throws UiObjectNotFoundException,
			InterruptedException, IOException {

		getUiDevice().pressHome();
		sleep(1000);
		getUiDevice().openNotification();
		sleep(1000);
		try{
		UiObject pushmsg = new UiObject(new UiSelector().text("百度魔图"));
		pushmsg.clickAndWaitForNewWindow();
		sleep(5000);
		UiObject check = new UiObject(new UiSelector().text("我的素材"));
		// 相框管理页应该是选中的
		UiObject check2 = new UiObject(new UiSelector()
				.className("android.widget.ImageButton").index(1)
				.selected(true));

		assertTrue("pass", check.exists());
		assertTrue("pass", check2.exists());
		}catch(Exception e){
			e.printStackTrace();
		}finally{
		File storeFile = new File("/data/local/tmp/push/motu/" + "motu.png");
		getUiDevice().takeScreenshot(storeFile);
		getUiDevice().pressBack();
		getUiDevice().pressBack();
		}

	}
}
