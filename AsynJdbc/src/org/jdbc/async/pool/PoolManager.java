package org.jdbc.async.pool;

import java.util.concurrent.locks.Lock;
import java.util.concurrent.locks.ReentrantLock;

import org.jdbc.async.config.ConfigLoader;
import org.jdbc.async.config.SimpleConfig;
import org.jdbc.async.pool.bonecp.BoneCPProvider;

/**
 * 连接池管理
 * @author chenjie
 * 2012-11-27
 */
@Deprecated
public class PoolManager {
	
	private static PoolManager instance = new PoolManager();
	
	private IPoolProvider defaultProvider;
	
	private Lock defaultLock = new ReentrantLock();
	
	public static PoolManager getInstance(){
		
		return instance;
	}
	
	public void createDefaultProvider(){
		
		SimpleConfig config = ConfigLoader.getInstance().loadDefault();
		
		defaultProvider = new BoneCPProvider(config);
		
	}
	
	public static IPoolProvider getDefaultPoolProvider(){
		
		PoolManager m = PoolManager.getInstance();
		
		if(m.defaultProvider == null){
		
			m.defaultLock.lock();
			m.createDefaultProvider();
			m.defaultLock.unlock();
			
		}
		
		return m.defaultProvider;

	}

}
