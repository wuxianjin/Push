package com.baidu.push.motu;

import java.io.IOException;

import com.android.uiautomator.core.UiObject;
import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.core.UiScrollable;
import com.android.uiautomator.core.UiSelector;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class EnSwitch extends UiAutomatorTestCase{
	public void testEnSwitch() throws UiObjectNotFoundException,InterruptedException,IOException {
		getUiDevice().pressHome(); 
		UiObject setting = new UiObject(new UiSelector().text("设置"));  
	     setting.click();  
	     try {  
	            Thread.sleep(5000);  
	     } catch (InterruptedException e1) {  
	            e1.printStackTrace();  
	     }
	     UiScrollable Items = new UiScrollable( new UiSelector().scrollable(true));  
	     UiObject languageAndInputItem = Items.getChildByText(  
	                new UiSelector().text("语言和输入法"), "语言和输入法", true);  
	     languageAndInputItem.clickAndWaitForNewWindow();
	     UiObject laumethod = new UiObject(new UiSelector().text("语言"));
	     laumethod.clickAndWaitForNewWindow();
	     
	     UiScrollable LauItems = new UiScrollable( new UiSelector().scrollable(true));
	     UiObject en=LauItems.getChildByText(new UiSelector().text("English (United States)"), "English (United States)",true);
	     en.click();
	     getUiDevice().pressBack();
		 getUiDevice().pressBack();
		 sleep(5000);
	}
}
