package org.jdbc.async.template.async;

import java.util.concurrent.atomic.AtomicInteger;

import org.jdbc.async.event.UpdateEvent;
import org.jdbc.async.event.UpdateEventManager;
import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.pool.IPoolProvider;
import org.jdbc.async.utils.UpdateUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * 异步更新操作执行线程
 * @author chenjie
 * 2012-12-1
 */
public class AsyncUpdater implements Runnable {
	private final static Logger logger = LoggerFactory.getLogger(AsyncUpdater.class);

	private final static Integer DEFAULT_UPDATE_INTERVAL = 1000; //ms;
	
	private final AtomicInteger threadId = new AtomicInteger();
	private int updateInterval = AsyncUpdater.DEFAULT_UPDATE_INTERVAL; //当读队列为空时，隔updateInterval再次尝试
	
	private UpdateEventManager eventManager;
	private IPoolProvider poolProvider;
	
	/**
	 * 指定连接池
	 * @param provider
	 */
	public AsyncUpdater(IPoolProvider provider){
		this.eventManager = UpdateEventManager.getInstance();
		this.poolProvider = provider;
	}
	
	/**
	 * 指定连接池和更新间隔
	 * @param provider
	 * @param updateInterval
	 */
	public AsyncUpdater(IPoolProvider provider, int updateInterval){
		this(provider);
		this.updateInterval = updateInterval;
	}
	
	@Override
	public void run() {
		
		Thread.currentThread().setName("AsyncUpdater-"+threadId.incrementAndGet());
		
		while(true){
			
			UpdateEvent event = null;
			while((event = this.eventManager.readUpdateEvent()) != null){
				
				try {
					
					UpdateUtils.update(poolProvider, event.getSql(), event.getParams());
					
				} catch (SimpleSQLException e) {
					//这里提供日志记录
					e.printStackTrace();
					
				}
			}
			
			try {
				logger.debug("The read queue is empty......" + System.currentTimeMillis());
				Thread.sleep(this.updateInterval);
				
			} catch (InterruptedException e) {
				
				e.printStackTrace();
			}
		}
		
	}

	public final int getUpdateInterval() {
		return updateInterval;
	}

	public final void setUpdateInterval(int updateInterval) {
		this.updateInterval = updateInterval;
	}

	
}
