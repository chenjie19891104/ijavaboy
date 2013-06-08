package org.config.cache.core;

import org.config.cache.exception.SimpleConfigException;

/**
 * 
 * @author chenjie
 * 2012-12-10
 */
public abstract class AbstractParser<E, T extends IConfig> implements IParser<E>{

	protected IReader reader;
	
	protected IDecoder<T> decoder;
	
	public AbstractParser(IReader reader, IDecoder<T> decoder){
		
		this.reader = reader;
		this.decoder = decoder;
	}
	
	/**
	 * 解析指定url的文件
	 */
	@Override
	public abstract E parse(String url) throws SimpleConfigException;

}
