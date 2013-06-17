package org.iserver;

import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import org.iserver.core.IServer;
import org.iserver.core.PacketReader;
import org.iserver.core.PacketWriter;
import org.iserver.protocal.IDecoder;

/**
 * @author chenjie
 * 2013-6-13
 */
public class IServerEngine {
	private static IServerEngine instance;
	
	private ExecutorService coreExecutors;
	private ExecutorService workExecutors;
	
	private IServer acceptor;
	private PacketReader reader;
	private PacketWriter writer;
	
	
	private IServerEngine(){
		
	}
	
	public static IServerEngine getInstance(){
		if(instance == null){
			instance = new IServerEngine();
			
		}
		return instance;
	}
	
	public void init(){
		coreExecutors = Executors.newFixedThreadPool(3);
		workExecutors = Executors.newCachedThreadPool();
		
		acceptor = new IServer();
		reader = new PacketReader(acceptor);
		writer = new PacketWriter(acceptor);
		
	}

	public void start(){
		
		coreExecutors.execute(acceptor);
		coreExecutors.execute(reader);
		coreExecutors.execute(writer);
	}
}
