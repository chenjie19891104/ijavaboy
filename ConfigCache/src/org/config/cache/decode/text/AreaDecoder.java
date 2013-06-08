package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.AreaConfig;

/**
 * 区域配置表行解析器
 * @author chenjie
 * 2012-12-10
 */
public class AreaDecoder extends AbstractDecoder<AreaConfig> {

	@Override
	public AreaConfig decode(StringArray values) {
		
		AreaConfig area = new AreaConfig();
		area.fromStringArray(values);
		return area;
	}

}
