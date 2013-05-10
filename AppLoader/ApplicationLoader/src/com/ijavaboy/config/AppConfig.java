package com.ijavaboy.config;

/**
 * @author ijavaboy
 * @site <url>http://www.ijavaboy.com</url>
 * 2013-5-10
 */
public class AppConfig {
	
	private String name;	//the name of the application, It's the folder in the applications for every application
	
	private String file;	//the whole name(the package and the class) of the application,for example:com.ijavaboy.example.ExampleApplication

	public final String getName() {
		return name;
	}

	public final void setName(String name) {
		this.name = name;
	}

	public final String getFile() {
		return file;
	}

	public final void setFile(String file) {
		this.file = file;
	}

	
}
