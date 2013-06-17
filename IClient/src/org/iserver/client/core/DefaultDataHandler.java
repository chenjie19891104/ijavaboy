package org.iserver.client.core;

import org.iserver.data.Event;
import org.iserver.data.Packet;

/**
 * @author chenjie 2013-6-8
 */
public class DefaultDataHandler implements IDataHandler, Runnable {

	private IClient client;

	public DefaultDataHandler(IClient client) {
		this.client = client;
	}

	@Override
	public void handleRead(byte[] data, int len) {

		byte[] readed = new byte[len];

		System.arraycopy(data, 0, readed, 0, len);

		this.client.getReadData().add(new Packet(readed));

	}

	@Override
	public void run() {

		int count = 1;
		while (true) {

			Packet packet = this.client.getReadData().poll();

			while (packet != null) {
				Event event = client.getProtocalHandler().decode(packet);
				
				
				
				packet = this.client.getReadData().poll();
				
			}

			try {
				Thread.sleep(1000);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}

			this.client.send("Hi server " + count);
			count++;
		}

	}

}
