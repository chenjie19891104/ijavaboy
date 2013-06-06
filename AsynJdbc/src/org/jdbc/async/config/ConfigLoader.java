package org.jdbc.async.config;

import java.io.IOException;
import java.io.InputStream;
import java.util.Properties;

/**
 * 默认的配置文件解析类，默认从src目录下寻找配置文件
 * 
 * 如果需要将配置文件放到别的目录下面，则可以继承该类重写openInputStream方法
 * 
 * @author chenjie
 *
 */
public final class ConfigLoader {
	
	private static ConfigLoader instance = new ConfigLoader();
	
	private ConfigLoader(){}
	
	public static ConfigLoader getInstance(){
		
		return instance;
	}
	
	public SimpleConfig loadDefault(){
		
		return this.load("connection.properties");
	}
	
	/**
	 * 默认是src目录下
	 * @param path
	 * @return
	 */
	protected InputStream openInputStream(String path){
		
		 InputStream in = ConfigLoader.class.getClassLoader().getResourceAsStream(path);
		 
		 return in;
	}
	
	/**
	 * path : 这里就是文件名
	 */
	public final SimpleConfig load(String path){
		 
		 InputStream in = this.openInputStream(path);
		 
		 Properties p = new Properties();
		 try {
			p.load(in);
			
			SimpleConfig config = new SimpleConfig();
			config.setDriver(p.getProperty("driver"));
			config.setConnectionString(p.getProperty("jdbcUrl"));
			config.setUsername(p.getProperty("username"));
			config.setPassword(p.getProperty("password"));
			
			return config;
			
		} catch (IOException e) {

			e.printStackTrace();
		}
		 
		return null;
	}

}
