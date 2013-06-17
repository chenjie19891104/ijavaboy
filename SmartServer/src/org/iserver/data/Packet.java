package org.iserver.data;

import java.nio.channels.SocketChannel;
import java.util.List;

import org.iserver.protocal.ProtocalType;

/**
 * @author chenjie 2013-6-8
 */
public class Packet {

	private int protocalType;		//协议类型
	private SocketChannel sender;	//发送者
	private byte[] data;	//数据
	
	private List<SocketChannel> recipients;	//接收者

	public Packet(SocketChannel sender, byte[] data) {
		this.protocalType = ProtocalType.TEXT_PROTOCAL.getType();
		this.sender = sender;
		this.data = data;
	}
	
	public Packet(byte[] data){
		this.protocalType = ProtocalType.TEXT_PROTOCAL.getType();
		this.data = data;
	}

	public final SocketChannel getSender() {
		return sender;
	}

	public final void setSender(SocketChannel sender) {
		this.sender = sender;
	}

	public final byte[] getData() {
		return data;
	}

	public final void setData(byte[] data) {
		this.data = data;
	}

	public final int getProtocalType() {
		return protocalType;
	}

	public final void setProtocalType(int protocalType) {
		this.protocalType = protocalType;
	}

	public final List<SocketChannel> getRecipients() {
		return recipients;
	}

	public final void setRecipients(List<SocketChannel> recipients) {
		this.recipients = recipients;
	}
	
	

}
