package com.baidu.push.motu;

import java.io.IOException;

import com.android.uiautomator.core.UiObject;
import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.core.UiScrollable;
import com.android.uiautomator.core.UiSelector;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class ChSwitch extends UiAutomatorTestCase{
	public void testChSwitch() throws UiObjectNotFoundException,InterruptedException,IOException {
		getUiDevice().pressHome(); 
		UiObject setting = new UiObject(new UiSelector().text("Settings"));  
	     setting.click();  
	     try {  
	            Thread.sleep(5000);  
	     } catch (InterruptedException e1) {  
	            e1.printStackTrace();  
	     }
	     UiScrollable Items = new UiScrollable( new UiSelector().scrollable(true));  
	     UiObject languageAndInputItem = Items.getChildByText(new UiSelector().text("Language & input"), "Language & input", true);
	     languageAndInputItem.clickAndWaitForNewWindow();
	     UiObject laumethod = new UiObject(new UiSelector().text("Language"));
	     laumethod.clickAndWaitForNewWindow();
	     
	     UiScrollable lauItems = new UiScrollable( new UiSelector().scrollable(true));
	     UiObject ch = lauItems.getChildByText(new UiSelector().text("中文 (简体)"),"中文 (简体)",true);
	     ch.click();
	     getUiDevice().pressBack();
		 getUiDevice().pressBack();
	}
}
