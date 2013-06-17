package org.iserver.data;

import java.nio.channels.SelectionKey;
import java.nio.channels.SocketChannel;
import java.util.concurrent.BlockingQueue;
import java.util.concurrent.LinkedBlockingQueue;

/**
 * @author chenjie
 * 2013-6-8
 */
public class Session {
	
	private SocketChannel channel;
	private SelectionKey selectionKey;
	
	private BlockingQueue<Packet> readQueue;	//读队列
	private BlockingQueue<Packet> writeQueue;	//写队列
	
	public Session(SocketChannel client, SelectionKey key){
		this.channel = client;
		this.selectionKey = key;
		this.readQueue = new LinkedBlockingQueue<Packet>();
		this.writeQueue = new LinkedBlockingQueue<Packet>();
	}
	
	//增加可读的包
	public void addReadablePacket(Packet packet){
		try {
			this.readQueue.put(packet);
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}
	
	//获取一个可读的包
	public Packet popReadablePacket(){
		return this.readQueue.poll();
	}
	
	//增加可写的包
	public void addWritablePacket(Packet packet){
		try {
			this.writeQueue.put(packet);
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}
	
	//获取一个可写的包
	public Packet popWritablePacket(){
		return this.writeQueue.poll();
	}

	public final SocketChannel getChannel() {
		return channel;
	}

	public final void setChannel(SocketChannel channel) {
		this.channel = channel;
	}

	public final SelectionKey getSelectionKey() {
		return selectionKey;
	}

	public final void setSelectionKey(SelectionKey selectionKey) {
		this.selectionKey = selectionKey;
	}

	public final BlockingQueue<Packet> getReadQueue() {
		return readQueue;
	}

	public final void setReadQueue(BlockingQueue<Packet> readQueue) {
		this.readQueue = readQueue;
	}

	public final BlockingQueue<Packet> getWriteQueue() {
		return writeQueue;
	}

	public final void setWriteQueue(BlockingQueue<Packet> writeQueue) {
		this.writeQueue = writeQueue;
	}



	
}
