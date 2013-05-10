package com.ijavaboy.config;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.net.URI;
import java.util.ArrayList;
import java.util.List;

import com.thoughtworks.xstream.XStream;
import com.thoughtworks.xstream.io.xml.DomDriver;

/**
 * @author ijavaboy
 * @site <url>http://www.ijavaboy.com</url>
 * 2013-5-10
 */
public class AppConfigManager {

	private List<AppConfig> configs;
	
	public AppConfigManager(){
		configs = new ArrayList<AppConfig>();
	}
	
	/**
	 * Load all application configs
	 * @param path
	 */
	public void loadAllApplicationConfigs(URI path){
		
		File file = new File(path);
		XStream xstream = getAppConfigXStreamDefine();
		try {
			AppConfigList configList = (AppConfigList)xstream.fromXML(new FileInputStream(file));
			
			if(configList.getConfigs() != null){
				this.configs.addAll(new ArrayList<AppConfig>(configList.getConfigs()));
			}
			
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
		
	}
	
	/**
	 * define the map between the AppConfig class and the config xml file
	 * @return
	 */
	private XStream getAppConfigXStreamDefine(){
		XStream xstream = new XStream(new DomDriver());
		xstream.alias("apps", AppConfigList.class);
		xstream.alias("app", AppConfig.class);
		xstream.aliasField("name", AppConfig.class, "name");
		xstream.aliasField("file", AppConfig.class, "file");
		xstream.addImplicitCollection(AppConfigList.class, "configs");
		return xstream;
	}

	public final List<AppConfig> getConfigs() {
		return configs;
	}
	
	public AppConfig getConfig(String name){
		for(AppConfig config : this.configs){
			if(config.getName().equalsIgnoreCase(name)){
				return config;
			}
		}
		return null;
	}
	
}
