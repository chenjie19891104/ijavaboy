package org.iserver.protocal.text;

import org.iserver.data.Packet;
import org.iserver.data.Request;
import org.iserver.data.Session;
import org.iserver.manager.SessionManager;
import org.iserver.protocal.IDecoder;

/**
 * 解析[命令;参数]格式的协议
 * 
 * @author chenjie 2013-6-8
 */
public class TextDecoder implements IDecoder<Request> {

	@Override
	public Request decode(Packet packet) {

		String msg = new String(packet.getData());

		String[] slices = msg.split("\\:");

		if (slices.length == 2) {
			Session sender = SessionManager.getInstance().getSession(packet.getSender());
			return new Request(slices[0], slices[1], sender);
		} else {
			// not match the protocal
			System.out.println("Drop a packet not match the protocal text");
			return null;
		}

	}
}
