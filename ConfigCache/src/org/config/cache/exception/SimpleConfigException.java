package org.config.cache.exception;

/**
 * @author chenjie
 * 2012-12-5
 */
public class SimpleConfigException extends Exception {

	private static final long serialVersionUID = 8215584147745202456L;

	public SimpleConfigException(){
		super();
	}
	
	public SimpleConfigException(String msg){
		super(msg);
	}
	
	public SimpleConfigException(String msg, Throwable clause){
		super(msg, clause);
	}
	
	public SimpleConfigException(Throwable clause){
		super(clause);
	}
}
