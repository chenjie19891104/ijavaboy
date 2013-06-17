package org.iserver.protocal.text;

import java.nio.channels.SocketChannel;
import java.util.ArrayList;
import java.util.List;

import org.iserver.data.Packet;
import org.iserver.data.Response;
import org.iserver.data.Session;
import org.iserver.protocal.IEncoder;
import org.iserver.protocal.ProtocalType;

/**
 * @author chenjie
 * 2013-6-9
 */
public class TextEncoder implements IEncoder<Response>{

	@Override
	public Packet encode(Response data) {
		String id = data.getId();
		Object params = data.getParams();
		
		String resData = id + "\\:" + params.toString();
		
		Packet packet = new Packet(resData.getBytes());
		packet.setProtocalType(ProtocalType.TEXT_PROTOCAL.getType());
		
		List<SocketChannel> recipients = new ArrayList<SocketChannel>();
		for(Session session : data.getRecipients()){
			recipients.add(session.getChannel());
		}
		
		return packet;
	}

}
