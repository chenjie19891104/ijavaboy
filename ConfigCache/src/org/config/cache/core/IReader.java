package org.config.cache.core;

import org.config.cache.exception.SimpleConfigException;

/**
 * 文件读取接口
 * @author chenjie
 * 2012-12-10
 */
public interface IReader {
	
	public String read(String path) throws SimpleConfigException;

}
