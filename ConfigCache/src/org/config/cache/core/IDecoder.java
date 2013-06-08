package org.config.cache.core;

import org.config.cache.exception.SimpleConfigException;

/**
 * 对文件中的每一行单位进行解析
 * @author chenjie
 * 2012-12-10
 */
public interface IDecoder<T extends IConfig> {

	/**
	 * 如果是json格式，则item是一个json字符串如：{"name":"chenjie","id":"12"}；
	 * 如果是text格式，则item是文本中的一行，每一个元素以\t分隔
	 * @param item
	 * @return
	 * @throws SimpleConfigException
	 */
	public T decode(String item) throws SimpleConfigException; 
}
