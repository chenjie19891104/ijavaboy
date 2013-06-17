package org.iserver.data;

/**
 * @author chenjie
 * 2013-6-9
 */
public class Request {

	private String id;	//请求ID
	private Object params;	//请求内容
	
	private Session sender;	//发送者
	
	public Request(String id, Object params, Session sender){
		this.id = id;
		this.params = params;
		this.sender = sender;
	}
	

	public final String getId() {
		return id;
	}


	public final void setId(String id) {
		this.id = id;
	}


	public final Object getParams() {
		return params;
	}
	public final void setParams(Object params) {
		this.params = params;
	}
	public final Session getSender() {
		return sender;
	}
	public final void setSender(Session sender) {
		this.sender = sender;
	}
	
	
	
}
