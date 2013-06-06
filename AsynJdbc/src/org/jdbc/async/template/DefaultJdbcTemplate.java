package org.jdbc.async.template;

import java.sql.SQLException;

import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.pool.IPoolProvider;
import org.jdbc.async.transaction.TransactionCallback;
import org.jdbc.async.transaction.TransactionUtils;
import org.jdbc.async.utils.UpdateUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * 实现<code>IJdbcTemplate</code>默认的行为，包括初始化，销毁，更新等
 * @author chenjie
 * 2012-12-4
 */
public abstract class DefaultJdbcTemplate<T> implements IJdbcTemplate<T> {
	
	private final Logger logger = LoggerFactory.getLogger(DefaultJdbcTemplate.class);
	
	protected IPoolProvider poolProvider;
	
	public DefaultJdbcTemplate(){
		
	}
	
	public DefaultJdbcTemplate(IPoolProvider poolProvider){
		
		this.init(poolProvider);

	}

	private final void init(IPoolProvider poolProvider){

		this.poolProvider = poolProvider;
		
		if(this.poolProvider == null){
			try {
				throw new SQLException("Init pool failed : the pool provider is null");
			
			} catch (SQLException e) {
				logger.error(e.getMessage());
				e.printStackTrace();
			}
		}
	}

	@Override
	public void destroy() {

		this.poolProvider.destroy();

	}
	
	@Override
	public void executeUpdate(String sql, Object...params) throws SimpleSQLException{
		
		UpdateUtils.update(this.poolProvider, sql, params);
	}
	
	@Override
	public Object runInTransaction(TransactionCallback callback){
		
		return TransactionUtils.runInTransaction(this.poolProvider, callback);
	}

}
