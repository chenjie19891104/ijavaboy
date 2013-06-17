package org.iserver.manager;

import java.nio.channels.SelectionKey;
import java.nio.channels.SocketChannel;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;

import org.iserver.data.Session;

/**
 * @author chenjie
 * 2013-6-8
 */
public class SessionManager {
	
	private static SessionManager instance;
	
	private Map<SocketChannel, Session> sessionMap;
	
	private SessionManager(){
		sessionMap = new ConcurrentHashMap<SocketChannel, Session>();
	}
	
	public static SessionManager getInstance(){
		if(instance == null){
			instance = new SessionManager();
		}
		return instance ;
	}
	
	public void addNewSession(SocketChannel client, SelectionKey key){
		
		if(!this.sessionMap.containsKey(client)){
			this.sessionMap.put(client, new Session(client, key));
		}
	}
	
	public Session getSession(SocketChannel client){
		if(this.sessionMap.containsKey(client)){
			return this.sessionMap.get(client);
		}
		return null;
	}
	
	public List<Session> getAllSessions(){
		
		return new ArrayList<Session>(this.sessionMap.values());
	}
	
}
