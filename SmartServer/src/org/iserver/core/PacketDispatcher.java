package org.iserver.core;

import java.nio.channels.SocketChannel;

import org.iserver.data.Packet;
import org.iserver.data.Response;
import org.iserver.data.Session;
import org.iserver.manager.SessionManager;
import org.iserver.protocal.IEncoder;
import org.iserver.protocal.text.TextEncoder;

/**
 * @author chenjie
 * 2013-6-13
 */
public class PacketDispatcher {

	private static PacketDispatcher instance;
	
	private IEncoder<Response> encoder;
	
	private PacketDispatcher(){
		this.encoder = new TextEncoder();
	}
	
	public static PacketDispatcher getInstance(){
		if(instance == null){
			instance = new PacketDispatcher();
		}
		return instance;
	}
	
	//Ð´Êý¾Ý
	public void write(Response res){
		
		Packet packet = this.encoder.encode(res);
		if(res.getRecipients() != null){

			for(SocketChannel recv : packet.getRecipients()){
				Session session = SessionManager.getInstance().getSession(recv);
				if(session != null){
					Packet tmpPacket = new Packet(recv, packet.getData());
					session.addWritablePacket(tmpPacket);
				}
			}
				
		}
	}
	
}
