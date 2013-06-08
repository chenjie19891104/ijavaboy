package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.CityTypeConfig;

/**
 * 城池类型配置表行解析器
 * @author chenjie
 * 2012-12-11
 */
public class CityTypeDecoder extends AbstractDecoder<CityTypeConfig>{

	@Override
	public CityTypeConfig decode(StringArray values) {
		
		CityTypeConfig config = new CityTypeConfig();
		config.fromStringArray(values);
		
		return config;
	}

}
