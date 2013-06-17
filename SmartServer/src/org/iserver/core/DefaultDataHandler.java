package org.iserver.core;

import java.nio.channels.SocketChannel;

import org.iserver.data.Packet;
import org.iserver.data.Session;
import org.iserver.manager.SessionManager;

/**
 * @author chenjie
 * 2013-6-8
 */
public class DefaultDataHandler implements IDataHandler {
	
	private IServer server;
	
	public DefaultDataHandler(IServer server){
		this.server = server;
	}

	@Override
	public void handleRead(SocketChannel channel, byte[] data, int len) {
		
		Session session = SessionManager.getInstance().getSession(channel);
		
		if(session != null){
			byte[] dest = new byte[len];
			System.arraycopy(data, 0, dest, 0, len);
			session.addReadablePacket(new Packet(channel, dest));
		}
		
	}

	@Override
	public void handleWrite(SocketChannel channel, byte[] data) {
		
		this.server.addWritableData(channel, data);
		
	}

}
