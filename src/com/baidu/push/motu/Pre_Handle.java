package com.baidu.push.motu;

import java.io.IOException;

import com.android.uiautomator.core.UiObjectNotFoundException;
import com.android.uiautomator.testrunner.UiAutomatorTestCase;

public class Pre_Handle extends UiAutomatorTestCase{
	public void testPre_Handle() throws UiObjectNotFoundException,InterruptedException,IOException {
		 getUiDevice().pressBack();
		 getUiDevice().pressBack();
		 getUiDevice().pressBack();
		 getUiDevice().pressBack();
	}
}
