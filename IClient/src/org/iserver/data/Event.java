package org.iserver.data;

/**
 * @author chenjie
 * 2013-6-13
 */
public class Event {

	private String id;	
	private Object params;
	
	public Event(){
		
	}
	
	public Event(String id, Object params){
		this.id = id;
		this.params = params;
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
	
	
	
}
