package org.iserver.protocal.text;

import org.iserver.data.Event;
import org.iserver.data.Packet;
import org.iserver.protocal.IProtocalHandler;
import org.iserver.protocal.ProtocalType;

/**
 * @author chenjie
 * 2013-6-13
 */
public class TextProtocalHandler implements IProtocalHandler<Event> {

	@Override
	public Packet encode(Event data) {
		String id = data.getId();
		Object params = data.getParams();
		
		String resData = id + "\\:" + params.toString();
		
		Packet packet = new Packet(resData.getBytes());
		packet.setProtocalType(ProtocalType.TEXT_PROTOCAL.getType());
		
		return packet;
	}

	@Override
	public Event decode(Packet packet) {
		
		String msg = new String(packet.getData());

		String[] slices = msg.split("\\:");

		if (slices.length == 2) {
			return new Event(slices[0], slices[1]);
		} else {
			// not match the protocal
			System.out.println("Drop a packet not match the protocal text");
			return null;
		}
	}

}
