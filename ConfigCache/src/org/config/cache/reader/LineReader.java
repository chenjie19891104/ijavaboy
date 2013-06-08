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
 * 按行读取，并加行分隔符
 * @author chenjie
 * 2012-12-10
 */
public class LineReader extends AbstractReader {

	private static final Logger logger = LoggerFactory.getLogger(LineReader.class);
	
	@Override
	protected String read(URL url) throws SimpleConfigException {
		
		if(url == null){
			logger.debug("The url is null");
			return null;
		}
		
		BufferedReader reader = null;
		
		try {

			InputStream input = url.openStream();
			reader = new BufferedReader(new InputStreamReader(input, "Unicode"));
			
			StringBuilder sb = new StringBuilder();
			String line = null;
			
			while((line = reader.readLine()) != null){
				
				sb.append(line).append("\n");
			}
			
			if(sb.length() > 0){
				sb.deleteCharAt(sb.length()-1); //删除最后一个换行符
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
