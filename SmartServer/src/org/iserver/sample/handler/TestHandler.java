package org.iserver.sample.handler;

import org.iserver.core.PacketDispatcher;
import org.iserver.data.Request;
import org.iserver.data.Response;
import org.iserver.sample.CommandEnum;
import org.iserver.sample.IRequestHandler;

/**
 * @author chenjie
 * 2013-6-13
 */
public class TestHandler implements IRequestHandler {

	@Override
	public void handleRequest(Request request) {
		
		System.out.println("Test Handler Begin.....");
		
		System.out.println("Params:"+request.getParams().toString());
		
		Response res = new Response(CommandEnum.RES_TEST, "haha", request.getSender());
		
		PacketDispatcher.getInstance().write(res);
	}

}
