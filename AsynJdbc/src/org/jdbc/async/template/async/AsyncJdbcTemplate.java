package org.jdbc.async.template.async;

import org.jdbc.async.event.UpdateEvent;
import org.jdbc.async.event.UpdateEventManager;
import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.pool.IPoolProvider;
import org.jdbc.async.template.simple.SimpleJdbcTemplate;
import org.jdbc.async.utils.UpdateUtils;

/**
 * 异步Jdbc操作封装
 * @author chenjie
 * 2012-12-1
 */
public class AsyncJdbcTemplate extends SimpleJdbcTemplate {

	private UpdateEventManager asyncEventManager; //异步事务管理器
	
	private AsyncUpdater updater; //异步更新操作
	
	/**
	 * 使用默认的连接池配置
	 */
	public AsyncJdbcTemplate(){
		super();
		this.init();
	}
	
	/**
	 * 使用指定的连接池配置
	 * @param poolProvider
	 */
	public AsyncJdbcTemplate(IPoolProvider poolProvider) {
		super(poolProvider);
		this.init();
	}
	
	private final void init(){
		
		this.asyncEventManager = UpdateEventManager.getInstance();
		
		this.updater = new AsyncUpdater(this.poolProvider);
		
		this.startSyncUpdater();
	}
	
	public AsyncJdbcTemplate(IPoolProvider poolProvider, int updateInterval){
		
		this(poolProvider);
		
		this.updater.setUpdateInterval(updateInterval);
	}
	
	/**
	 * 启动更新线程
	 */
	private void startSyncUpdater(){
		
		new Thread(this.updater).start();
		
	}
	
	/**
	 * 加入缓冲，待持久化
	 */
	@Override
	public void executeUpdate(String sql, Object...params) {
		
		UpdateEvent event = new UpdateEvent(sql, params);
		
		this.asyncEventManager.addUpdateEvent(event);
		
	}
	
	/**
	 * 立即执行一条更新语句
	 * @param sql
	 * @param params
	 * @throws SimpleSQLException
	 */
	public void executeUpdateImmediately(String sql, Object...params) throws SimpleSQLException{
		
		
		UpdateUtils.update(this.poolProvider, sql, params);
	}
}
