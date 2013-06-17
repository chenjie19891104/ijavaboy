package org.iserver.protocal;

/**
 * @author chenjie
 * 2013-6-8
 */
public enum ProtocalType {

	TEXT_PROTOCAL(1),		//文本协议
	BINARY_PROTOCAL(2);	//二进制协议
	
	private int type;
	
	private ProtocalType(int type) {
		this.type = type;
	}

	public final int getType() {
		return type;
	}

	public final void setType(int type) {
		this.type = type;
	}
	
	
	
}
