package demo.cluster.utils;

import java.io.IOException;
import java.io.InputStream;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Properties;

public class PropertiesUtils {
	
	/**
	 * 读取properties文件,返回Map
	 * @param in
	 * @return
	 */
	@SuppressWarnings("rawtypes")
	public static Map<String, String> read(InputStream in){
		//InputStream in = PropertiesUtils.class.getClassLoader().getResourceAsStream("cluster-server.properties");
		
		Properties config = new Properties();
		
		try {
			config.load(in);
			
			
			
		} catch (IOException e) {
			e.printStackTrace();
		}finally{
			try {
				if(in != null){
					in.close();
				}
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		
		Map<String, String> result = new HashMap<String, String>();
		
		Iterator keys = config.keySet().iterator();
		
		while(keys.hasNext()){
			String key = (String)keys.next();
			result.put(key, config.getProperty(key));
		}
		
		return result;
	}
	
}
