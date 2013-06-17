package org.iserver.client.core;

import java.io.IOException;
import java.net.InetSocketAddress;
import java.nio.ByteBuffer;
import java.nio.channels.SelectionKey;
import java.nio.channels.Selector;
import java.nio.channels.SocketChannel;
import java.util.Iterator;
import java.util.Queue;
import java.util.Set;
import java.util.concurrent.LinkedBlockingQueue;

import org.iserver.data.Event;
import org.iserver.data.Packet;
import org.iserver.protocal.IProtocalHandler;
import org.iserver.protocal.text.TextProtocalHandler;

/**
 * @author chenjie 2013-6-8
 */
public class IClient implements Runnable {

	private ByteBuffer readBuffer; // 读取缓冲

	private Selector selector;

	private SocketChannel client;

	private Queue<ByteBuffer> pendingData; // 待写入的数据
	private Queue<Packet> readData; // 读取的数据

	private IDataHandler dataHandler; // 数据处理

	private IProtocalHandler<Event> protocalHandler; // 协议处理

	public IClient() {
		this.readBuffer = ByteBuffer.allocate(2048);
		this.pendingData = new LinkedBlockingQueue<ByteBuffer>();
		this.readData = new LinkedBlockingQueue<Packet>();
		
		this.protocalHandler = new TextProtocalHandler();
		
		DefaultDataHandler handler = new DefaultDataHandler(this);
		this.dataHandler = handler;
		new Thread(handler).start();
		init();
	}

	private void init() {
		try {
			this.selector = Selector.open();
			this.client = SocketChannel.open();
			this.client.configureBlocking(false);
			this.client.register(this.selector, SelectionKey.OP_CONNECT);
			this.client.connect(new InetSocketAddress(9900));
		} catch (IOException e) {
			e.printStackTrace();
		}
	}

	// 发送数据
	public void send(String data) {

		this.addWritableData(data.getBytes());
	}

	// 添加需要写入的数据
	public void addWritableData(byte[] data) {

		this.pendingData.add(ByteBuffer.wrap(data));

		this.selector.wakeup();
	}

	// 完成连接
	private void finishConnection(SelectionKey key) {
		SocketChannel channel = (SocketChannel) key.channel();
		try {
			channel.finishConnect();
		} catch (IOException e) {
			key.cancel();
			e.printStackTrace();
		}
		key.interestOps(SelectionKey.OP_WRITE);
	}

	// 写数据
	private void write(SelectionKey key) {

		SocketChannel channel = (SocketChannel) key.channel();
		while (!this.pendingData.isEmpty()) {
			ByteBuffer buffer = this.pendingData.poll();
			try {
				channel.write(buffer);
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		key.interestOps(SelectionKey.OP_READ);
	}

	// 读取数据
	private void read(SelectionKey key) {
		this.readBuffer.clear();
		SocketChannel channel = (SocketChannel) key.channel();
		try {
			int size = channel.read(this.readBuffer);

			if (size == -1) {
				key.cancel();
				return;
			}

			if (this.dataHandler != null) {
				this.dataHandler.handleRead(this.readBuffer.array(), size);
			} else {
				System.out.println("The data handler not specified");
			}

		} catch (IOException e) {
			key.cancel();
			e.printStackTrace();
		}

		key.interestOps(SelectionKey.OP_WRITE);
	}

	@Override
	public void run() {

		while (true) {

			try {

				this.selector.select();
				Set<SelectionKey> keys = this.selector.selectedKeys();
				Iterator<SelectionKey> keyItors = keys.iterator();
				while (keyItors.hasNext()) {
					SelectionKey key = keyItors.next();
					if (!key.isValid()) {
						continue;
					}

					if (key.isConnectable()) {
						// finishConnection
						this.finishConnection(key);
					} else if (key.isReadable()) {
						// read data
						this.read(key);
					} else if (key.isWritable()) {
						// write data
						this.write(key);
					}
				}

			} catch (IOException e) {
				try {
					this.selector.close();
				} catch (IOException e1) {
					e1.printStackTrace();
				}
			}

		}

	}

	public final Queue<Packet> getReadData() {
		return readData;
	}
	
	public final IProtocalHandler<Event> getProtocalHandler(){
		
		return this.protocalHandler;
	}
	

}
