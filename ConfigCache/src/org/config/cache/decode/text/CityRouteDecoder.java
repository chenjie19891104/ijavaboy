package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.CityRouteConfig;

/**
 * 城池路线表行解析器
 * @author chenjie
 * 2012-12-12
 */
public class CityRouteDecoder extends AbstractDecoder<CityRouteConfig> {

	@Override
	public CityRouteConfig decode(StringArray values) {
		CityRouteConfig config = new CityRouteConfig();
		config.fromStringArray(values);
		return config;
	}

}
