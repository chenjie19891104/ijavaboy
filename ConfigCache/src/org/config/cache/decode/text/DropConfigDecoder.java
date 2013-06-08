package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.DropConfig;

/**
 * µôÂä±íÐÐ½âÎöÆ÷
 * @author chenjie
 * 2012-12-13
 */
public class DropConfigDecoder extends AbstractDecoder<DropConfig> {

	@Override
	public DropConfig decode(StringArray values) {
		DropConfig config = new DropConfig();
		config.fromStringArray(values);
		return config;
	}

}
