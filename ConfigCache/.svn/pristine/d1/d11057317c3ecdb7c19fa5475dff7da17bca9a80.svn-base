package org.config.cache.reader;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;

import org.config.cache.core.AbstractReader;
import org.config.cache.exception.SimpleConfigException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * 如果指定的数据源读取文件，普通读取方式，按行读取
 * @author chenjie
 * 2012-12-5
 */
public class SimpleReader extends AbstractReader{

	private static final Logger logger = LoggerFactory.getLogger(SimpleReader.class);
	
	@Override
	protected String read(URL url) throws SimpleConfigException{
		
		if(url == null){
			logger.debug("The url is null");
			return null;
		}
		
		BufferedReader reader = null;
		
		try {

			InputStream input = url.openStream();
			reader = new BufferedReader(new InputStreamReader(input));
			
			StringBuilder sb = new StringBuilder();
			String line = null;
			
			while((line = reader.readLine()) != null){
				
				sb.append(line);
			}
			
			return sb.toString();
			
		} catch (MalformedURLException e) {
			
			throw new SimpleConfigException(e);
			
		} catch (IOException e) {
			
			throw new SimpleConfigException(e);
			
		}finally{
			
			if(reader != null){
				try {
					
					reader.close();
					
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}

	}
}
