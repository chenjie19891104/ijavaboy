package org.config.cache.core;

import java.util.List;

import org.config.cache.exception.SimpleConfigException;

/**
 * @author chenjie
 * 2012-12-13
 */
public abstract class AbstractListParser<E extends IConfig> implements IParser<List<E>> {

	protected IReader reader;
	
	protected IDecoder<E> decoder;
	
	public AbstractListParser(IReader reader, IDecoder<E> decoder){
		
		this.reader = reader;
		this.decoder = decoder;
	}
	
	@Override
	public abstract List<E> parse(String url) throws SimpleConfigException;

}
