package org.config.cache.data;

import org.config.cache.StringArray;
import org.config.cache.core.IConfig;
import org.config.cache.utils.StringUtils;

/**
 * »´æ÷≈‰÷√±Ì
 * @author chenjie
 * 2012-12-14
 */
public class GlobalConfig implements IConfig {

	private String key;
	private String value;
	
	@Override
	public void fromStringArray(StringArray values) {
		
		key = values.getString();
		value = values.getString();
	}

	@Override
	public String getKey() {

		return key;
	}

	public final void setKey(String key) {
		this.key = key;
	}

	public final String getValue() {
		return value;
	}

	public final void setValue(String value) {
		this.value = value;
	}

	public String toString(){
		
		return StringUtils.toString(getClass(), this);
	}
}
