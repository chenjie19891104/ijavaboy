package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.GlobalConfig;

/**
 * 全局配置表行解析器
 * @author chenjie
 * 2012-12-14
 */
public class GlobalConfigDecoder extends AbstractDecoder<GlobalConfig> {

	@Override
	public GlobalConfig decode(StringArray values) {
		GlobalConfig config = new GlobalConfig();
		config.fromStringArray(values);
		return config;
	}

}
