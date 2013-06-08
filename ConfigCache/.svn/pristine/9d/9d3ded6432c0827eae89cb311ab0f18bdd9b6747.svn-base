package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.ItemExtendConfig;

/**
 * 物品扩展表行解析器
 * @author zhangchun
 * 2012-12-12
 */
public class ItemExtendDecoder extends AbstractDecoder<ItemExtendConfig> {

	@Override
	public ItemExtendConfig decode(StringArray values) {
		
		ItemExtendConfig config = new ItemExtendConfig();
		config.fromStringArray(values);
		
		System.out.println(config.toString());
		
		return config;
	}

}
