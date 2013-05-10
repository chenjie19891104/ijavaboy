package com.ijavaboy;

import com.ijavaboy.application.ApplicationManager;

/**
 * In this application, I simulated a simple application container that support hot deploy.
 * In most famous web server like tomcat,jboss and Glassfish, hot deploy is one of the basic features.
 * So, In this application, I tried to explain how the hot deploy work, and what's the theory in it.
 * 
 * If you want to know how to test the application, you can read the readme.txt file in the folder
 * 
 * @author ijavaboy
 * @site <url>http://www.ijavaboy.com</url>
 * 2013-5-10
 */
public class MainTest {

	public static void main(String[] args){
		
		Thread t = new Thread(new Runnable() {
			
			@Override
			public void run() {
				ApplicationManager manager = ApplicationManager.getInstance();
				manager.init();
			}
		});
		
		t.start();
		
		while(true){
			try {
				Thread.sleep(300);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}
	}
	
}
