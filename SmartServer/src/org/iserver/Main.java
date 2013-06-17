package org.iserver;

import org.iserver.core.IServer;
import org.iserver.core.PacketReader;
import org.iserver.core.PacketWriter;

/**
 * @author chenjie
 * 2013-6-7
 */
public class Main {
	
	public static void main(String[] args){
		
		IServer server = new IServer();
		server.bind(9900);
		
		PacketReader reader = new PacketReader(server);
		PacketWriter writer = new PacketWriter(server);
		new Thread(server).start();
		new Thread(reader).start();
		new Thread(writer).start();
	}

}
