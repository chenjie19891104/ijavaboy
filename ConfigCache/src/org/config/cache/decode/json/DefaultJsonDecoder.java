package org.config.cache.decode.json;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import org.config.cache.core.IConfig;
import org.config.cache.core.IDecoder;
import org.config.cache.exception.SimpleConfigException;
import org.config.cache.utils.BeanUtils;
import org.config.cache.utils.StringUtils;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;

/**
 * 默认的Json格式的每一个JSONObject的解码类
 * @author chenjie
 * 2012-12-10
 */
public class DefaultJsonDecoder<T extends IConfig> implements IDecoder<T> {

	private Class<T> configClazz;
	
	public DefaultJsonDecoder(Class<T> config){
		this.configClazz = config;
	}
	
	@Override
	public T decode(String item) throws SimpleConfigException {
		
		if(StringUtils.isEmpty(item)){
			return null;
		}
		
		final JSONObject json = JSON.parseObject(item);
		
		if(json != null){
			List<Entry> values = new ArrayList<Entry>();
			Iterator<String> itor = json.keySet().iterator();
			while(itor.hasNext()){
				final String key = itor.next();
				final String val = json.getString(key);
				values.add(new Entry(key, val));
			}
			
			return BeanUtils.createBean(this.configClazz, values);
		}
		
		return null;
	}

	public static class Entry{
		String key;
		String value;
		
		Entry(String key, String value){
			this.key = key;
			this.value = value;
		}

		public final String getKey() {
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
		
		
	}
}
