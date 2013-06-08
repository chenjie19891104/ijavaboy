package org.config.cache.decode.text;

import org.config.cache.StringArray;
import org.config.cache.core.AbstractDecoder;
import org.config.cache.data.HeroConfig;

/**
 * ”¢–€≈‰÷√±Ì––Ω‚Œˆ∆˜
 * 
 * @author zhangchun 2012-12-10
 */
public class HeroDecoder extends AbstractDecoder<HeroConfig> {

	@Override
	public HeroConfig decode(StringArray values) {

		HeroConfig hero = new HeroConfig();
		hero.fromStringArray(values);
		return hero;
	}

}
