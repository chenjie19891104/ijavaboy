package org.iserver.data;

import java.util.ArrayList;
import java.util.List;

/**
 * @author chenjie
 * 2013-6-9
 */
public class Response {

	private List<Session> recipients;	//接受者
	
	private String id;		//ID
	private Object params;	//参数
	
	public Response(){
		
	}
	
	public Response(String id, Object params){
		this.id = id;
		this.params = params;
	}
	
	public Response(String id, Object params, Session session){
		this.id = id;
		this.params = params;
		this.recipients = new ArrayList<Session>();
		this.recipients.add(session);
	}
	
	public Response(String id, Object params, List<Session> sessions){
		this.id = id;
		this.params = params;
		this.recipients = sessions;
	}
	
	public final List<Session> getRecipients() {
		return recipients;
	}
	public final void setRecipients(List<Session> recipients) {
		this.recipients = recipients;
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
