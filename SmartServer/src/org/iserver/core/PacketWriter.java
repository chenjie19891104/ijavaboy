package org.iserver.core;

import java.util.List;

import org.iserver.data.Packet;
import org.iserver.data.Session;
import org.iserver.manager.SessionManager;

/**
 * @author chenjie
 * 2013-6-8
 */
public class PacketWriter implements Runnable{
	
	private IServer server;
	
	public PacketWriter(IServer server){
		this.server = server;
	}

	@Override
	public void run() {
		
		while(true){
			
			List<Session> sessionList = SessionManager.getInstance().getAllSessions();
			
			for(Session session : sessionList){
				Packet packet = session.popWritablePacket();
				while(packet != null){
					//do the write 
					this.server.getDataHandler().handleWrite(packet.getSender(), packet.getData());
					
					packet = session.popWritablePacket();
				}
			}
			
		}
		
	}

}
