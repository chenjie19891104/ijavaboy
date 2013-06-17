package org.iserver.protocal;

import org.iserver.data.Packet;

/**
 * @author chenjie
 * 2013-6-8
 */
public interface IProtocalHandler<T> {

	public Packet encode(T data);
	
	public T decode(Packet packet);
}
