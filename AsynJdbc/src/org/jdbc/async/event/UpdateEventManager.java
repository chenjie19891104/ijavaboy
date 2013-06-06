package org.jdbc.async.event;

import org.jdbc.async.cache.CacheList;
import org.jdbc.async.cache.DoubleCacheList;

/**
 * 数据库数据更新事件管理器
 * @author chenjie
 * 2012-12-1
 */
public final class UpdateEventManager {

	private static final UpdateEventManager instance = new UpdateEventManager();
	
	private CacheList<UpdateEvent> updateCache;
	
	private UpdateEventManager(){
		
		this.updateCache = new DoubleCacheList<UpdateEvent>();
	}
	
	public static UpdateEventManager getInstance(){
		return instance;
	}
	
	public void addUpdateEvent(UpdateEvent event){
		
		if(event != null){
			
			this.updateCache.write(event);
		}
	}
	
	public UpdateEvent readUpdateEvent(){
		
		return this.updateCache.read();
	}
}
