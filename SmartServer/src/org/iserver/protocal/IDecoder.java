package org.iserver.protocal;

import org.iserver.data.Packet;

/**
 * @author chenjie
 * 2013-6-8
 */
public interface IDecoder<T> {

	public T decode(Packet packet);
	
}
