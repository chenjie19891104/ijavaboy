package com.ijavaboy.test;

import static org.junit.Assert.*;

import java.io.File;
import java.io.InputStream;
import java.net.URL;

import org.junit.Test;

import com.ijavaboy.config.AppConfig;
import com.ijavaboy.config.AppConfigManager;

/**
 * @author ijavaboy
 * @site <url>http://www.ijavaboy.com</url>
 * 2013-5-10
 */
public class AppConfigTest {

	@Test
	public void testConfigLoad() {
		
		try {
			AppConfigManager configManager = new AppConfigManager();
			
			URL path = this.getClass().getClassLoader().getResource("applications.xml");
			
			configManager.loadAllApplicationConfigs(path.toURI());
			
			for(AppConfig config : configManager.getConfigs()){
				System.out.println(config.getName() + ":" + config.getFile());
			}
			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

}
