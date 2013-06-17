package org.iserver.core;

import java.util.List;

import org.iserver.data.Packet;
import org.iserver.data.Request;
import org.iserver.data.Session;
import org.iserver.manager.SessionManager;

/**
 * @author chenjie
 * 2013-6-8
 */
public class PacketReader implements Runnable{
	
	private IServer server;
	
	public PacketReader(IServer server){
		this.server = server;
	}

	@Override
	public void run() {
		
		while(true){
			List<Session> sessionList = SessionManager.getInstance().getAllSessions();
			
			for(Session session : sessionList){
			
				Packet packet = session.popReadablePacket();
				while(packet != null){
					
					Request request = this.server.getDecoder().decode(packet);
					
					if(request != null){
						
					}
					
					String data = new String(packet.getData());
					
					System.out.println(data);
					
					String returnData = "reto:"+data;
					packet.setData(returnData.getBytes());
					session.addWritablePacket(packet);
					
					packet = session.popReadablePacket();
				}
				
			}
			
			try {
				Thread.sleep(300);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
		}

		
	}

}
