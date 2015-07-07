package com.baidu.push.motu;

import java.io.File;
import java.io.IOException;

import com.android.uiautomator.core.UiObject;
import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.core.UiSelector;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class Tag_24_sticker_en extends UiAutomatorTestCase{
	public void testTag_24_sticker() throws UiObjectNotFoundException,InterruptedException,IOException {
		getUiDevice().pressHome();
		sleep(1000);
		getUiDevice().openNotification();
		sleep(1000);
		try{
		UiObject pushmsg = new UiObject(new UiSelector().text("百度魔图"));
		pushmsg.clickAndWaitForNewWindow();
		sleep(5000);
		// 验证to_page=24 type=accessory
		UiObject check = new UiObject(new UiSelector().text("Sticker"));
		// System.out.println(check.exists());
		assertTrue("pass", check.exists());
		// 贴纸页—饰品贴纸页  图标应该是选中的
		UiObject check2 = new UiObject(new UiSelector()
				.className("android.widget.ImageButton").index(2)
				.selected(true));
		assertTrue("pass", check2.exists());
		}catch(Exception e){
			e.printStackTrace();
		}finally{
		File storeFile = new File("/data/local/tmp/push/motu/" + "motu.png");
		getUiDevice().takeScreenshot(storeFile);
		getUiDevice().pressBack();
		}
}
}
