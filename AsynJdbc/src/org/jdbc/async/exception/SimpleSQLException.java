package org.jdbc.async.exception;

/**
 * 收到底层的异常信息封装成本层异常并提交到上层。
 * @author chenjie
 * 2012-11-27
 */
@SuppressWarnings("serial")
public class SimpleSQLException extends Exception {
	
	public SimpleSQLException(){
		super();
	}
	
	public SimpleSQLException(String msg){
		super(msg);
	}
	
	public SimpleSQLException(String msg, Throwable clause){
		super(msg, clause);
	}
	
	public SimpleSQLException(Throwable clause){
		super(clause.getMessage(), clause);
	}

}
