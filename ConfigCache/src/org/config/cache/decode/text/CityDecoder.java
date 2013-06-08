package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.CityConfig;

/**
 * 城池配置表行解析器
 * @author chenjie
 * 2012-12-11
 */
public class CityDecoder extends AbstractDecoder<CityConfig>{


	@Override
	public CityConfig decode(StringArray values) {
		CityConfig config = new CityConfig();
		config.fromStringArray(values);
		return config;
	}

}
