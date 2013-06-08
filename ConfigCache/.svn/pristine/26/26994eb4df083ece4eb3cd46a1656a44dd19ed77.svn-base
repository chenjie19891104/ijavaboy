package org.config.cache.core;

import java.net.MalformedURLException;
import java.net.URL;

import org.config.cache.exception.SimpleConfigException;
import org.config.cache.utils.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * 读取文件抽象类
 * @author chenjie
 * 2012-12-5
 */
public abstract class AbstractReader implements IReader{
	private static final Logger logger = LoggerFactory.getLogger(AbstractReader.class);
	
	/**
	 * Read file from the specified url
	 * @param url
	 * @return
	 * @throws SimpleConfigException
	 */
	public final String read(String url) throws SimpleConfigException{
		
		if(StringUtils.isEmpty(url)){
			logger.debug("The url is null or empty");
			return null;
		}
		
		try {
			URL u = new URL(url);
			
			return this.read(u);
			
		} catch (MalformedURLException e) {
			
			throw new SimpleConfigException(e);
			
		}
		
		//return null;
	}

	protected abstract String read(URL url) throws SimpleConfigException;
}
