package org.iserver.event;

/**
 * @author chenjie
 * 2013-6-8
 */
public class ClientEvent {

	private int cmd;	//ÃüÁî
	private String params;	//²ÎÊı
	
	public ClientEvent(int cmd, String params){
		this.cmd = cmd;
		this.params = params;
	}
	
	public final int getCmd() {
		return cmd;
	}
	public final void setCmd(int cmd) {
		this.cmd = cmd;
	}
	public final String getParams() {
		return params;
	}
	public final void setParams(String params) {
		this.params = params;
	}
	
	
	
}
