package org.jdbc.async.cache;

/**
 * »º³å½Ó¿Ú
 * @author chenjie
 * 2012-11-30
 */
public interface CacheList<T> {
	
	public T read();
	
	public void write(T data);

}
