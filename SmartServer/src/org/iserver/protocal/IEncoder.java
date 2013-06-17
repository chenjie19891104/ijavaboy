package org.iserver.protocal;

import org.iserver.data.Packet;

/**
 * @author chenjie
 * 2013-6-8
 */
public interface IEncoder<T> {

	public Packet encode(T data);
}
