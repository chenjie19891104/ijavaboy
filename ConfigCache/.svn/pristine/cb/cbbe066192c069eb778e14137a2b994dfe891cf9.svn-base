package org.config.cache.core;

import org.config.cache.ConfigEngine;
import org.config.cache.StringArray;
import org.config.cache.exception.SimpleConfigException;
import org.config.cache.utils.StringUtils;

/**
 * 抽象的解码类
 * @author chenjie
 * 2012-12-11
 */
public abstract class AbstractDecoder<T extends IConfig> implements IDecoder<T> {

	@Override
	public final T decode(String item) throws SimpleConfigException {
		
		StringArray values = StringUtils.split(item, ConfigEngine.DEFAULT_TEXT_DELIM);
		
		if(values == null || values.isCommentLine()){
			return null;
		}
		
		return this.decode(values);
	}
	
	public abstract T decode(StringArray values);

}
