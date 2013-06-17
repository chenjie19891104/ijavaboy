package org.iserver.core;

import java.nio.channels.SocketChannel;

/**
 * @author chenjie
 * 2013-6-8
 */
public interface IDataHandler {
	
	public void handleRead(SocketChannel channel, byte[] data, int len);

	public void handleWrite(SocketChannel channel, byte[] data);
}
