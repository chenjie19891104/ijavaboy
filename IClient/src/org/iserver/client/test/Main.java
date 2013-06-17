package org.iserver.client.test;

import org.iserver.client.core.IClient;

/**
 * @author chenjie
 * 2013-6-8
 */
public class Main {

	public static void main(String[] args){
		
		IClient client = new IClient();
		new Thread(client).start();
		client.send("Hi Server 0");
		
	}
	
}
