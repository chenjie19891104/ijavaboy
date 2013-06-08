package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.ItemConfig;

/**
 * 物品表行解析器
 * @author chenjie
 * 2012-12-12
 */
public class ItemDecoder extends AbstractDecoder<ItemConfig> {

	@Override
	public ItemConfig decode(StringArray values) {
		
		ItemConfig config = new ItemConfig();
		config.fromStringArray(values);
		
		System.out.println(config.toString());
		
		return config;
	}

}
